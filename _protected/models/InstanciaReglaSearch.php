<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InstanciaRegla;

/**
 * app\models\InstanciaReglaSearch represents the model behind the search form about `app\models\InstanciaRegla`.
 */
 class InstanciaReglaSearch extends InstanciaRegla
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_instancia'], 'integer'],
            [['regla'], 'safe'],
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
        $query = InstanciaRegla::find();

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
            'id_instancia' => $this->id_instancia,
        ]);

        $query->andFilterWhere(['like', 'regla', $this->regla]);

        return $dataProvider;
    }
}
