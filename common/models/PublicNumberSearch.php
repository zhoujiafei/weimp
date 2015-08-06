<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PublicNumber;

/**
 * PublicNumberSearch represents the model behind the search form about `common\models\PublicNumber`.
 */
class PublicNumberSearch extends PublicNumber
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'create_time', 'update_time', 'order_id'], 'integer'],
            [['name', 'appid', 'appsecret', 'encoding_aes_key', 'url', 'token'], 'safe'],
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
        $query = PublicNumber::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'order_id' => $this->order_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'appid', $this->appid])
            ->andFilterWhere(['like', 'appsecret', $this->appsecret])
            ->andFilterWhere(['like', 'encoding_aes_key', $this->encoding_aes_key])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
