<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "instancia_user".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_instancia
 * @property integer $puntos
 * @property integer $puntos_handicap
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
            [['id_user', 'id_instancia', 'puntos', 'puntos_handicap'], 'integer']
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
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'id_instancia' => Yii::t('app', 'Id Instancia'),
            'puntos' => Yii::t('app', 'Puntos'),
            'puntos_handicap' => Yii::t('app', 'Puntos Handicap'),
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
    
}
