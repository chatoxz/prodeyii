<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "torneo".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $partidos_grupo
 *
 * @property \app\models\Instancia[] $instancias
 * @property \app\models\Partido[] $partidos
 */
class Torneo extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            'instancias',
            'partidos'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['partidos_grupo'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'torneo';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
            'partidos_grupo' => Yii::t('app', 'Partidos Grupo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstancias()
    {
        return $this->hasMany(\app\models\Instancia::className(), ['id_torneo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(\app\models\Partido::className(), ['id_torneo' => 'id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return \app\models\TorneoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TorneoQuery(get_called_class());
    }
}
