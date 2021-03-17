<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 14:45
 */
?>

<div class='profile-header flex-box header-panel background-fix' style='background-image: url("https://www.retail-loyalty.org/upload/medialibrary/5bb/5bbe63e825bd8e3ca15c34cca4840919.jpg");'>
    <div class='calendar_event_time isBold'>

    </div>
    <div class='photo_line flex-box flex-center-center ' >
        <div class='photo-round photo-big'>
            <img src='https://cdn.udc.edu/wp-content/uploads/2016/11/project_request.png'/>
        </div>
        <div class='user_name flex-box flex-center-center'>
            <h2><?=$task->title()?></h2>
        </div>
    </div>
    <div class='profile-panel info_line text_left bitkit_box flex-box ' style='color: white'>
        <div class='info_line_units '>
            <span >Статус:</span><br>
            <?//=$request->getRequestStatus()?>
        </div>
        <div class='info_line_units '>
            <span >Компания:</span><br>
            <?$company = new Company($task->getField('company_id'))?>
            <a style="color: white" href="/company/<?=$company->postId()?>/"><?=$company->title()?></a>
        </div>
        <div class='info_line_units '>
            <span >Брокер:</span><br>
            <?$agent = new Member($task->getField('agent_id'))?>
            <?=$agent->getField('title')?>
        </div>
        <div class='info_line_units'>
            <span>Создан:</span><br>
            <?= date('Y-m-d',$task->getField('publ_time'))?>
        </div>
        <div class='info_line_units '>
            <span >Последнее обновление:</span><br>
            <?= date('Y-m-d в H:i',$task->getField('last_update'))?>
        </div>
        <div class="icon-round to-end modal-call-btn" data-id="<?=$task->postId()?>" data-table="<?=$task->setTableId()?>" data-form-size="modal-middle"  >
            <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
        </div>
    </div>
</div>


