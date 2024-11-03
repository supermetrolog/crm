<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

?>
<?
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
?>

<?if($_POST['post']){
        $post = new Post($_POST['post']);
        $post->getTable((new Table($_POST['table']))->tableName());
}?>

<?if($post->postId()){?>
    <div class="comments">
        <div class='widget-title '>
            Комментарии (<?=count($comments = $post->getPostComments())?>)
        </div>
        <div class="widget-body text_left box-small">
            <div>
                <form action="<?=PROJECT_URL?>/system/controllers/posts/create.php" method="post">
                    <input type="hidden" name="post_id_referrer" value="<?=$post->postId()?>"/>
                    <input type="hidden" name="table_id_referrer" value="<?=$post->setTableId()?>"/>
                    <input type="hidden" name="table_id" value="<?=(new Comment())->setTableId()?>"/>
                    <textarea name="description" class="textarea textarea-small box-small"></textarea>
                    <div class="flex-box flex-between flex-vertical-top">
                        <div>
                            <input type="checkbox" name="is_important" value="1"/>Важный комментарий
                        </div>
                    </div>
                    <!--
                        <div class="btn-ajax button">
                        Отптравить
                    </div>
                    -->
                    <button>
                        Отправить
                    </button>
                </form>
            </div>
            <div>
                <ul>
                    <?
                    foreach($comments as $comment){?>
                        <?$comment_obj = new Comment($comment['id']);?>
                        <?include($_SERVER['DOCUMENT_ROOT'].'/templates/comments/list/index.php')?>
                    <?}?>
                </ul>
            </div>
        </div>
    </div>
<?}?>