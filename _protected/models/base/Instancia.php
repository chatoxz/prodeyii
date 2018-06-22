<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "instancia".
 *
 * @property integer $id
 * @property integer $id_torneo
 * @property integer $id_user
 * @property string $nombre
 * @property integer $max_participantes
 * @property string $reglas
 *
 * @property \app\models\Chat[] $chats
 * @property \app\models\User $user
 * @property \app\models\Torneo $torneo
 * @property \app\models\InstanciaUser[] $instanciaUsers
 * @property \app\models\Prediccion[] $prediccions
 */
class Instancia extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'chats',
            'user',
            'torneo',
            'instanciaUsers',
            'prediccions'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_torneo', 'id_user', 'max_participantes'], 'integer'],
            [['reglas'], 'string'],
            [['nombre'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instancia';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_torneo' => Yii::t('app', 'Id Torneo'),
            'id_user' => Yii::t('app', 'Id User'),
            'nombre' => Yii::t('app', 'Nombre'),
            'max_participantes' => Yii::t('app', 'Max Participantes'),
            'reglas' => Yii::t('app', 'Reglas'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(\app\models\Chat::className(), ['id_instancia' => 'id']);
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
    public function getTorneo()
    {
        return $this->hasOne(\app\models\Torneo::className(), ['id' => 'id_torneo']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstanciaUsers()
    {
        return $this->hasMany(\app\models\InstanciaUser::className(), ['id_instancia' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrediccions()
    {
        return $this->hasMany(\app\models\Prediccion::className(), ['id_instancia' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
   /* public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => false,
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }*/


    /**
     * @inheritdoc
     * @return \app\models\InstanciaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\InstanciaQuery(get_called_class());
    }
}
