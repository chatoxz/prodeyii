<div class="form-group" id="add-partido">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Partido',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'id_local' => [
            'label' => 'Pais',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Pais::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
                'options' => ['placeholder' => 'Choose Pais'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'id_torneo' => [
            'label' => 'Torneo',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Torneo::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
                'options' => ['placeholder' => 'Choose Torneo'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'fecha' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Fecha',
                        'autoclose' => true
                    ]
                ],
            ]
        ],
        'hora' => ['type' => TabularForm::INPUT_TEXT],
        'lugar' => ['type' => TabularForm::INPUT_TEXT],
        'instancia' => ['type' => TabularForm::INPUT_TEXT],
        'goles_local' => ['type' => TabularForm::INPUT_TEXT],
        'goles_visitante' => ['type' => TabularForm::INPUT_TEXT],
        'jugado' => ['type' => TabularForm::INPUT_TEXT],
        'grupo' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowPartido(' . $key . '); return false;', 'id' => 'partido-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Partido', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create white_opacity col-md-12 alert', 'onClick' => 'addRowPartido()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

