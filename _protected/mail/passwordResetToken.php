<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 
    'token' => $user->password_reset_token]);
?>

Hola <?= Html::encode($user->username) ?>, noobeaste!

sigue este enlace para cambiar tu contraseña:

<?= Html::a('Please, click here to reset your password.', $resetLink) ?>
