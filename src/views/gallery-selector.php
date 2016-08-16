<?php
    \buddysoft\widgets\GallerySelectorAssets::register($this);
?>

<div id="<?=$id?>" class="gallery-selector-widget">
    <div class="clearfix">
        <div>
            <!-- <label for=""><?=$title?></label> -->
            <div class="no-image-selected" style="display:none">没有选择图片</div>
            <div class="selected-images">
                <div class="selected-img" style="background-image: url('<?= $defaultImage['url']?>')" data-image-id="<?= $defaultImage['id'] ?>" related-id="<?= $relatedId ?>"
                        <input type="hidden" name="selected-image-ids[]" value="<?= $defaultImage['id']?>">
                        <!-- <span class="glyphicon glyphicon-remove-sign remove-selected-image"> </span> -->
                </div>
            </div>
            <div class="clearfix"></div>
            <button type="button" data-toggle="modal" data-target="#<?=$id?>-modal" class="btn btn-sm btn-default btn-select-images" style="margin-top: 5px;">选择图片</button>
        </div>
    </div>

    <div id="<?=$id?>-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">                    

                    <a class="close" data-dismiss="modal">&times;</a>
                    <h4><?=$modalTitle?></h4>

                    <form class="form-inline">
                      <div class="form-group">
                        <!-- <label for="exampleInputName2">名字</label> -->
                        <input type="text" class="form-control" id="image-name" placeholder="输入食物名字进行搜索">
                        <input type="text" class="form-control" id="image-pinyin" placeholder="输入食物字母进行搜索">
                      </div>
                      <!-- <button type="submit" class="btn btn-default">查询</button> -->
                    </form>

                </div>

                <div class="modal-body">
                    <div class="tab-pane gallery-selector-container" id="select_from_gallery">
                        <div class="images-list">
                            <?php foreach ($images as $index => $image): ?>
                                <div type="button" class="gallery-selector-image gallery-image-select" data-image-id="<?=$image['id']?>" data-image-name="<?=isset($image['name']) ? $image['name'] : $id . '-image-' . $index ?>" style="background-image: url('<?=$image['url']?>');" data-image-url="<?=$image['url']?>">
                                    <span class="glyphicon glyphicon-check"></span>
                                    <h5 style="background:#eaded2;opacity:0.7; height:20px; padding:2px;"><?= $image['name'] ?></h5>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <!-- <button type="button" class="btn btn-primary gallery-image-select" style="margin-left: 5px; margin-top: 10px;">确定</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php
    // 生成所有待选图片的 js 数据对象，用于筛选。
    // 由于界面上摆放了 5 个类似控件，所以要用不同的名字区分各自对应的可选图片数组.
    $imageObjects = 'images_' . str_replace('-', '_', $relatedId);
    echo "var $imageObjects = [";
    foreach ($images as $image) {
        echo "\n  {\n";
        echo "    id:" . $image['id'] . ",";
        echo "    name:'" . $image['name'] . "',";
        echo "    url:'" . $image['url'] . "',";
        echo "    letter:'" . $image['firstLetter'] . "'";
        echo "\n  },";
    }
    echo "];";
?>
  
