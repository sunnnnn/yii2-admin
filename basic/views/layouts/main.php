<?php
use yii\helpers\Html;
app\assets\AdminAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/components/assets/admin');
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
		<!--[if lt IE 9]>
		<script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    </head>
    <script>var _csrf = '<?= Yii::$app->request->getCsrfToken(); ?>'</script>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="loading-screen"></div>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>
        
        <?= $this->render(
            'right.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

         <?= $this->render(
            'footer.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>
    </div>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
