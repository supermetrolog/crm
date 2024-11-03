<?
require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
?>
<?if($_POST['post_id']){?>
    <?$id = $_POST['post_id'] ?>
<?}?>
<?$task = new Task($id)?>

<?//= $task->getField('id')?>

<div class="grid-element-unit task-column-element" data-element-id="<?=$task->postId()?>">
    <?if($task->getField('cover_photo')){?>
        <div class="task-element-banner">
            <img src="<?=$task->getField('cover_photo')?>"/>
        </div>
    <?}?>

    <div class="task-element-status flex-box box-small">
        <?if($task->getField('task_status_id')){?>
            <? $task_status = new  Post($task->getField('task_status_id'))?>
            <? $task_status->getTable('core_tasks_statuses')?>

            <?if($task_status->postId()){?>
                <div class="task-element-status-color" style="background-color: <?=$task_status->getField('highlight_color')?>;" >

                </div>
            <?}?>
        <?}?>

        <div class="task-element-ready box-wide ghost-double">
            <!--45%-->
        </div>
    </div>
    <div>
        <textarea class="full-width box-small"><?=$task->title()?></textarea>
    </div>
    <div class="task-element-options flex-box box-small">
        <div class="flex-box task-element-stats">
            <?if($task->getField('description')){?>
                <div class="ghost" title="У задачи есть описание">
                    <i class="fas fa-align-left"></i>
                </div>
            <?}?>
            <?//if(count($task->getPostComments()) > 0){?>
            <div class="modal-call-btn ghost box-wide" data-id="<?=$task->postId()?>" data-table="<?=$task->setTableId()?>"  data-modal="post-comments"   data-modal-size="modal-middle"  title="Комментарии записи">
                <i class="far fa-comment"></i>
                <?if(count($task->getPostComments()) > 0){?>
                    <?=count($task->getPostComments())?>
                <?}?>
            </div>
            <?//}?>
            <?if(arrayIsNotEmpty($task->getJsonField('documents'))){?>
                <div class="ghost-double "  title="">
                    <i class="fas fa-file"></i>
                    <?=count($task->getJsonField('documents'))?>
                </div>
            <?}?>
            <?if($task->getField('end_time')){?>
                <div class="ghost box-wide"  title="Срок выполнения">
                    <i class="far fa-clock"></i>
                    <?= date('d M',strtotime($task->getField('end_time')))?>
                </div>
            <?}?>
        </div>
        <div class="ghost to-end">
            <div class="modal-call-btn icon-round  pointer" data-id="<?=$task->postId()?>"   data-table="<?=$task->setTableId()?>" data-modal="edit-all" data-modal-size="modal-middle"  >
                <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
            </div>
        </div>
    </div>
</div>