<?php

namespace buddysoft\widgets;

class GallerySelector extends \yii\base\Widget {
    const WIDGET_NAME = 'gallery-selector';

    public $images = [];
    public $id;
    public $title = "Images";
    public $modalTitle = "请选择";
    public $uploadKey = "uploaded-images[]";
    
    public $defaultImage = null;
    public $relatedId = null;

    public function run() {
        return $this->render('gallery-selector', [
            'defaultImage' => $this->defaultImage,
            'relatedId' => $this->relatedId,

            'images' => $this->images,
            'title' => $this->title,
            'modalTitle' => $this->modalTitle,
            'uploadKey' => $this->uploadKey,
            'id' => (!empty($this->id)) ? $this->id : 'timeline-widget-' . $this->getId()
        ]);
    }
}
?>
