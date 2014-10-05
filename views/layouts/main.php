<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'User Application',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-fixed-top',
                ],
            ]);

            if (Yii::$app->user->isGuest) {
                // Guest's menu items
                $menuItems = [
                    ['label' => 'Login', 'url' => ['/user/login']],
                    ['label' => 'Register', 'url' => ['/user/register']],
                ];
            } else {
                // Authorized user's menu items
                $menuItems = [
                    ['label'       => 'Profile', 'url' => ['/user/profile']],
                    ['label'       => 'Logout (' . Yii::$app->user->identity->username . ')',
                     'url'         => ['/user/logout'],
                     'linkOptions' => ['data-method' => 'post']],
                ];
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => $menuItems,
            ]);

            NavBar::end();
        ?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
   </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
