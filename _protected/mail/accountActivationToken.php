<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 
    'token' => $user->account_activation_token]);
?>

Hola <?= Html::encode($user->username) ?>,

sigue este enlace para activar tu cuenta:

<?= Html::a('Please, click here to activate your account.', $resetLink) ?>