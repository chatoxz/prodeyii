<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Instancia;
use app\models\InstanciaUser;
use app\models\Torneo;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
    <!--<script src="//go.mobtrks.com/notice.php?p=1738061&interstitial=1"></script>-->
</head>


<body id="id_body">
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    $nav_sin_log = "";
    if (Yii::$app->user->isGuest) $nav_sin_log = 'nav_sin_log';
    NavBar::begin([
        //'brandLabel' => Yii::t('app', Yii::$app->name),
        'brandLabel' => '<img src="/themes/light/img/copa_mundo.jpg" /> ProdeMaster Mundial!',
        'brandUrl' => '/site/login',
        'options' => [
            'class' => 'navbar-default navbar-fixed-top nav_white_opacity '.$nav_sin_log,
        ],
    ]);
    // everyone can see Home page
    //$menuItems[] = ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']];

    // we do not need to display About and Contact pages to employee+ roles
    if (!Yii::$app->user->can('default')) {    }

    // USUARIO COMUN USUARIO COMUN USUARIO COMUN USUARIO COMUN USUARIO COMUN USUARIO COMUN USUARIO COMUN
    if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => (DATE('H')-3).":".DATE('i'), 'options'=>['class'=>'hora' ]];
        $subMenuItems[] = ['label' => Yii::t('app', 'Inscribirse'), 'url' => ['/instancia-user/create']];
        //$subMenuItems[] = ['label' => Yii::t('app', 'Crear Torneo'), 'url' => ['/instancia/create']];
        $instancias_user = InstanciaUser::find()->filterWhere(['id_user' => Yii::$app->user->getId()])->all();
        if(sizeof($instancias_user) != 0 ){
            foreach ($instancias_user as $instancia_user){
                $instancia = Instancia::find()->filterWhere(['id' => $instancia_user->id_instancia])->one();
                $torneo = Torneo::find()->filterWhere(['id' => $instancia->id_torneo])->one();
                $url = Url::toRoute(['/partido/fixture','id_instancia' => $instancia->id]);
                $subMenuItems[] = ['label' => Yii::t('app', $instancia->nombre), 'url' => $url ];
            }
        }
        $menuItems[] =[
            'class' => '',
            'label' => 'Torneos',
            'items' => $subMenuItems
        ];
        if(sizeof($instancias_user) != 0 ){
            foreach ($instancias_user as $instancia_user){
                $instancia = Instancia::find()->filterWhere(['id' => $instancia_user->id_instancia])->one();
                $torneo = Torneo::find()->filterWhere(['id' => $instancia->id_torneo])->one();
                $url = Url::toRoute(['/partido/segunda-fase', 'id_instancia' => $instancia->id]);
                $subMenuItems_SF[] = ['label' => Yii::t('app', $instancia->nombre), 'url' => $url ];
            }
            $menuItems[] =[
                'class' => '',
                'label' => 'Segunda Fase',
                'items' => $subMenuItems_SF
            ];

        }        if(sizeof($instancias_user) != 0 )
            $menuItems[] = '<li><a value="/partido/reglas" class="modalReglas" 
                    style="cursor: pointer;" title="Reglas" size="modal-lg" href="#">Reglas</a></li>';
        $menuItems[] = [
            'label' => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];


    }

    // ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN ADMIN
    if (Yii::$app->user->can('admin')){

        //calcular puntos
        $instancias = Instancia::find()->all();
        foreach ($instancias as $instancia) {
            $url = Url::toRoute(['/partido/puntuar', 'id_instancia' => $instancia->id]);
            $subMenuPuntuar[] = ['label' => Yii::t('app', $instancia->nombre), 'url' => $url ];
        }
        $menuItems[] =[
            'class' => '',
            'label' => 'Puntuar',
            'items' => $subMenuPuntuar
        ];
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Prediccion'), 'url' => ['/prediccion/index']];
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Partido'), 'url' => ['/partido/index']];
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Pais'), 'url' => ['/pais/index']];
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Copas'), 'url' => ['/torneo/index']];
        $url = Url::toRoute(['/instancia/admin_torneo', 'id_user' => Yii::$app->user->id]);
        $subMenuAdmin[] = ['label' => Yii::t('app', 'Mis Torneos'), 'url' => $url];
        //$subMenuAdmin[] = ['label' => Yii::t('app', 'Sms'), 'url' => ['/site/sms']];
        $menuItems[] =[
            'class' => '',
            'label' => 'Admin',
            'items' => $subMenuAdmin
        ];
    }

    // LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP LOGIN SIGNUP
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <!-- FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER FOOTER -->
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer white_opacity">
    <div class="container" style="display: flex;justify-content: space-around">
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="">Desarrollado por <a style="color: #3899ea;" target="_blank" href="http://www.appe.com.ar">Appe Studio</a> </p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php
// MODAL PARA USARASE EN TODOS LAS VISTAS
Modal::begin([ 'id' => 'modal', 'header' => '<h2>Prode</h2>', 'size' => '']);
echo '<div id="modalContent"></div>';
echo '<div class="alert alert-info resultado hidden" style="margin: 10px 30px;"></div>';
Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php //echo include_once(dirname(__FILE__) . '/../../../pa_antiadblock_1738158.php'); ?>
