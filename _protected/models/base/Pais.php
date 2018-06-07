<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "pais".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property \app\models\Partido[] $partidos
 */
class Pais extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'partidos'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 45],
            //[['grupo'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            //'grupo' => Yii::t('app', 'Grupo'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartidos()
    {
        return $this->hasMany(\app\models\Partido::className(), ['id_visitante' => 'id']);
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
     * @return \app\models\PaisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\PaisQuery(get_called_class());
    }
}
