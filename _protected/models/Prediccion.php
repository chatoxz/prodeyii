<?php

namespace app\models;

use Yii;
use \app\models\base\Prediccion as BasePrediccion;

/**
 * This is the model class for table "prediccion".
 */
class Prediccion extends BasePrediccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
            [
                [['id_user', 'id_partido'], 'required'],
                [['id_user', 'id_partido', 'id_instancia', 'goles_local', 'goles_visitante', 'resultado'], 'integer']
            ]);
    }

    public function getUsername() {
        if (isset($this->user->username))
            return $this->user->username;
        else
            return "no definido";
    }
    public function getLocal_nombre() {
        if (isset($this->partido->local->nombre))
            return $this->partido->local->nombre;
        else
            return "no definido";}
    public function getVisitante_nombre() {
        if (isset($this->partido->visitante->nombre))
            return $this->partido->visitante->nombre;
        else
            return "no definido";
    }
}
