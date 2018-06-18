<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prediccion;

/**
 * PrediccionSearch represents the model behind the search form about `app\models\Prediccion`.
 */
class PrediccionSearch extends Prediccion
{
    public $username;
    public $local_nombre;
    public $visitante_nombre;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_partido', 'goles_local', 'goles_visitante', 'resultado'], 'integer'],
            [['username','local_nombre', 'visitante_nombre', 'id_instancia'], 'safe'],
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
        $query = Prediccion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes'=>[
                'id', 'id_user', 'id_partido', 'goles_local', 'goles_visitante', 'resultado',
                'local_nombre', 'visitante_nombre','id_instancia',
                'username'=>[
                    'asc'=>['user.username'=>SORT_ASC],
                    'desc'=>['user.username'=>SORT_DESC],
                ],
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('user');
        $query->joinWith('partido');
        $query->join('INNER JOIN','pais l', 'l.id = partido.id_local');
        $query->join('INNER JOIN','pais v', 'v.id = partido.id_visitante');

        $query->andFilterWhere([
            'id' => $this->id,
            //'id_user' => $this->id_user,
            'id_partido' => $this->id_partido,
            'id_instancia' => $this->id_instancia,
            'goles_local' => $this->goles_local,
            'goles_visitante' => $this->goles_visitante,
            'resultado' => $this->resultado,
            //'user.username' => $this->username,
        ]);
        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'l.nombre', $this->local_nombre])
            ->andFilterWhere(['like', 'v.nombre', $this->visitante_nombre]);
        return $dataProvider;
    }
}
