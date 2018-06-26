<?php

namespace app\models;

use Yii;
use \app\models\base\Partido as BasePartido;

/**
 * This is the model class for table "partido".
 */
class Partido extends BasePartido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
            [
                [['id_local', 'id_visitante'], 'required'],
                [['id_local', 'id_visitante', 'id_torneo', 'goles_local', 'goles_visitante', 'jugado'], 'integer'],
                [['fecha'], 'safe'],
                [['hora', 'lugar', 'instancia', 'grupo'], 'string', 'max' => 45]
            ]);
    }

    public $prediccion_goles_local;
    public $prediccion_goles_visitante;
    public $prediccion_id;
    public $prediccion_resultado;

    public function getTorneo_nombre() {
        return $this->torneo->nombre;
    }
    public function getLocal_nombre() {
        return $this->local->nombre;
    }
    public function getVisitante_nombre() {
        return $this->visitante->nombre;
    }
    public function getLocal_nombre_abreviatura() {
        return $this->local->abreviatura;
    }
    public function getVisitante_abreviatura() {
        return $this->visitante->abreviatura;
    }
}
