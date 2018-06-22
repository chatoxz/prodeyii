<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InstanciaUser */

$this->title = 'Inscribirse en un torneo';
/*$this->params['breadcrumbs'][] = ['label' => 'Instancia User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="instancia-user-create just_white col-md-6 alert">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
