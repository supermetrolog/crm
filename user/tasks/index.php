<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 20.11.2018
 * Time: 12:09
 */
?>

<div class='box-small'>
    <div class='widget-title'>
        Задачи
    </div>
    <div class="widget-body">
        <ul>
            <?foreach($logedUser->getUserTasks() as $task){?>
                <?$task_obj = new Task($task['id']);?>
                <li class="<?=($task_obj->getField('finished')) ? 'green-frame' : ''?>">
                    <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/list/index.php');?>
                </li>
            <?}?>
        </ul>
    </div>
</div>
