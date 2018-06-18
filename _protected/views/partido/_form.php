<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partido-form ">

    <?php $form = ActiveForm::begin(); ?>
    <div class="">
        <?= $form->field($model, 'id')->textInput() ?>
    </div>
    <label>Equipo Local</label>
    <?php echo  Html::activeDropDownList($model,'id_local', $paises , ['class' => 'form-control','label' => 'Local']) ?>
    <br>
    <?= $form->field($model, 'goles_local')->textInput() ?>

    <label>Equipo Visitante</label>
    <?php echo  Html::activeDropDownList($model,'id_visitante', $paises , ['class' => 'form-control','label' => 'Visitante']) ?>
    <br>
    <?= $form->field($model, 'goles_visitante')->textInput() ?>
    <!--
        <?= $form->field($model, 'id_local')->textInput() ?>
        <?= $form->field($model, 'id_visitante')->textInput() ?>
        <?= $form->field($model, 'id_torneo')->textInput() ?>
        <?= $form->field($model, 'fecha')->textInput() ?>
    -->

    <label>Torneos</label>

    <?php echo  Html::activeDropDownList($model,'id_torneo', $torneos , ['class' => 'form-control','label' => 'Torneos']) ?>
    <br>
    <?= $form->field($model, 'fecha')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Fecha de partido'],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
    ?>

    <?= $form->field($model, 'hora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instancia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jugado')->textInput() ?>

    <?= $form->field($model, 'grupo')->textInput(['maxlength' => true]) ?>


    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
