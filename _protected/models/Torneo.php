<?php

namespace app\models;

use Yii;
use \app\models\base\Torneo as BaseTorneo;

/**
 * This is the model class for table "torneo".
 */
class Torneo extends BaseTorneo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['nombre'], 'string', 'max' => 45]
        ]);
    }
	
}
