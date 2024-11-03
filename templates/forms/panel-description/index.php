
<? include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');?>
<?
if($_POST['post'] && $_POST['table']){
    $table = $_POST['table'];
    $id = (int)$_POST['post'];
}else{
    $table = $table;
    $id = $id;
}


$table_obj = new Table($table);
$table = $table_obj->tableName();

?>

<form id="edit-all-form" class="full-width"  onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php'>
    <div class="form-content ">
        <div class="anketa  text_left "  style="color: #ffffff;">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="table" value="<?=$table?>">
            <?
            if($id){
                $post = new Post($id);
                $post->getTable($table);

                $src = $post->show();
                $photo = $post->photos();
            }
            ?>

            <div class="flex-box flex-vertical-top flex-between flex-wrap">

                    <div class="full-width" style="color: #000000" >
                        <?
                            $field = new Field(409);
                            $field_template = new Post($field->getField('field_template_id'));
                            $field_template->getTable('core_fields_templates');

                            ?>
                            <div class="flex-box box-vertical ">
                                <div class="form-element-autosave item-desc-box full-width">
                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field_template->title().'/index.php');?>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</form>