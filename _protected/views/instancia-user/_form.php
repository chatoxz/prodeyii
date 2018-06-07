<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InstanciaUser */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="instancia-user-form ">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <!-- SI ES ADMIN PUEDE CAMBIAR DE TORNEO A LOS USUARIOS -->
    <?php  if (Yii::$app->user->can('admin')) { ?>
        <?= $form->field($model, 'id_user')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'username'),
            'options' => ['placeholder' => 'Usuario' ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Nombre Usuario');
        // no es admin puede inscribir gente en un torneo ?>
    <?php } else { ?>
        <?= $form->field($model, 'id_user')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\User::find()
                ->filterWhere(['id' => Yii::$app->user->getId()])->orderBy('id')->asArray()->all(), 'id', 'username'),
            'options' => ['placeholder' => 'Seleccione su usuario'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("Nombre Usuario"); ?>
    <?php } ?>
    <?php // listado de torneos(grupos de amigos) ?>
    <?= $form->field($model, 'id_instancia')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Instancia::find()->orderBy('id')->asArray()->all(), 'id', 'nombre'),
        'options' => ['placeholder' => 'Elegir torneo'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Torneo"); ?>

    <div class="form-group">
        <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? 'Inscribirse' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if(Yii::$app->controller->action->id != 'create'): ?>
            <?= Html::submitButton('Save As New', ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
        <?php endif; ?>
        <!--<?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>-->
    </div>

    <?php ActiveForm::end(); ?>

</div>
