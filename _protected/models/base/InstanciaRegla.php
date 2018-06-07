<?php

namespace app\models\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "instancia_regla".
 *
 * @property integer $id
 * @property integer $id_instancia
 * @property string $regla
 *
 * @property \app\models\Instancia $instancia
 */
class InstanciaRegla extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'instancia'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_instancia'], 'required'],
            [['id', 'id_instancia'], 'integer'],
            [['regla'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instancia_regla';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_instancia' => 'Id Instancia',
            'regla' => 'Regla',
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
     * @return \app\models\InstanciaReglaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\InstanciaReglaQuery(get_called_class());
    }
}
