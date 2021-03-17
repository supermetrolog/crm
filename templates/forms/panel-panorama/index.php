<? require_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');?>
<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?
$table = $_POST['table'];
$id = (int)$_POST['post'];

$table_obj = new Table($table);
$table = $table_obj->tableName();

?>

<div>
    <form id="edit-all-form" onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php?num=<?=$_GET['num']?>'>
        <div class="form-header flex-box box">
            <div>
                Настройки панорамы
            </div>
        </div>
        <div class="form-content">
            <div class="anketa box-small"  style="background: #f3f3f3">
                <input type="hidden" name="id" value="<?=$id?>">
                <input type="hidden" name="table" value="<?=$table?>">
                <?
                if($id){
                    $post = new Post($id);
                    $post->getTable($table);

                    $src = $post->show();
                    $photo = $post->photos();
                }


                $panorama_fields = [264];
                ?>


                <div  style="width: 100%; flex-wrap: wrap; align-items: flex-start" class="flex-box">

                        <div class="grid-column box-small" style="width: <?=$column[0]?>; ">
                            <div class="box-small" style="background: #FFFFFF;">
                                <div class="grid-column-elements">
                                    <?foreach($panorama_fields as $field_unit) {?>
                                        <?$field = new Field($field_unit)?>
                                        <?if($field->isActive() && $field->canSee() && !$field->showField('field_disabled_frontend') ){?>
                                            <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/index/index.php')?>
                                        <?}?>
                                    <?}?>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="form-footer flex-box flex-center box">
            <div>
                <button id="go" class="button btn-middle btn-red box-small files_resort">
                    Сохранить
                </button>
            </div>
            <?if($id){?>
                <div class="icon-round to-end card-trash delete_post" data-id="<?=$post->postId()?>"  data-table="<?=$post->setTableId()?>">
                    <span title="Удалить"><a href="javascript: 0"><i class="fas fa-trash-alt"></i></a> </span>
                </div>
            <?}?>
        </div>
    </form>

</div>