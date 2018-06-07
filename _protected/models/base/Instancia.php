<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "instancia".
 *
 * @property integer $id
 * @property integer $id_torneo
 * @property string $nombre
 * @property integer $max_participantes
 *
 * @property \app\models\Chat[] $chats
 * @property \app\models\Torneo $torneo
 * @property \app\models\InstanciaRegla[] $instanciaReglas
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
            'torneo',
            'instanciaReglas',
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
            [['id_torneo', 'max_participantes'], 'integer'],
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
            'id' => 'ID',
            'id_torneo' => 'Id Torneo',
            'nombre' => 'Nombre',
            'max_participantes' => 'Max Participantes',
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
    public function getTorneo()
    {
        return $this->hasOne(\app\models\Torneo::className(), ['id' => 'id_torneo']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstanciaReglas()
    {
        return $this->hasMany(\app\models\InstanciaRegla::className(), ['id_instancia' => 'id']);
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
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
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
