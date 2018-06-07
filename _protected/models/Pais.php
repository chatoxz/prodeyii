<?php

namespace app\models;

use Yii;
use \app\models\base\Pais as BasePais;

/**
 * This is the model class for table "pais".
 */
class Pais extends BasePais
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['nombre'], 'string', 'max' => 45],
            //[['grupo'], 'string', 'max' => 5]
        ]);
    }
	
}
