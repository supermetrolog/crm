<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 27.05.2018
 * Time: 15:14
 */
?>
<link rel='stylesheet' href='<?=PROJECT_URL?>/css/flexslider_card.css' >

<div class='records-list'>
    <?
    $listRecord = new Item(explode('/',$furl['path'])[3]);
    ?>
    <div class="record-unit">
        <? if($logedUser->member_id()){?>
            <div class='half vertical_top'>
                <div class="slider_slider" >
                    <?
                    if(isset($_GET['id'])){
                        $listRecord = new Item($_GET['id']);
                    }else{
                        $listRecord = new Item(explode('/',$furl['path'])[3]);
                    }
                    $photos = $listRecord->thumbs(); ?>
                    <div class="my_controls" >
                        <ol>
                            <? if($photos) foreach($listRecord->thumbs() as $photo_item){ ?>
                                <li><img style='width :100%' src="<?=PROJECT_URL.'/'.$photo_item?>"/></li>
                            <? }?>
                        </ol>
                    </div>
                    <div class='card_slider'>
                        <div class="flexslider">
                            <ul class="slides" >
                                <? if($photos) foreach($listRecord->thumbs() as $photo_item){ ?>
                                    <li><img class='big_photo' style='width :100%'  src="<?=PROJECT_URL.'/'.$photo_item?>"/></li>
                                <? }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class='half vertical_top'>
                <div class='card_stats three_fourth vertical_top'>
                    <div class='card_props'>
                        <div class='card_props_item'>
                            <div class='price_big isBold'><?=$listRecord->title()?></div>
                        </div>
                        <?if($listRecord->sale() == 1) { ?>
                            <div class='card_props_item'>
                                <div class='nom'>Скидка:</div>
                                <div class='isBold sale_amount'><?=$listRecord->discount()?></div>
                            </div>
                        <?}?>
                        <div class='card_props_item'>
                            <div class='nom'>Оценка:</div>
                            <div class=''><?=$listRecord->getRating()?></div>
                        </div>
                        <div class='card_props_item'>
                            <div class='nom'>Артикул:</div>
                            <div class=''><?=$listRecord->articul()?></div>
                        </div>
                        <div class='details filter_unit'>
                            <div class='title details'><div><div class='sign'>+</div> Детали</div></div>
                            <ul class='sub_brend'>
                                <li>Cпецифика: <span><?=$listRecord->description()?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="record_comments">
                <?
                foreach ($listRecord->getComments() as $comment){
                    $comment = new Comment($comment['id']); ?>
                    <? $author = new Member($comment->author()); ?>
                    <div class="comment-unit box">
                        <div class="message-info flex-box">
                            <div class="message-author-photo ">
                                <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                                    <img  src='<?=$author->avatar()?>'/>
                                </a>
                            </div>
                            <div class="message-stats">
                                <div class="">
                                    <?=$author->surName()?> <?=$author->name()?>
                                </div>
                                <div class="message-stats ghost">
                                    <?=$comment->publTime()?>
                                </div>
                            </div>
                            <div class="record-author right">
                                <?if($comment->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
                                    <div class="ghost delete_post">
                                        <form action="<?=PROJECT_URL?>/modules/comments/delete.php" method="POST">
                                            <input type="hidden" name="comment_id" value="<?=$comment->commentId()?>"/>
                                            <!--<button title="Удалить комментарий"><i class="fas fa-times"></i></button>-->
                                            <div class="btn-free" title="Удалить комментарий" ><i class="fas fa-times"></i></div>
                                        </form>
                                    </div>
                                <?}else{?>
                                    <?if($logedUser->member_id() > 0){?>
                                        <div>
                                            <form action="<?=PROJECT_URL?>/modules/comments/complain.php" method="POST">
                                                <input type="hidden" name="comment_id" value="<?=$comment->commentId()?>"/>
                                                <button title="Пожаловаться"><i class="far fa-frown"></i></button>
                                            </form>
                                        </div>
                                    <?}?>
                                <?}?>
                            </div>
                        </div>
                        <div class="record-text">
                            <?=$comment->description()?>
                        </div>
                        <div class="record-actions flex-box">
                            <div>
                                <div class="reviewStars-input-unabled">
                                    <span>Оценка: </span>
                                    <?=$comment->rating().' из 10'?>
                                    <?$sql = $pdo->prepare("SELECT * FROM rating  WHERE price='".$comment->rating()."'");
                                        $sql->execute();
                                        $star = $sql->fetch(PDO::FETCH_LAZY);
                                    ?>
                                    <?='('.$star->title.')'?>
                                </div>
                            </div>
                            <div class="record-social-actions flex-box right">
                                <div class="action-like">
                                    <form action='<?=PROJECT_URL?>/modules/likes/index.php' method='GET'>
                                        <input type='hidden' name='comment_id' value='<?=$comment->commentId()?>'/>
                                        <input type="hidden" name="type" value="comment"/>
                                        <button class=""?>
                                            <i class="fas fa-thumbs-up  <?=($comment->likedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$comment->getLikesAmount()?></span>
                                    </form>
                                </div>
                                <div class="action-dislike">
                                    <form action='<?=PROJECT_URL?>/modules/dislikes/index.php' method='GET'>
                                        <input type='hidden' name='comment_id' value='<?=$comment->commentId()?>'/>
                                        <input type="hidden" name="type" value="comment"/>
                                        <button class=""?>
                                            <i class="fas fa-thumbs-down <?=($comment->dislikedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$comment->getDislikesAmount()?></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <? }?>
            </div>
            <?(count($listRecord->getComments()) > 0)? $comment_field = '': $comment_field='hidden';?>
                <?if($logedUser->canWriteFeedback($listRecord->itemId())){?>
                    <div class="comment-form ">
                        <div class="room-form box">
                            <form action="<?=PROJECT_URL?>/modules/comments/create.php" method="POST">
                                <input type='hidden' name='record_id' value='<?=$listRecord->itemId()?>'/>
                                <input type='hidden' name='comment_group' value='2'/>
                                <input type='hidden' name='answer_to_id' value='<?=$listRecord->itemId()?>'/>
                                <div class="flex-box">
                                    <div class="photo_round" style="" >
                                        <img src="<?=$logedUser->avatar()?>" /?>
                                    </div>
                                    <div class=" flex-box right" style="width: 95%">
                                        <textarea class="comment-box box right" placeholder="Написать комментарий..." name="description"></textarea>
                                    </div>
                                </div>
                                <div class="comment-panel hidden">
                                    <div class="flex-box box" >
                                        <div>
                                            <!--[if lte IE 7]><style>#reviewStars-input{display:none}</style><![endif]-->

                                            <div id="reviewStars-input">
                                                <?php
                                                $sql = $pdo->prepare("SELECT * FROM rating  ORDER BY id DESC");
                                                $sql->execute();
                                                while($star = $sql->fetch(PDO::FETCH_LAZY)){?>
                                                    <input id="star-<?=$star->price?>" type="radio" name="rating" value="<?=$star->price?>"/>
                                                    <label title="<?=$star->title?>" for="star-<?=$star->price?>"></label>
                                                <?}?>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <button class="btn-send">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?}else{?>
                    <div class="ghost flex-box flex-around">
                        Вы уже оставили оценку к этому товару
                    </div>
                <?}?>
        <?}?>
    </div>

<script type="text/javascript" src="<?=PROJECT_URL?>/js/jquery.flexslider.js"></script>
<script type="text/javascript">
    // Can also be used with $(document).ready()
    $(window).load(function() {
        if($(window).width() > 1200){
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails",
                manualControls: ".my_controls li"
            });
        }else{
            $('.flexslider').flexslider({
                animation: "slide",
                manualControls: ""
            });
        }
    });
</script>

