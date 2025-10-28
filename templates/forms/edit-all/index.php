<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<? if($_COOKIE['member_id'] == 141){?>
    <? // require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');?>

<?}?>

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

<div  style="position: relative">
    <form id="edit-all-form" onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php?num=<?=$_GET['num']?>'>
        <div class="form-header flex-box box">
            <div>
                <?if($_POST['form_title']){?>
                    <?=$_POST['form_title']?>.
                <?}else{?>
                    <?=$table_obj->getField('description')?>.
                <?}?>

                <?if($id){?>
                    Редактирование   #<?=$id?>
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


                $forms = $table_obj->getJsonField('grid_elements_test');
                $form = $_POST['form'];

                if($form == 'null'  || $forms->$form == NULL){
                    $form = 'main';
                }
                $forms = $forms->$form;


                ?>




                <div  style="width: 100%;" >
                    <div class="tabs-block" >

                        <div class="tabs flex-box">
                            <?foreach($forms as $page){?>
                                <div class="tab box-wide">
                                    <?=$page[0]?>
                                </div>
                            <?}?>
                        </div>
                        <div style="position: relative">
                            <div class="tabs-content" >
                                <?foreach($forms as $page){?>
                                    <div class="grid-page tab-content <?=(!$first) ? 'tab-content-active' : ''?> <?$first = 1?>  flex-box flex-between flex-wrap">
                                        <?foreach($page[1] as $column){?>
                                            <div class="grid-column box-small" style="width: <?=$column[0]?>; ">
                                                <div class="box-small" style="background: #FFFFFF;">
                                                    <div class="grid-column-elements">
                                                        <?foreach($column[1] as $field_unit) {?>
                                                            <?$field = new Field($field_unit)?>
                                                            <?if($field->isActive() && $field->canSee() && !$field->showField('field_disabled_frontend') ){?>
                                                                <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/index/index.php')?>
                                                            <?}?>
                                                        <?}?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?}?>
                                    </div>
                                <?}?>
                            </div>
                            <?/*if($src['floor_num_id'] == 16 ){?>
                                <div style="position: absolute; z-index: 99; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.5);">

                                </div>
                            <?}*/?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?if($table_id  == 28){?>
            <div class="create-location-options">
                <div class="create-location-new box pointer">
                    Создать доп город/район/регион
                </div>
                <div class="create-location-panel"></div>
            </div>
        <?}?>
        <div class="form-footer flex-box flex-center box">
            <div>
                <button id="go" class="button btn-middle btn-red box-small files_resort">
                    Сохранить
                </button>
            </div>
        </div>
    </form>
    <?if($id){?>
        <?//if(!$post->hasDeal()){?>
        <?if(1){?>
        <?//if(1){?>
		    <div style="display: flex; gap: 10px; justify-content: flex-end; width: 100%;margin: 0 20px 20px 0;">
			    <button class="button btn-highlight box-small card-trash delete_post" data-id="<?=$post->postId()?>" data-table="<?=$post->setTableId()?>" <?if($_POST['redirect']){?>data-redirect="<?=PROJECT_URL.'/'.$table_obj->getField('url_redirect')?>"   <?}?>>
				    <span style="display: inline-flex; gap: 5px; align-items: center;">
					    <span>Удалить</span>
				        <i class="fas fa-trash-alt"></i>
				    </span>
			    </button>
			    <?if ($table_id == 33) {?>
				    <button class="button btn-highlight box-small card-restore delete_post" data-id="<?=$post->postId()?>" data-table="<?=$post->setTableId()?>" <?if($_POST['redirect']){?>data-redirect="<?=PROJECT_URL.'/'.$table_obj->getField('url_redirect')?>"   <?}?>>
					    <span style="display: inline-flex; gap: 5px; align-items: center;">
						    <span>Восстановить</span>
					        <i class="fas fa-undo-alt"></i>
					    </span>
				    </button>
			    <?}?>
		    </div>
        <?}?>
    <?}?>
</div>


