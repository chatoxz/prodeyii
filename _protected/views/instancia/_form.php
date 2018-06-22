<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Instancia */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="instancia-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'id_form'],]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <!--<?= $form->field($model, 'id_torneo')->textInput(['placeholder' => 'Id Torneo']) ?>-->
    <label>Copas</label>
    <?php echo  Html::activeDropDownList($model,'id_torneo', $torneos , ['class' => 'form-control','label' => 'Copas']) ?>
    <br>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <?= $form->field($model, 'id_user')->textInput(['maxlength' => true, 'placeholder' => 'Id usuario','style' => 'display:none'])->label(false) ?>

    <?= $form->field($model, 'max_participantes')->textInput(['placeholder' => 'Max Participantes']) ?>

    <?php //echo $form->field($model, 'reglas')->textInput(['placeholder' => 'Reglas']) ?>

    <div class="form-group">
        <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if(Yii::$app->controller->action->id != 'create'): ?>
            <!--<?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>-->
        <?php endif; ?>
       <!-- <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>-->
    </div>

    <?php ActiveForm::end(); ?>
</div>
