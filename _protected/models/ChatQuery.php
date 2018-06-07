<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Chat]].
 *
 * @see Chat
 */
class ChatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Chat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Chat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}