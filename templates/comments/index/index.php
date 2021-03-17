<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
?>
<?
if($_POST['post_id']){
    $comment_obj = new Comment($_POST['post_id']);
    $comment_obj->setTable($_POST['table']);
}

?>
<li style="<?=($comment_obj->getField('is_important')) ? 'border: 3px solid red;' : ''?>">
    <div class="flex-box box-vertical">
        <?$author = new Member($comment_obj->getAuthor())?>
        <div class="photo-round photo-icon">
            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                <img style='width: 100px;' src='<?=$author->avatar()?>'/>
            </a>
        </div>
        <div class="box-wide">
            <div class="isBold">
                <?=$author->title()?>
            </div>
            <div class="ghost">
                <?=$comment_obj->publTime()?>
            </div>
        </div>
    </div>
    <div>
        <?=$comment_obj->description()?>
    </div>
</li>
