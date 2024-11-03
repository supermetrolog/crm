<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');




if($_COOKIE['member_id']){
    $user = new Member($_COOKIE['member_id']);
    if($_POST['time_request']){
        echo $user->getField('last_check_tasks');
    }else{
        $tasks_arr = [];

        $id = '"'.$_POST['member_id'].'"';
        $last_request = (int)$_POST['last_check_tasks'];
        //$id = '"141"';

        $sql = $pdo->prepare("SELECT * FROM core_tasks WHERE members LIKE '%$id%' AND last_update>$last_request ORDER BY last_update DESC LIMIT 1");
        $sql->execute();
        if($sql->rowCount() > 0){
            while($task = $sql->fetch(PDO::FETCH_LAZY)){
                $task_arr = [];
                $task_arr['title'] = 'Задача: '.$task->title;
                $task_arr['body'] = strip_tags($task->description);
                $task_arr['icon'] = $task->cover_photo ? PROJECT_URL.$task->cover_photo : PROJECT_URL.'/img/g.png';
                $task_arr['image'] = $task->cover_photo ? PROJECT_URL.$task->cover_photo : PROJECT_URL.'/img/g.png';
                $task_arr['dir'] = 'auto';
                $task_arr['silent'] = true;
                $task_arr['requireInteraction'] = true;
                $tasks_arr[] = $task_arr;
            }
            echo json_encode($tasks_arr, JSON_UNESCAPED_UNICODE);

        }

        $user->updateField('last_check_tasks',time());
    }
}else{
    echo time();
}



