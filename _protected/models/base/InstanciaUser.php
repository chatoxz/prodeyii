<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "instancia_user".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_instancia
 * @property integer $puntos
 *
 * @property \app\models\Instancia $instancia
 * @property \app\models\User $user
 */
class InstanciaUser extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'instancia',
            'user'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_instancia', 'puntos'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instancia_user';
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
            'puntos' => 'Puntos',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstancia()
    {
        return $this->hasOne(\app\models\Instancia::className(), ['id' => 'id_instancia']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'id_user']);
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
     * @return \app\models\InstanciaUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\InstanciaUserQuery(get_called_class());
    }
}
