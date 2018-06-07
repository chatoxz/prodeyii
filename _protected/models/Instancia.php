<?php

namespace app\models;

use Yii;
use \app\models\base\Instancia as BaseInstancia;

/**
 * This is the model class for table "instancia".
 */
class Instancia extends BaseInstancia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id_torneo', 'max_participantes'], 'integer'],
            [['nombre'], 'string', 'max' => 255]
        ]);
    }

    public function getTorneo_nombre() {
        return $this->torneo->nombre;
    }
}
