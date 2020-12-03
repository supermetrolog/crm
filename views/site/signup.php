<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignUp */

use yii\bootstrap\ActiveForm;

$this->title = 'SignUp';
$this->params['breadcrumbs'][] = $this->title;

?>  
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="logo-block">
        <img class="logo" src="/img/DP_logo.png" alt="Logo">
      </div>
      
      <p class="login-box-msg"> <strong>DYNASTY PRIDE</strong></p>

      <!-- <form action="../../index3.html" method="post"> -->
      <?php $form = ActiveForm::begin(); ?>
        <div class="input-group mb-3">
          <?= $form->field($model, 'pin', ['template' => '{input}', 'options' => ['tag' => false]])->input('text',['autofocus' => true, 'id' => 'pin', 'placeholder' => 'Pin'])?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-pin"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <!-- <input type="password" class="form-control" placeholder="Password"> -->
          <?= $form->field($model, 'password', ['template' => '{input}', 'options' => ['tag' => false]])->input('password',['autofocus' => true, 'id' => 'password', 'placeholder' => 'Password'])?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <!-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> -->
            <button type="sumbit" class="btn btn-primary btn-block toastrDefaultErrorSignUp">
                  SignUp
                </button>
          </div>
          <!-- /.col -->
        </div>
      <!-- </form> -->
      <?php ActiveForm::end(); ?>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

</div>
