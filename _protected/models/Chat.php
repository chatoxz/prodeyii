<?php

namespace app\models;

use Yii;
use \app\models\base\Chat as BaseChat;

/**
 * This is the model class for table "chat".
 */
class Chat extends BaseChat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'id_user', 'fecha'], 'required'],
            [['id', 'id_user'], 'integer'],
            [['mensaje'], 'string'],
            [['fecha'], 'safe']
        ]);
    }

    public function getUser_nombre() {
        return $this->user->username;
    }
}
