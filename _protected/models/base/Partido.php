<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "partido".
 *
 * @property integer $id
 * @property integer $id_local
 * @property integer $id_visitante
 * @property integer $id_torneo
 * @property string $fecha
 * @property string $hora
 * @property string $lugar
 * @property string $instancia
 * @property integer $goles_local
 * @property integer $goles_visitante
 * @property integer $jugado
 * @property string $grupo
 *
 * @property \app\models\Pais $local
 * @property \app\models\Torneo $torneo
 * @property \app\models\Pais $visitante
 * @property \app\models\Prediccion[] $prediccions
 */
class Partido extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'local',
            'torneo',
            'visitante',
            'prediccions'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_local', 'id_visitante'], 'required'],
            [['id_local', 'id_visitante', 'id_torneo', 'goles_local', 'goles_visitante', 'jugado'], 'integer'],
            [['fecha'], 'safe'],
            [['hora', 'lugar', 'instancia', 'grupo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partido';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_local' => Yii::t('app', 'Id Local'),
            'id_visitante' => Yii::t('app', 'Id Visitante'),
            'id_torneo' => Yii::t('app', 'Id Torneo'),
            'fecha' => Yii::t('app', 'Fecha'),
            'hora' => Yii::t('app', 'Hora'),
            'lugar' => Yii::t('app', 'Lugar'),
            'instancia' => Yii::t('app', 'Instancia'),
            'goles_local' => Yii::t('app', 'Goles Local'),
            'goles_visitante' => Yii::t('app', 'Goles Visitante'),
            'jugado' => Yii::t('app', 'Jugado'),
            'grupo' => Yii::t('app', 'Grupo'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(\app\models\Pais::className(), ['id' => 'id_local']);
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
    public function getVisitante()
    {
        return $this->hasOne(\app\models\Pais::className(), ['id' => 'id_visitante']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrediccions()
    {
        return $this->hasMany(\app\models\Prediccion::className(), ['id_partido' => 'id']);
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
     * @return \app\models\PartidoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\PartidoQuery(get_called_class());
    }
}
