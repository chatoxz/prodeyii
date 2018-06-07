<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Prediccion]].
 *
 * @see Prediccion
 */
class PrediccionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Prediccion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Prediccion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
