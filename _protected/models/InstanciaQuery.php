<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Instancia]].
 *
 * @see Instancia
 */
class InstanciaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Instancia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Instancia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
