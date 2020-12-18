<?php

use app\assets\FormAsset;
use app\components\FieldTemplate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserInfo;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

FormAsset::register($this);
?>

<div class="col-md">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <!-- /.card-header -->
              <div class="card-body">

              <?php $form = ActiveForm::begin([
                       'options' => [
                          'enctype' => 'multipart/form-data',
                       ],
                        'id' => 'form',
                        'fieldConfig' => [
                            'inputOptions' => [
                                'class' => 'form-control error',
                            ],
                            'labelOptions' => [
                                'class' => false,
                            ],
                        ]
                        
                        ]); ?>
                  <?if(Yii::$app->controller->action->id != 'update'):?>
                  <div class="row">

                    <div class="col-sm-6">
                      <?= $form->field($model, 'pin', [
                          'template' => FieldTemplate::getAddonTemplate('<i class="fas fa-user"></i>'),
                          'inputOptions' => [
                            'data-inputmask' => '"mask": "999999999"',
                            'data-mask' => true,
                            'im-insert' => 'true',
                            ] 
                          ])->textInput(['placeholder' => 'Пин'])->label('&nbsp') ?>
                    </div>

                    <div class="col-sm-6">
                      
                     <?= $form->field($model, 'password', [
                          'template' => FieldTemplate::getAddonTemplate('<i class="fas fa-lock"></i>'), 
                          ])->textInput(['placeholder' => 'Пароль'])->label('&nbsp') ?>
                      
                    </div>

                  </div>
                    <hr>
                    <?endif;?>
                    <h4 class="ml-3"> <strong>Общая информация</strong> </h4>
                    <hr>
                  <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($userAttr, 'first_name')->textInput()->label('Имя')?>
                        <?= $form->field($userAttr, 'middle_name')->textInput()->label('Фамилия') ?>
                        <?= $form->field($userAttr, 'last_name')->textInput()->label('Отчество') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($userAttr, 'birth_day', [
                          'template' => FieldTemplate::getAddonTemplate('<i class="far fa-calendar-alt"></i>'),
                          'inputOptions' => [
                              'data-inputmask-alias' => 'datetime',
                              'data-inputmask-inputformat' => 'dd.mm.yyyy',
                              'data-mask' => true,
                              'im-insert' => 'false',
                          ]
                          ])->textInput(['placeholder' => 'dd.mm.yyyy','value' => $userAttr->isNewRecord ? '' : $userAttr->getBirthDay()])->label('Дата рождения') ?>

                        
                        <?= $form->field($userAttr, 'phone', [
                          'template' => FieldTemplate::getAddonTemplate('<i class="fas fa-phone"></i>'),
                          'inputOptions' => [
                              'data-inputmask' => '"mask": "(999) 999-9999"',
                              'data-mask' => true,
                              'im-insert' => 'true',
                          ]
                          ])->textInput()->label('Телефон') ?>
                        <div class="row">
                        <div class="col-3">
                          <div class="image-form">
                          <img src="<?=$userAttr->getAvatar();?>" alt="Аватар" class=" rounded">
                          </div>
                            </div>
                            <div class="col-9">
                                    <?= $form->field($imageModel, 'image', [
                                  'template' => FieldTemplate::FILE_INPUT_TEMPLATE,
                                  'inputOptions' => [
                                    'class' => 'form-control error custom-file-input',
                                    'id' => 'customFile',
                                ]
                                  ])->fileInput()->label('Аватар') ?>
                            </div>
                        </div>
    
                    </div>
                  </div>
                  <hr>
                  <h4 class="ml-3"> <strong>Паспортные данные</strong> </h4>
                  <hr>
                  <div class="row">
                    <div class="col-sm-6">

                    <?= $form->field($userAttr, 'pasport_number', [
                          'inputOptions' => [
                              'data-inputmask' => '"mask": "99 99 999999"',
                              'data-mask' => true,
                              'im-insert' => 'true',
                          ]
                          ])->textInput()->label('Серия и номер') ?>

                        <?= $form->field($userAttr, 'pasport_issued')->textInput()->label('Кем выдан') ?>

                        <?= $form->field($userAttr, 'pasport_issued_date', [
                          'inputOptions' => [
                              'data-inputmask-alias' => 'datetime',
                              'data-inputmask-inputformat' => 'dd.mm.yyyy',
                              'data-mask' => true,
                              'im-insert' => 'false',
                          ]
                          ])->textInput(['placeholder' => 'dd.mm.yyyy', 'value' => $userAttr->isNewRecord ? '' : $userAttr->getPasportIssuedDate()])->label('Дата выдачи') ?>

                    </div>
                    <div class="col-sm-6">

                        <?= $form->field($userAttr, 'place_birth')->textInput()->label('Место рождения') ?>

                        <?= $form->field($userAttr, 'place_residence')->textInput()->label('Место проживания') ?>

                        <?= $form->field($userAttr, 'residential_adress')->textInput()->label('Место прописки') ?>

                    </div>
                  </div>
                  <hr>
                  <h4 class="ml-3"> <strong>Дополнительная информация</strong> </h4>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($userAttr, 'education')->dropDownList(UserInfo::getEducationList())->label('Образование') ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($userAttr, 'army')->dropDownList(UserInfo::getArmyList())->label('Армия') ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($userAttr, 'marital_status')->dropDownList(UserInfo::getMaritalList())->label('Семейное положение') ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-6">

                    <?= $form->field($userAttr, 'salary', [
                          'template' => FieldTemplate::getAddonTemplate('<i class="fas fa-ruble-sign"></i>'),
                          'inputOptions' => [
                              'data-inputmask' => '"mask": "999999999"',
                              'data-mask' => true,
                              'im-insert' => 'true',
                          ]
                          ])->textInput()->label('Зарплата') ?>

                    </div>
                    <div class="col-sm-6">

                        <?= $form->field($userAttr, 'department')->dropDownList(UserInfo::getDepartmentList())->label('Отдел')  ?>

                    </div>
                  </div>
                  <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'saveForm']) ?>
                </div>
                  
                  <?php ActiveForm::end(); ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- general form elements disabled -->
            
            <!-- /.card -->
          </div>

<?
  $this->registerJs("
      console.log('INPUT MATHER FUCKER');
      $('#userinfo-birth_day').inputmask();
      $('#userinfo-pasport_issued_date').inputmask('dd.mm.yyyy', { 'placeholder': 'dd.mm.yyyy' });
      $('#userinfo-phone').inputmask('(999) 999-9999');
      $('#userinfo-pasport_number').inputmask('99 99 999999');
      $('#userinfo-salary').inputmask('999999999', { 'placeholder': '' });
      $('#signupform-pin').inputmask('999999999', { 'placeholder': '' });
  ");
?>