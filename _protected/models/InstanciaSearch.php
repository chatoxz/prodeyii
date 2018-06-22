<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Instancia;

/**
 * app\models\InstanciaSearch represents the model behind the search form about `app\models\Instancia`.
 */
 class InstanciaSearch extends Instancia
{
    public $torneo_nombre;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_torneo', 'max_participantes', 'id_user','torneo_nombre'], 'integer'],
            [['nombre'], 'safe'],
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
        $query = Instancia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes'=>[
                'id', 'id_torneo', 'max_participantes', 'id_user','torneo_nombre','nombre'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //if (Yii::$app->user->getId() != 1 && Yii::$app->user->getId() != 2 && Yii::$app->user->getId() != 3 )
        $this->id_user = Yii::$app->user->getId();

        $query->andFilterWhere([
            'id' => $this->id,
            'id_torneo' => $this->id_torneo,
            'id_user' => $this->id_user,
            'max_participantes' => $this->max_participantes,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
