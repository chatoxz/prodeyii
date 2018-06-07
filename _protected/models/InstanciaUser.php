<?php

namespace app\models;

use Yii;
use \app\models\base\InstanciaUser as BaseInstanciaUser;

/**
 * This is the model class for table "instancia_user".
 */
class InstanciaUser extends BaseInstanciaUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id_user', 'id_instancia'], 'integer']
        ]);
    }
    public function getUser_nombre() {
        return $this->user->username;
    }
}
