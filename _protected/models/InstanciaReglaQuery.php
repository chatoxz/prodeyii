<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InstanciaRegla]].
 *
 * @see InstanciaRegla
 */
class InstanciaReglaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return InstanciaRegla[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InstanciaRegla|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
