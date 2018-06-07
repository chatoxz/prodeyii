<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prediccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prediccion-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'id_form'],]); ?>

    <div class="hidden">
        <?= $form->field($model, 'id')->textInput() ?>

        <?= $form->field($model, 'id_user')->textInput() ?>

        <?= $form->field($model, 'id_partido')->textInput() ?>
    </div>
    <table class="" >
        <tbody>
        <td style="padding-right: 10px;min-height: 60px">
            <?= $form->field($model, 'goles_local')->textInput(['style' => 'width: 35px;vertical-align: center'])->label($partido->local_nombre,['class'=>'label-class-float-left']); ?>
        </td>
        <td style="min-height: 60px">
            <?= $form->field($model, 'goles_visitante')->textInput(['style' => 'width: 35px'])->label($partido->visitante_nombre,['class'=>'label-class-float-right']); ?>
        </td>
        </tbody>
    </table>
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Predecir'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
