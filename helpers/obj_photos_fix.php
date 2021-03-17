<?php


//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!=1  ");
$sql->execute();

while ($item = $sql->fetch(PDO::FETCH_LAZY)) {

    if($item->photo == '[]' || stristr($item->photo,']') === false){
        $building = new Building($item->id);
        $id = $building->postId();


        $files = array_diff(scandir(PROJECT_ROOT . "/uploads/objects/$id/"), ['..', '.']); //иначе scandir() дает точки
        $files_list = [];

        echo $id.'<br>';
        //var_dump($files);
        //echo 'его фотки далее<br><br>';

        foreach ($files as $file) {

            $file_url = "/uploads/objects/$id/$file";
            //если это картинка а не папка собираем
            //if(!is_dir($file)  && stristr($file, 'del_') === FALSE  && stristr($file, '.') !== FALSE){
            if (!is_dir($file) && stristr($file, 'del_') === FALSE) {
                $files_list[] = $file_url;
                //echo $file.'<br>';
            }
        }

        $building->updateField('photo', json_encode($files_list));
    }



}