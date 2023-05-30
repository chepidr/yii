<?php

/** @var yii\web\View $this */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="x-icon" href="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

</head>

<body>
    <?php $this->beginBody() ?>
    <header>
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    ['label' => 'Praktika', 'url' => ['/aibar/praktika']],
                    Yii::$app->user->isGuest
                        ? ['label' => 'Login', 'url' => ['/aibar/login']]
                        : '<li class="nav-item">'
                            . Html::beginForm(['/aibar/logout'])
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->email . ')',
                                ['class' => 'nav-link btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                ]
            ]);
            NavBar::end();
        ?>
    </header>
    

    <?= $content ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>