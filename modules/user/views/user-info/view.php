<?php

use app\assets\AlertAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center user-img">
                  <img class="profile-user-img img-fluid rounded-circle" src="<?=$model->userinfo->getAvatar()?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$model->userinfo->full_name?></h3>

                <p class="text-muted text-center"><?=$model->userinfo->getDepartment()?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Пин</b> <a class="float-right text-info"><?=$model->pin?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Возраст</b> <a class="float-right"><?=$model->userinfo->getAge()?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Зарплата</b> <a class="float-right text-success"><?=$model->userinfo->getSalary()?></a>
                  </li>
                  
                </ul>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Информация</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fa fa-phone mr-1"></i> Телефон</strong>
                <p class="text-muted">
                  <?=$model->userinfo->getPhone()?>
                </p>
                <strong><i class="fas fa-book mr-1"></i> Образование</strong>

                <p class="text-muted">
                  <?=$model->userinfo->getEducation()?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Место жительства</strong>

                <p class="text-muted"><?=$model->userinfo->residential_adress?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Инфо</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Таймлайн</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Настройки</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                  <?= DetailView::widget([
                            'options' => [
                              'class' => 'table table-striped table-bordered detail-view profile-view'
                            ],
                            'model' => $model,
                            'attributes' => [
                                [
                                  'label' => 'ФИО',
                                  'value' => $model->userinfo->getFIO(),
                                ],
                                [
                                  'label' => 'Дата рождения',
                                  'value' => $model->userinfo->getBirthDay(),
                                ],
                                [
                                  'label' => 'Армия',
                                  'value' => $model->userinfo->getArmy(),
                                ],
                                [
                                  'label' => 'Семейное положение',
                                  'value' => $model->userinfo->getMaritalStatus(),
                                ],
                                [
                                  'label' => 'Дата создания',
                                  'value' => $model->userinfo->created_at,
                                ],
                                [
                                  'label' => 'Дата последнего изменения',
                                  'value' => $model->userinfo->updated_at,
                                ],
                            ],
                        ]);?>
                    <h6>Паспортные данные</h6>
                    <hr>
                  <?= DetailView::widget([
                            'options' => [
                              'class' => 'table table-striped table-bordered detail-view profile-view'
                            ],
                            'model' => $model,
                            'attributes' => [
                                [
                                  'label' => 'Серия и номер',
                                  'value' => $model->userinfo->pasport_number,
                                ],
                                [
                                  'label' => 'Место прописки',
                                  'value' => $model->userinfo->place_residence,
                                ],
                                [
                                  'label' => 'Выдан',
                                  'value' => $model->userinfo->pasport_issued,
                                ],
                                [
                                  'label' => 'Дата выдачи',
                                  'value' => $model->userinfo->getPasportIssuedDate(),
                                ],
                            ],
                        ]);?>

                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <div class="row">
                      <div class="col-6">
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-fire">
                  Launch Warning Modal
                    </button>
                      <?= Html::a('Уволить', ['to-fire'], [
                          'class' => 'btn btn-warning',
                          'id' => 'dismissUser',
                          'user-id' => $model->id,
                          'data-toggle' => 'modal',
                          'data-target' => '#modal-danger',
                      ]) ?>
                      </div>
                      <div class="col-6">
                      <?= Html::a('Delete', ['delete'], [
                          'class' => 'btn btn-danger',
                          'id' => 'deleteUser',
                          'user-id' => $model->id,
                      ]) ?>
                      </div>
                    </div>
                      
                      <div class="row">
                      <?php $form = ActiveForm::begin([
                       'options' => [
                          'enctype' => 'multipart/form-data'
                       ],
                        'id' => 'userForm',
                        'fieldConfig' => [
                            'inputOptions' => [
                                'class' => 'form-control error',
                            ],
                            'labelOptions' => [
                                'class' => false,
                            ],
                        ]
                        
                        ]); ?>
                      

                      <?php ActiveForm::end(); ?>
                      </div>
        
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

</div>

<div class="modal fade" id="modal-fire" style="display: none; padding-right: 17px;" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Предупреждение</h4>
              <button type="button" class="close" data-close-modal="close" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <p>Вы действительно хотите уволить этого сотрудника?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-dark" data-close-modal="close">Нет</button>
              <button type="button" class="btn btn-outline-dark">Да</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
