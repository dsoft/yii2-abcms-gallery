<?php

namespace abcms\galleryModule\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "gallery_album".
 *
 * @property integer $id
 * @property string $title
 * @property integer $categoryId
 * @property integer $active
 * @property integer $deleted
 * @property integer $ordering
 */
class GalleryAlbum extends \abcms\base\BackendActiveRecord
{

    public $enableTime = false;
    public $images = null;
    public static $categories = [
        1 => [
            'name' => 'Event',
            'sizes' => [
                'thumbs' => [
                    'width' => 472,
                    'height' => 278,
                ],
            ],
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'categoryId'], 'required'],
            [['categoryId', 'active', 'ordering'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['images'], 'image', 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'categoryId' => 'Category ID',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'ordering' => 'Ordering',
        ];
    }

    public static function returnCategoriesList()
    {
        $array = [];
        $categories = self::$categories;
        foreach($categories as $key => $category) {
            if(isset($category['name'])) {
                $array[$key] = $category['name'];
            }
        }
        return $array;
    }

    public function returnCategoryName()
    {
        $return = null;
        if(self::$categories[$this->categoryId]['name']) {
            $return = self::$categories[$this->categoryId]['name'];
        }
        return $return;
    }

    public function saveImages($imageModel = null)
    {
        $owner = $this;
        $attribute = 'images';
        $files = UploadedFile::getInstances($owner, $attribute);
        if($files && is_array($files)) {
            foreach($files as $file) {
                $fileName = $this->returnImageName();
                $folderName = $this->returnFolderName();
                $randomName = $fileName."_".time().mt_rand(10, 99).".".$file->extension;
                $directory = Yii::getAlias('@webroot/uploads/albums/'.$folderName.'/');
                if(FileHelper::createDirectory($directory)) {
                    $mainImagePath = $directory.$randomName;
                    if($file->saveAs($mainImagePath)) {
                        if(!$imageModel) {
                            $model = new GalleryImage;
                            $model->albumId = $this->id;
                        }
                        else {
                            $model = $imageModel;
                        }
                        $model->image = $randomName;
                        if($model->save(false)) {
                            $this->saveSizes($directory, $randomName);
                        }
                    }
                }
                else {
                    throw new ErrorException('Unable to create directoy.');
                }
            }
        }
    }

    public function returnImageName()
    {
        $return = 'image';
        if(isset(self::$categories[$this->categoryId]['name'])) {
            $return = strtolower(self::$categories[$this->categoryId]['name']);
        }
        return $return;
    }

    public function returnFolderName()
    {
        $return = 'image';
        if(isset(self::$categories[$this->categoryId]['name'])) {
            $return = strtolower(self::$categories[$this->categoryId]['name']);
        }
        return $return;
    }

    protected function saveSizes($mainFolder, $imageName)
    {
        if(isset(self::$categories[$this->categoryId]['sizes'])) {
            $sizes = (array) self::$categories[$this->categoryId]['sizes'];
            foreach($sizes as $name => $size) {
                if(isset($size['width'], $size['height'])) {
                    $folderName = $mainFolder.$name.'/';
                    if(FileHelper::createDirectory($folderName)) {
                        Image::thumbnail($mainFolder.$imageName, $size['width'], $size['height'])->save($folderName.$imageName);
                    }
                    else {
                        throw new ErrorException('Unable to create directoy.');
                    }
                }
            }
        }
    }

    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['albumId' => 'id']);
    }
    
    public function getActiveImages(){
        return $this->hasMany(GalleryImage::className(), ['albumId' => 'id'])->active();
    }

}
