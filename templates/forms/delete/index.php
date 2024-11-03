<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?
$table = (int)$_POST['table'];
$id = (int)$_POST['post'];

$table_obj = new Table($table);
$table = $table_obj->tableName();

$table_id = $table_obj->getField('id');

//var_dump($_POST);
if($_COOKIE['member_id'] == 141){
    //include_once ($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}

?>

<div>
    <form id="edit-all-form" onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/delete.php?num=<?=$_GET['num']?>'>
        <div class="form-header flex-box box">
            <div>
                <?if($_POST['form_title']){?>
                    <?=$_POST['form_title']?>.
                <?}else{?>
                    <?=$table_obj->getField('description')?>.
                <?}?>

                <?if($id){?>
                    Удаление  #<?=$id?>
                <?}else{?>
                    Создание
                <?}?>
            </div>
        </div>
        <div class="form-content">
            <div class="anketa box-small"  style="background: #f3f3f3">
                <input type="hidden" name="id" value="<?=$id?>">
                <input type="hidden" name="table_id" value="<?=$table_id?>">
                <?
                if($id){
                    $post = new Post($id);
                    $post->getTable($table);

                    $src = $post->show();
                    $photo = $post->photos();
                }
                ?>

                <div class="isBold" style="font-size: 20px;">
                    Вы уверены что хотите разорвать связь?
                </div>




            </div>
        </div>
        <div class="form-footer flex-box flex-center box">
            <div>
                <button id="go" class="button btn-middle btn-red box-small files_resort">
                    Удалить
                </button>
            </div>
        </div>
    </form>
</div>


