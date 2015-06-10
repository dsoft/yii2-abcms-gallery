<?php

namespace abcms\gallery\module\models;

use Yii;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property integer $albumId
 * @property string $image
 * @property integer $active
 * @property integer $deleted
 * @property integer $ordering
 */
class GalleryImage extends \abcms\library\base\BackendActiveRecord
{
    public static $enableTime = false;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'ordering'], 'integer'],
            [['image'], 'image', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'albumId' => 'Album ID',
            'image' => 'Image',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'ordering' => 'Ordering',
        ];
    }
    
    public function getAlbum()
    {
        return $this->hasOne(GalleryAlbum::className(), ['id' => 'albumId']);
    }
    
    public function returnImageLink($size = null){
        $imageName = $this->image;
        $album = $this->album;
        $folder = $album->returnFolderName();
        $directory = Yii::getAlias('@web/uploads/albums/'.$folder.'/');
        if($size){
            $directory .= $size.'/';
        }
        $link = $directory.$imageName;
        return $link;
    }
}
