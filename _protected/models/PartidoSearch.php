<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Partido;

/**
 * PartidoSearch represents the model behind the search form about `app\models\Partido`.
 */
class PartidoSearch extends Partido
{

    public $torneo_nombre;
    public $local_nombre;
    public $visitante_nombre;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_local', 'id_visitante', 'id_torneo', 'goles_local', 'goles_visitante', 'jugado'], 'integer'],
            [['fecha', 'hora', 'lugar', 'instancia', 'grupo','torneo_nombre','local_nombre', 'visitante_nombre'], 'safe'],
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
        $query = Partido::find();
        $torneo = '2018';

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes'=>[
                'id', 'id_local', 'id_visitante', 'id_torneo', 'goles_local',
                'goles_visitante', 'jugado','fecha','hora',	'lugar', 'instancia','grupo',
                'torneo_nombre'=>[
                    'asc'=>['torneo.nombre'=>SORT_ASC],
                    'desc'=>['torneo.nombre'=>SORT_DESC],
                ],
             'local_nombre'=>[
                    'asc'=>['l.nombre'=>SORT_ASC],
                    'desc'=>['l.nombre'=>SORT_DESC],
                ],
             'visitante_nombre'=>[
                    'asc'=>['v.nombre'=>SORT_ASC],
                    'desc'=>['v.nombre'=>SORT_DESC],
                ],
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('torneo');
        $query->joinWith('local l');
        $query->joinWith('visitante v');

        $query->andFilterWhere([
            'id' => $this->id,
           // 'id_local' => $this->id_local,
          //  'id_visitante' => $this->id_visitante,
            //'id_torneo' => $this->id_torneo,
            'fecha' => $this->fecha,
            'goles_local' => $this->goles_local,
            'goles_visitante' => $this->goles_visitante,
            'jugado' => $this->jugado,
        ]);

        $query->andFilterWhere(['like', 'hora', $this->hora])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'instancia', $this->instancia])
            ->andFilterWhere(['like', 'torneo.nombre', $torneo])
            ->andFilterWhere(['like', 'l.nombre', $this->local_nombre])
            ->andFilterWhere(['like', 'v.nombre', $this->visitante_nombre])
            ->andFilterWhere(['like', 'grupo', $this->grupo]);
        $query->orderBy(['instancia' => 'ASC', 'grupo' => 'ASC']);
        return $dataProvider;
    }
}
