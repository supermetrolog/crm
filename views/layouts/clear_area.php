<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\assets\ClearAreaAsset;
use app\assets\AlertAsset;

AppAsset::register($this);
ClearAreaAsset::register($this);
AlertAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Contacts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
    <?=$content?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
