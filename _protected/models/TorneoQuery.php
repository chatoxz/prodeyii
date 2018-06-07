<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Torneo]].
 *
 * @see Torneo
 */
class TorneoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Torneo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Torneo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
