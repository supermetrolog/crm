<?php

use yii\helpers\Url;
use app\assets\AlertAsset;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <button id="createUser" type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-lg">
                  Создать
        </button>
      
    </p>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card card-solid">
        <div class="card-body pb-0">
<div class="row">
<? foreach($models as $model):?>  
          <div class="col-md-4">
            <a class="user-item view-user-btn" data-toggle="modal" data-target="#modal-lg" href="<?=Url::to(['/user/user-info/view', 'id' => $model->id])?>">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white <?=$model->userinfo->getDepartmentColorClass()?>">
                <h5><?=$model->userinfo->full_name?></h5>
                <h6 class="widget-user-desc text-lowercase user-department-name"><?=$model->userinfo->getDepartmentShort();?></h6>
              </div>
              <div class="widget-user-image user-img">
                <div class="user-img">
                <img class="rounded-circle elevation-2" src="<?=$model->userinfo->getAvatar();?>" alt="User Avatar">
                </div>
                
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header text-info"><?=$model->pin?></h5>
                      <span class="description-text">Пин</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?=$model->userinfo->getSalary()?></h5>
                      <span class="description-text">Зарплата</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header"><?=$model->userinfo->getAge()?></h5>
                      <span class="description-text">Возраст</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
        </a>
        <!-- /.widget-user -->
      </div>
      <?endforeach;?>
      <!-- /.col -->
    </div>
  </div>
</div>

      
<div class="modal fade" id="modal-lg" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h5 class="font-weight-bold">Анкета сотрудника</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"></div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</div>