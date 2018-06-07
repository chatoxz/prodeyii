<?php

namespace app\models;

use Yii;
use \app\models\base\InstanciaRegla as BaseInstanciaRegla;

/**
 * This is the model class for table "instancia_regla".
 */
class InstanciaRegla extends BaseInstanciaRegla
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'id_instancia'], 'required'],
            [['id', 'id_instancia'], 'integer'],
            [['regla'], 'string']
        ]);
    }
	
}
