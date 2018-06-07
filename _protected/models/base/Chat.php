<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "chat".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_instancia
 * @property string $mensaje
 * @property string $fecha
 *
 * @property \app\models\User $user
 * @property \app\models\Instancia $instancia
 */
class Chat extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'user',
            'instancia'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'mensaje', 'fecha'], 'required'],
            [['id', 'id_user', 'id_instancia'], 'integer'],
            [['mensaje'], 'string'],
            [['fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_instancia' => 'Id Instancia',
            'mensaje' => 'Mensaje',
            'fecha' => 'Fecha',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'id_user']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstancia()
    {
        return $this->hasOne(\app\models\Instancia::className(), ['id' => 'id_instancia']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
   /* public function behaviors()
    {
        return [
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }*/


    /**
     * @inheritdoc
     * @return \app\models\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ChatQuery(get_called_class());
    }
}
