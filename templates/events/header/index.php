<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 15:01
 */
?>
<div class='calendar_event_header profile-header flex-box    header-panel' style='background-image: url(<?=$event->coverPhoto();?>);'>
    <div class='calendar_event_time isBold'>

    </div>
    <div class='photo_line flex-box flex-center-center ' >
        <div class='photo-round photo-big'>
            <img src='<?=$event->photo()?>'/>
        </div>
        <div class='user_name flex-box flex-center-center'>
            <h2><?=$event->title()?></h2>
            <h4></h4>
        </div>
    </div>
    <div class='black_line info_line text_left bitkit_box flex-box ' style='color: white'>
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
            <?if($pageUser->member_id() == $logedUser->member_id()){?>
                <div class="button btn-green btn-middle">
                    <i class="fas fa-pencil-alt"></i> Редактировать
                </div>
                <div class="button btn-green btn-middle">
                    <a href="<?=PROJECT_URL?>/auth/login.php">
                        <i class="fas fa-sign-out-alt"></i> Выход
                    </a>
                </div>
            <?}else{?>
                <div class="button btn-green btn-middle">
                    <a href="<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$pageUser->member_id()?>">
                        <i class="fas fa-pencil-alt"></i> Написать сообщение
                    </a>
                </div>
                <div class="button btn-green btn-middle">
                    <form action='<?=PROJECT_URL?>/system/modules/friends/index.php' method='GET'>
                        <input type='hidden' name='friend_id' value='<?=$pageUser->member_id()?>'/>
                        <button class="btn-free"><?=($logedUser->isSubscribed($pageUser->member_id())) ? 'Удалить из друзей' : 'Добавить друзья' ; ?></button>
                    </form>
                </div>
            <?}?>
        </div>
    </div>
</div>
