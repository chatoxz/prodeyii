<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "prediccion".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_partido
 * @property integer $id_instancia
 * @property integer $goles_local
 * @property integer $goles_visitante
 * @property integer $resultado
 *
 * @property \app\models\Instancia $instancia
 * @property \app\models\Partido $partido
 * @property \app\models\User $user
 */
class Prediccion extends \yii\db\ActiveRecord
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
            'partido',
            'user'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_partido'], 'required'],
            [['id_user', 'id_partido', 'id_instancia', 'goles_local', 'goles_visitante', 'resultado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prediccion';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_partido' => 'Id Partido',
            'id_instancia' => 'Id Instancia',
            'goles_local' => 'Goles Local',
            'goles_visitante' => 'Goles Visitante',
            'resultado' => 'Resultado',
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
    public function getPartido()
    {
        return $this->hasOne(\app\models\Partido::className(), ['id' => 'id_partido']);
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
    /*public function behaviors()
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
     * @return \app\models\PrediccionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\PrediccionQuery(get_called_class());
    }
}
