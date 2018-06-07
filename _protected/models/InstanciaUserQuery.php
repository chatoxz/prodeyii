<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InstanciaUser]].
 *
 * @see InstanciaUser
 */
class InstanciaUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return InstanciaUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InstanciaUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
