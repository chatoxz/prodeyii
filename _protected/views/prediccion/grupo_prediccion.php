<?php

use app\models\Pais;
use app\models\Partido;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Prediccion */

$search = "$('input[type=number]').attr( 'max', '9').attr('min', '0');";
$this->registerJs($search);
?>

<?php $form = ActiveForm::begin(['id' => 'id_form']); ?>
<?php $i = 0; ?>
<?php foreach ($predicciones as $index => $prediccion){
    if ( Partido::find()->where(['id' => $prediccion->id_partido])->one()->jugado == 1 ) $jugado =  true;
    else $jugado = false;  ?>
    <div class="hidden">
        <?= $form->field($prediccion, "[$index]id")->textInput() ?>
        <?= $form->field($prediccion, "[$index]id_user")->textInput() ?>
        <?= $form->field($prediccion, "[$index]id_partido")->textInput() ?>
        <?= $form->field($prediccion, "[$index]resultado")->textInput() ?>
    </div>
    <table class="" >
        <tbody>
        <td style="padding-right: 10px;min-height: 60px">
            <?php
            $id_partido = $prediccion->id_partido;
            $local = Pais::findOne(['id' => Partido::findOne(['id' => $id_partido])->id_local]);
            $visitante = Pais::findOne(['id' => Partido::findOne(['id' => $id_partido])->id_visitante]); ?>
            <?= $form->field($prediccion, "[$index]goles_local")
                ->textInput(['type' => 'number','style' => 'width: 35px;vertical-align: center', 'readonly' => $jugado])
                ->label($local->nombre,['class'=>'label-class-float-left']); ?>
        </td>
        <td style="min-height: 60px">
            <?= $form->field($prediccion, "[$index]goles_visitante")
                ->textInput(['type' => 'number','style' => 'width: 35px;vertical-align: center', 'readonly' => $jugado])
                ->label($visitante->nombre,['class'=>'label-class-float-right']); ?>
        </td>
        </tbody>
    </table>
    <?php
    ++$i;
} ?>
<div class="form-group" style="text-align: center">
    <?= Html::submitButton( Yii::t('app', 'Predecir'), ['class' =>  'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
