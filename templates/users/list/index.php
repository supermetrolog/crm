<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.06.2018
 * Time: 15:48
 */
?>
<div class="user-unit flex-box">
    <div class="photo-round photo-middle">
        <a href="<?=PROJECT_URL?>/user/<?=$listMember->member_id()?>/">
            <img style='width: 100px;' src='<?=$listMember->avatar()?>'/>
        </a>
    </div>
    <div class="user-stats box">
        <div class="user-name-block">
            <a href="<?=PROJECT_URL?>/user/<?=$listMember->member_id()?>/">
                <span><b><?=$listMember->title()?> </b></span>
            </a>
        </div>
        <div class="message-stats">
            <div class="ghost">
                <?=$listMember->group_name()?>
            </div>

        </div>
    </div>
    <div class="right">
        <? if($logedUser->member_id()){?>
            <div>
                <div>
                    <?if($logedUser->isFriend($listMember->member_id())){?>
                        <i class="ghost fas fa-user"></i> Друзья
                    <?}elseif($logedUser->isSubscribedTo($listMember->member_id())){?>
                        <i class="ghost fas fa-user"></i> Запрошено
                    <?}elseif($listMember->isSubscribedTo($logedUser->member_id())){?>
                        <i class="ghost fas fa-user"></i> Подписчик
                    <?}else{?>
                        <i class="ghost fas fa-user"></i> Пользователь
                    <?}?>
                </div>
                <div class="fl">
                    <a href='<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$listMember->member_id()?>'><i class="ghost fas fa-pencil-alt"></i> Написать сообщение</a>
                </div>
                <div class="box">

                </div>
                <form action='<?=PROJECT_URL?>/modules/friends/index.php' method='POST'>
                    <input type='hidden' name='friend_id' value='<?=$listMember->member_id()?>'/>
                    <button class="btn-free">
                        <?if($logedUser->isFriend($listMember->member_id())){?>
                            <i class='fas fa-reply'></i> Удалить из друзей
                        <?}elseif($logedUser->isSubscribedTo($listMember->member_id())){?>
                            <i class='fas fa-reply'></i> Отписаться
                        <?}elseif($listMember->isSubscribedTo($logedUser->member_id())){?>
                            <i class='fas fa-user-plus'></i> Принять
                        <?}else{?>
                            <i class='fas fa-user-plus'></i> Подписаться
                        <?}?>
                    </button>
                </form>
            </div>
        <?}?>
    </div>
</div>
