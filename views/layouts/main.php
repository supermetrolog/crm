<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\assets\AlertAsset;
use yii\helpers\Html;
AppAsset::register($this);
AlertAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DynastyPride</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?=Html::csrfMetaTags();?>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <?=$this->render('header.php');?>
    <?=$this->render('left.php');?>
    <?=$this->render('content.php', ['content' => $content]);?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
