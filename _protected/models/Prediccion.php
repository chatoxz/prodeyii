<?php

namespace app\models;

use Yii;
use \app\models\base\Prediccion as BasePrediccion;

/**
 * This is the model class for table "prediccion".
 */
class Prediccion extends BasePrediccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id_user', 'id_partido'], 'required'],
            [['id_user', 'id_partido', 'goles_local', 'goles_visitante', 'resultado'], 'integer']
        ]);
    }
	
}