/**
 *
 * 根据用户输入的内容，筛选图片，并展示在界面中中
 *
 */
 function filterImages(images, name, divId){
    console.log('log in filterImages:' + name);

    console.log(images);

    filteredImages = [];
    images.forEach(function (item, index, array){
        console.log(item.name);
        if (item.name.includes(name)) {
            filteredImages.push(item);
        }
    });

    // 清空原先的图片列表
    let elements = $('div #' + divId + ' .gallery-selector-image');
    elements.remove();

    // 把筛选后的图片一张张加入列表
    let imagesList = $('div #' + divId + ' .images-list');
    console.log(imagesList);
    filteredImages.forEach(function(item, index, array){
        imageDiv = '<div class="gallery-image-select gallery-selector-image" ' + 
            'data-image-id="' + item.id + '" ' + 
            'data-image-name="' + item.name + '" ' + 
            'style="background-image: url(' + '\'' + item.url + '\');" ' + 
            'data-image-url="' + item.url + '"> ' + 
            '<span class="glyphicon glyphicon-check"></span>' + 
            '<h5 style="background:#eaded2;opacity:0.7; height:20px; padding:2px;">' + item.name + '</h5></div>';
        console.log(imageDiv);
        imagesList.add(imageDiv).appendTo(imagesList);
    });
 }

 /**
 *
 * 根据用户输入的内容，筛选图片，并展示在界面中中
 *
 */
 function filterImagesByPinyin(images, letter, divId){
    console.log('log in filterImages:' + letter);

    console.log(images);

    filteredImages = [];
    images.forEach(function (item, index, array){
        console.log(item.letter);
        if (item.letter.includes(letter)) {
            filteredImages.push(item);
        }
    });

    // 清空原先的图片列表
    let elements = $('div #' + divId + ' .gallery-selector-image');
    elements.remove();

    // 把筛选后的图片一张张加入列表
    let imagesList = $('div #' + divId + ' .images-list');
    console.log(imagesList);
    filteredImages.forEach(function(item, index, array){
        imageDiv = '<div class="gallery-selector-image" ' + 
            'data-image-id="' + item.id + '" ' + 
            'data-image-name="' + item.name + '" ' + 
            'style="background-image: url(' + '\'' + item.url + '\');" ' + 
            'data-image-url="' + item.url + '"> ' + 
            '<span class="glyphicon glyphicon-check"></span>' + 
            '<h5 style="background:#eaded2;opacity:0.7; height:20px; padding:2px;">' + item.name + '</h5></div>';
        console.log(imageDiv);
        imagesList.add(imageDiv).appendTo(imagesList);
    });
 }
    
</script>


<?php

// 这段代码用到了 jQuery，所以必须通过 View::registerJS 注入
$script = <<<JS
    $(document).ready(function(){
        $('#$id input#image-name').keydown(function(event){
            // 用户按下回车后，开始根据输入的内容筛选照片
            if (event.keyCode == 13) {
                filterImages($imageObjects, $(this).val(), '$id');
                event.preventDefault();
                return false;
            }
        });

        $('#$id input#image-pinyin').keydown(function(event){
            // 用户按下回车后，开始根据输入的内容筛选照片
            if (event.keyCode == 13) {
                filterImagesByPinyin($imageObjects, $(this).val(), '$id');
                event.preventDefault();
                return false;
            }
        });
    });

    $('div #' + '$id').on('hidden.bs.modal', function(){
        // 关闭界面前，恢复最开始的图片列表，并清除搜索内容
        filterImages($imageObjects, '', '$id');
        $('#$id input#image-name').val('');
    });
JS;
$this->registerJS($script, \yii\web\View::POS_END);


$script = <<<JS
    var _context = $("#{$id}");
    var _container = _context.find('.gallery-selector-container .images-list');
    var _selected = _context.find('.selected-images');
    var _blank = _context.find('.no-image-selected');

    _context.data('imageselector', {
        setGalleryImages: function(images){
            if (images && images instanceof Array) {
                this.clear();
                $.each(images, function(index, el){
                    if(el instanceof Object && el.id && el.url){
                        var name = (el.name) ? el.name : "{$id}_image_" + index;
                        var template =  '<div class="gallery-selector-image" data-image-id="' + el.id + '" data-image-name="' + name + '" style="background-image: url(\'' + el.url + '\');" data-image-url="' + el.url + '"><span class="glyphicon glyphicon-check"></span></div>';
                        _container.append(template);
                    } else {
                        console.error("Invalid object found in images array: ", el);
                    }
                });
            } else {
                console.error("images array required.");
            }
        },
        clear: function(){
            _container.html('');
            _selected.html('');
            _context.find('.gallery-uploader-image').remove();
            _blank.show();
        }
    });
JS;

$this->registerJS($script);
?>
