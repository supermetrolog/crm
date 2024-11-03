<?
$all_tasks = $item->getPostTasks();
$new_tasks = $item->getPostNewTasks();
$progress_tasks = $item->getPostInProgressTasks();
$finished_tasks = $item->getPostFinishedTasks();
?>
<div class="tabs-block">
    <div class="tabs flex-box box-small-wide">
        <?if(count($all_tasks)){?>
            <div class="tasks-preview-switch pointer" style="margin-right: 10px;">
                <i class="far fa-list-alt"></i>
            </div>
            <div class="tab box-small">
                Все <?=count($all_tasks)?>
            </div>
        <?}?>
        <?if(count($new_tasks)){?>
            <div class="tab attention box-small ">
                Новые <?=count($new_tasks)?>
            </div>
        <?}?>
        <?if(count($progress_tasks)){?>
            <div class="tab box-wide">
                В работе <?=count($progress_tasks)?>
            </div>
        <?}?>
        <?if(count($finished_tasks)){?>
            <div class="tab box-small good">
                Завершенные <?=count($finished_tasks)?>
            </div>
        <?}?>
    </div>
    <div class="tabs-content tasks-preview">
        <?if(count($all_tasks) > 0){?>
            <div class="tab-content">
                <div style="border-top: 1px solid #eeeeee;" >
                    <?foreach ($all_tasks as $task){?>
                        <?$task_obj = new Task($task['id']);?>
                        <? $task_status = new  Post($task_obj->getField('task_status_id'))?>
                        <? $task_status->getTable('core_tasks_statuses')?>
                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/tasks/list/index.php';?>
                    <?}?>
                </div>
            </div>
        <?}?>
        <?if(count($new_tasks) > 0){?>
            <div class="tab-content">
                <div style="border-top: 1px solid #eeeeee;" >
                    <?foreach ($new_tasks as $task){?>
                        <?$task_obj = new Task($task['id']);?>
                        <? $task_status = new  Post($task_obj->getField('task_status_id'))?>
                        <? $task_status->getTable('core_tasks_statuses')?>
                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/tasks/list/index.php';?>
                    <?}?>
                </div>
            </div>
        <?}?>
        <?if(count($progress_tasks) > 0){?>
            <div class="tab-content">
                <div style="border-top: 1px solid #eeeeee;" >
                    <?foreach ($progress_tasks as $task){?>
                        <?$task_obj = new Task($task['id']);?>
                        <? $task_status = new  Post($task_obj->getField('task_status_id'))?>
                        <? $task_status->getTable('core_tasks_statuses')?>
                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/tasks/list/index.php';?>
                    <?}?>
                </div>
            </div>
        <?}?>
        <?if(count($finished_tasks) > 0){?>
            <div class="tab-content">
                <div style="border-top: 1px solid #eeeeee;" >
                    <?foreach ($finished_tasks as $task){?>
                        <?$task_obj = new Task($task['id']);?>
                        <? $task_status = new  Post($task_obj->getField('task_status_id'))?>
                        <? $task_status->getTable('core_tasks_statuses')?>
                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/tasks/list/index.php';?>
                    <?}?>
                </div>
            </div>
        <?}?>
    </div>
</div>