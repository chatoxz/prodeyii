<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 31/5/2018
 * Time: 12:00
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerJsFile('@themes/js/chat.js',['depends' => [\yii\web\JqueryAsset::className()]]);?>

<div id="outter_chat">
    <h3 style="margin-top: 5px;font-family: myFirstFont">Chat Mundialista!</h3>
    <div id="inner_chat" style="overflow-y: scroll; ">
        <?php foreach ($chats as $chat){ ?>
            <div class="mensaje">
                <?php $fecha = \Yii::$app->formatter->asDate($chat->fecha, 'php:d/m - H:i'); ?>
                <?= "(".$fecha.") ".$chat->user_nombre.": ".$chat->mensaje ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php $form = ActiveForm::begin(['action' => ['/partido/fixture/'],'options' => ['enctype' => 'multipart/form-data'], 'id' => 'id_form_chat']); ?>

<?= $form->field($new_chat, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
<?= $form->field($new_chat, 'id_user', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
<?= $form->field($new_chat, 'id_instancia', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
<div style="display: none">
    <?= $form->field($new_chat, 'fecha')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Fecha',
                'autoclose' => true,
            ]
        ],
    ]); ?>
</div>
<div class="col-md-12" >
    <?= $form->field($new_chat, 'mensaje')->textInput()->label(false)->error(false); ?>
</div>
<div class="resultadoChat col-md-2"></div>
<div class=" hidden">
    <?= Html::submitButton('Enviar', ['class' =>  'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

