<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.04.2018
 * Time: 13:02
 */
?>


<div class="search-line-block">
    <form action="" method="POST">
        <div class="search-line flex-box">
            <input type="text" name="search" placeholder="ID, адрес, собственник, телефон, фио, брокер, название" />
            <button><i class="fas fa-search"></i></button>
        </div>
    </form>
</div>
<script>
    function func() {
        alert( '<?=PROJECT_URL?>/pages/chat-wall.php' );
        $.ajax({
            url: "<?=PROJECT_URL?>/user/inbox-list.php",
            type: "GET",
            data: {"room_id": <?=$_GET['room_id']?>, "user_id": <?=$logedUser->member_id()?>},
            cache: false,
            success: function(response){
                if(response === 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                    alert("не удалось получить ответ от скрипта");
                }else{
                    alert(response);
                    $('.messages-list').html(response);
                }
            }
        });

    }

    setInterval(func, 5000);
</script>

<div class='messages-list'>
    <? require($_SERVER['DOCUMENT_ROOT'].'/user/inbox-list.php') ?>
</div>
<div class='friends-list'>
    <?if($_GET['search_line'] != NULL){?>
        <div class="flex-box flex-around ghost box">
            Результаты глобального поиска:
        </div>
        <?
        $search = $_GET['search_line'];
        $sql = $pdo->prepare("SELECT *FROM core_users  WHERE title LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' ");
        $sql->execute();
        $members = $sql->fetchALL();
        foreach($members as $member){
            $listMember = new Member($member['id']);
                ?>
                <div class="user-unit">
                    <div class="user-name-block">
                        <a href="<?=PROJECT_URL?>/user/<?=$listMember->member_id()?>/">
                            <span><b><?=$listMember->name()?> </b></span><?=$listMember->surName()?> <?=$listMember->fatherName()?>
                        </a>
                    </div>
                    <div class="photo-round">
                        <a href="<?=PROJECT_URL?>/user/<?=$listMember->member_id()?>/">
                            <img style='width: 100px;' src='<?=$listMember->avatar()?>'/>
                        </a>
                    </div>
                    <div class="user-stats">
                        <div class="message-stats">
                            <div class="">
                                <?=$listMember->group_name()?>
                            </div>
                            <div class="fl">
                                <a href='<?=PROJECT_URL?>/user/<?=$listMember->member_id()?>/'>Перейти на страницу</a>
                            </div>
                            <div class="fl">
                                <a href='<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$listMember->member_id()?>'>Написать сообщение</a>
                            </div>
                        </div>
                    </div>
                    <? if($logedUser->member_id()){?>
                        <div>
                            <form action='<?=PROJECT_URL?>/modules/friends/index.php' method='GET'>
                                <input type='hidden' name='friend_id' value='<?=$listMember->member_id()?>'/>
                                <button class="btn-arrow <?=($logedUser->isSubscribed($listMember->member_id())) ? 'btn-red':'btn-blue'; ?>"><?=($logedUser->isSubscribed($listMember->member_id())) ? 'Удалить из друзей' : 'Добавить друзья' ; ?></button>
                            </form>
                        </div>
                    <?}?>
                </div>
        <?}?>
    <?}?>
</div>
