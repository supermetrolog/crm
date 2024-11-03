
<? include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');?>
<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?
if($_POST['post'] && $_POST['table']){
    $table = $_POST['table'];
    $id = (int)$_POST['post'];
}else{
    $table = $table;
    $id = $id;
}

/** @var PDO $pdo */
$stmt = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE id = :id");
$stmt->bindValue(':id', $id);

$stmt->execute();
$block = $stmt->fetch(PDO::FETCH_ASSOC);

$table_obj = new Table($table);
$table = $table_obj->tableName();

?>

<form id="edit-all-form" class="ad-panel"  onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php'>
    <input type="hidden" value="1" name="ads_panel"  />
    <div class="form-content ">
        <div class="anketa box text_left ad_panel"  style="color: #ffffff;">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="table_id" value="<?=$table_obj->getField('id')?>">
            <?
            if($id){
                $post = new Post($id);
                $post->getTable($table);

                $src = $post->show();
                $photo = $post->photos();
            }
            ?>
            <div class="" style="color: limegreen;">
                <div class="icon-round ad-panel-call modal-call-btn1" data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-middle" ><i class="fas fa-rocket"></i></div>
            </div>
            <br>
            <div class="flex-box flex-vertical-top flex-between flex-wrap">
                <div>
                    <div class="isBold">
                        Realtor.ru
                    </div>
                    <div class="box-vertical">
                        <?
                        $fields_arr = [276,500];
                        foreach($fields_arr as $field){
                            $field = new Field($field);
                            $template = new FieldTemplate($field->getField('field_template_id'))?>
                            <div class="flex-box box-vertical">
                                <div class="form-element-autosave">
                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$template->title().'/index.php');?>
                                </div>
                                <div class="box-wide">
                                    <?=$field->titleToDisplay()?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div>
                    <div class="isBold">
                        Циан
                    </div>
                    <div class="box-vertical">
                        <?
                        $fields_arr = [253,256,257,258];
                        foreach($fields_arr as $field){
                            $field = new Field($field);
                            $template = new FieldTemplate($field->getField('field_template_id'))?>
                            <div class="flex-box box-vertical">
                                <div class="form-element-autosave">
                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$template->title().'/index.php');?>
                                </div>
                                <div class="box-wide">
                                    <?=$field->titleToDisplay()?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div>
                    <div class="isBold">
                        Яндекс
                    </div>
                    <div class="box-vertical">
                        <?
                        $fields_arr = [254,259,260,261];
                        foreach($fields_arr as $field){
                            $field = new Field($field);
                            $template = new FieldTemplate($field->getField('field_template_id'))?>
                            <div class="flex-box box-vertical">
                                <div class="form-element-autosave">
                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$template->title().'/index.php');?>
                                </div>
                                <div class="box-wide">
                                    <?=$field->titleToDisplay()?>
                                </div>
                            </div>
                        <?}?>
                        <div>

                        </div>
                    </div>
                </div>
                <div>
                    <div class="isBold">
                        Avito
                    </div>
                    <div class="box-vertical">
                        <div class="box-vertical ">
                            <div class="flex-box box-vertical">
                                <div class="form-element-autosave">
                                    <div>
                                        <div class="toggle-item flex-box flex-vertical-center">
                                            <div class="toggle-bg">
                                                <input type="radio" name="ad_avito" value="0">
                                                <input type="radio" name="ad_avito" <?= $block['ad_avito'] ? 'checked' : ''?> value="1">
                                                <div class="filler"></div>
                                                <div class="switch"></div>
                                            </div>
                                        </div>
                                    </div>                                </div>
                                <div class="box-wide">
                                    Avito                                </div>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="isBold">
                        Бесплатные
                    </div>
                    <div class="box-vertical ">
                        <?
                        $fields_arr = [469];
                        foreach($fields_arr as $field){
                            $field = new Field($field);
                            $template = new FieldTemplate($field->getField('field_template_id'))?>
                            <div class="flex-box box-vertical">
                                <div class="form-element-autosave">
                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$template->title().'/index.php');?>
                                </div>
                                <div class="box-wide">
                                    <?=$field->titleToDisplay()?>
                                </div>
                            </div>
                        <?}?>
                        <div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</form>
