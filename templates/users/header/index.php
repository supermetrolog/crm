<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 14:45
 */
?>
<div class='profile-header flex-box header-panel' style='background-image: url(<?=$pageUser->coverPhoto();?>);'>
    <div class='calendar_event_time isBold'>

    </div>
    <div class='photo_line flex-box flex-center-center ' >
        <div class='photo-round photo-big'>
            <img src='<?=$pageUser->avatar()?>'/>
        </div>
        <div class='user_name flex-box flex-center-center'>
            <div>
                <h2><?=$pageUser->title()?></h2>
            </div>
            <div>
                <h4><?=$pageUser->group_name()?></h4>
            </div>
        </div>
    </div>
    <div class='profile-panel info_line text_left bitkit_box flex-box ' style='color: white'>
        <div class='info_line_units'>
            <span>Регистрация:</span><br>
            <?=$pageUser->joined()?>
        </div>
        <div class='info_line_units '>
            <span >Последнее поещение:</span><br>
            <?=$pageUser->last_was()?>
            <?=($pageUser->is_online())? '(В сети)' : ''?>
        </div>
        <div class='info_line_units '>
            <span >Репутация:</span><br>
            <?=$pageUser->reputation_points()?>
        </div>
        <div class='personal-actions right flex-box'>
            <?if(($pageUser->member_id() == $logedUser->member_id()) || $logedUser->isAdmin()){?>
                <div class="icon-round to-end modal-call-btn" data-modal="edit-all" data-id="<?=$pageUser->member_id()?>" data-table="<?=$pageUser->setTableId()?>" data-modal-size="modal-middle"  >
                    <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
                </div>
            <?}?>
            <?if($pageUser->member_id() != $logedUser->member_id()){?>
                <div class="icon-round pointer">
                    <a title="Написать сообщение" href="<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$pageUser->member_id()?>">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            <?}?>
        </div>
    </div>
</div>
