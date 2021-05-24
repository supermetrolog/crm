<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 05.06.2018
 * Time: 14:20
 */
?>
        <div <?=$view_style?> id='<?=$post->postId()?>' class='admin_post'>
            <? if($post->photo()){?>
                <div class='admin_preview_photo' style='background: url(<?=$post->photo()?>)' title='<?=$post->title()?>'>
                    <a href='/admin/index.php?template=post&id=<?=$post->postId()?>&table=<?=$post->setTable()?>&action=change&title=изменение' style='display :block;  height: 100%;'></a>
                </div>
            <?}?>
            <? if($post->title()){?>
                <div class='admin_post_title'>
                    <a target='_blank' href='/admin/index.php?template=post&id=<?=$post->postId()?>&table=<?=$post->setTable()?>&action=change&title=изменение''><?=$post->title()?><span class='ghost box-wide' style='font-weight: normal; text-transform: lowercase'><?= strip_tags($post->description())?></span></a>
                </div>
            <?}?>
            <div class='admin_post_punkts'>
                <form action='<?=PROJECT_URL?>/system/controllers/activity/index.php' method='GET' class='change_activity' >
                    <input  name='id' type='hidden' value='<?=$post->postId()?>' />
                    <input  name='category' type='hidden' value='<?=$post->setTable()?>' />
                    <button class='activity'><?=$vis_icon?></button>
                </form>
                <a class='options_item'  href='/admin/index.php?template=post&id=<?=$post->postId()?>&table=<?=$post->setTable()?>&action=change&title=изменение'><i class="fas fa-pencil-alt"></i></a>
                <div class='options_item delete_post' name='<?=$post->postId()?>' title='<?=$post->setTableId()?>' ><i class='fa fa-times' aria-hidden='true' title='Удалить'></i></div>
                <div class='options_item'><i class="far fa-calendar-alt" title='<?=date("d.m.y  G:i"  ,$post->publTime())?>'></i></div>
                <div class='options_item'><i class="fas fa-chart-line" title='Приоритет отображения'></i> <?=$src['order_row'] ?></div>

                <? if($post->setTable() == 'shops'){ ?>
                    <div class='priority' ><img src='./img/city.png'/ title='Город'><?=$post->showField('city') ?></div>
                <? } ?>

                <? if($post->setTable() == 'pages'){
                    ($post->furl() != ' ' && $post->furl() != '') ? $page_link = $post->furl() : $page_link = '?page='.$post->postId() ;?>
                    <div class='options_item' title='Просмотреть страницу' ><a href='<?=PROJECT_URL.'/'.$page_link?>' target='_blank'><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a></div>
                <? } ?>

                <? if($post->setTable() == 'sales' || $post->setTable() == 'collections'  || $post->setTable() == 'items'){ ?>
                    <div class='options_item'><i class="fa fa-tag" aria-hidden="true" title='Бренд: <? echo $src['brand']; ?>'></i></div>
                <? } ?>

                <? if($post->setTable() == 'items'){ ?>
                    <div class='options_item'  ><img src='img/collection.png'/ title='Коллекция: <?= $src['collection']; echo " / "; echo $src['brand'];  ?>'></div>
                <? } ?>

                <? if($post->setTable() == 'uploads'){ ?>
                    <div class='options_item'><a href='<?=PROJECT_URL?>//some_excel/go.php?filepath=<?=$src['photo_small']?>' target='_blank'><i class="fa fa-download" aria-hidden="true" title='Выгрузить'></i></a></div>
                    <div class='options_item block_type isBold' title='Формат выгрузки: ' > .<?=$src['upload_type']; ?></div>
                <? } ?>

                <? if($post->setTable() == 'bots'){ ?>
                    <div class='options_item'><a href='<?=PROJECT_URL?>/bots/send.php?token=<?=$src['token']?>&msg=<?=urlencode($src['description'])?>' target='_blank'><i  class="fa fa-paper-plane" aria-hidden="true" title='Отправить'></i></a></div>
                <? } ?>

                <? if($table == 'emails'){ ?>
                    <div class='options_item' title='Отправить'><a href='<?=PROJECT_URL?>//admin/send_msg.php?title=<?=$src['title']?>&msg=<?=urlencode($src['description'])?>&bulk=1' target='_blank'><i class="fa fa-paper-plane" aria-hidden="true" ></i></a></div>
                <? } ?>

                <? if($table == 'blocks'){ ?>
                    <?($src['block_type'] == 'text') ? $isText='isOrange': $isText='';?>
                    <div class='options_item block_type <?=$isText?> isBold' title='Тип блока: ' > <?=$src['block_type']; ?></div>
                <? }?>


                <? if($table == 'user_groups'){
                    $group_sql = $pdo->prepare("SELECT * FROM users WHERE member_group_id='".$post->postId()."'");
                    $group_sql->execute();?>
                    <div class='options_item'><a href='<?=PROJECT_URL?>//admin/index.php?action=show&type=users&title=<?=$post->title()?>&member_group_id=<?=$post->postId()?>'><i class="fa fa-user" aria-hidden="true" title='Количество пользователей'></i> <?=$group_sql->rowCount()?></a></div>
                <?  } ?>

                <? if($table == 'channels'){
                    $channel_sql = $pdo->prepare("SELECT * FROM channels WHERE id='".$post->postId()."'");
                    $channel_sql->execute();
                    $channel_info = $channel_sql->fetch(PDO::FETCH_LAZY);?>
                    <div class='options_item'><i class="fa fa-user" aria-hidden="true" title='Количество пользователей'></i> <?=$channel_info->user_amount?></div>
                <?  } ?>

                <? if(in_array($table,array('themes','global_media'))){
                    $check_sql = $pdo->prepare("SELECT * FROM $table ORDER BY order_row DESC LIMIT 1");
                    $check_sql->execute();
                    $check = $check_sql->fetch(PDO::FETCH_LAZY);
                    if($check->id == $post->postId()){?>
                        <div class='options_item'><i title='Выбрано' class="fa fa-check-circle" aria-hidden="true"></i></div>
                    <?}
                }?>
            </div>
        </div>


