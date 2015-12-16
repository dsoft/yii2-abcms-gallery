<?php

namespace abcms\gallery\module\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use abcms\library\helpers\Image;

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
class GalleryAlbum extends \abcms\library\base\BackendActiveRecord
{

    public static $enableTime = false;
    public $images = null;

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

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => \abcms\multilanguage\ModelBehavior::className(),
                'attributes' => [
                    'title',
                ],
            ],
        ]);
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

    /**
     * Return the album categories array with the id as key and name as value, used in drop down lists
     * @return array
     */
    public static function returnCategoriesList()
    {
        $array = [];
        $categories = self::categories();
        foreach($categories as $key => $category) {
            if(isset($category['name'])) {
                $array[$key] = $category['name'];
            }
        }
        return $array;
    }

    /**
     * Return the album category name
     * @return string|null
     */
    public function returnCategoryName()
    {
        $return = null;
        $categories = self::categories();
        if(isset($categories[$this->categoryId]['name'])) {
            $return = $categories[$this->categoryId]['name'];
        }
        return $return;
    }

    /**
     * Read uploaded images and save them to this album
     * @param GalleryImage $imageModel if provided, image will replace its value in the db, no new GalleryImage models will be created
     * @throws ErrorException if image folder can't be created
     */
    public function saveImages($imageModel = null)
    {
        $owner = $this;
        $attribute = 'images';
        $files = UploadedFile::getInstances($owner, $attribute);
        if($files && is_array($files)) {
            foreach($files as $file) {
                $fileName = $this->returnImageNamePrefix();
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
                            Image::saveSizes($directory, $randomName, $this->getImageSizes());
                        }
                    }
                }
                else {
                    throw new ErrorException('Unable to create directoy.');
                }
            }
        }
    }

    /**
     * Return the image name prefix, taken from the category name
     * @return string
     */
    public function returnImageNamePrefix()
    {
        $return = 'image';
        $categoryName = $this->returnCategoryName();
        if($categoryName){
            $return = strtolower($categoryName);
        }
        return $return;
    }

    /**
     * Return the images main folder name, taken from the ctegory name
     * @return string
     */
    public function returnFolderName()
    {
        $return = 'image';
        $categoryName = $this->returnCategoryName();
        if($categoryName){
            $return = strtolower($categoryName);
        }
        return $return;
    }

    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['albumId' => 'id']);
    }

    public function getActiveImages()
    {
        return $this->hasMany(GalleryImage::className(), ['albumId' => 'id'])->active();
    }

    /**
     * Return the list of categories with their sizes
     * It should be set in the application params: ['gallery']['categories']
     * Example:
     * 'gallery' => [
     *   'categories' => [
     *       1 => [
     *           'name' => 'Products',
     *           'sizes' => [
     *               'thumbs' => [
     *                   'width' => 440,
     *                   'height' => 440,
     *               ],
     *           ],
     *      ],
     *   ],
     * ],
     * @return array
     */
    public static function categories()
    {
        return isset(Yii::$app->params['gallery']['categories']) ? Yii::$app->params['gallery']['categories'] : [];
    }
    
    /**
     * Get the image sizes of this album from the category configuration
     * @return array
     */
    public function getImageSizes(){
        $categories = self::categories();
        $sizes = [];
        if(isset($categories[$this->categoryId]['sizes'])) {
            $sizes = $categories[$this->categoryId]['sizes'];
        }
        return $sizes;
    }

}
