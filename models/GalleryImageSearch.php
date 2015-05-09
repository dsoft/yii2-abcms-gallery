<?php

namespace abcms\galleryModule\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GalleryImageSearch represents the model behind the search form about `app\models\GalleryImage`.
 */
class GalleryImageSearch extends GalleryImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'albumId', 'active', 'deleted', 'ordering'], 'integer'],
            [['image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GalleryImage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'albumId' => $this->albumId,
            'active' => $this->active,
            'deleted' => $this->deleted,
            'ordering' => $this->ordering,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
