<?require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');



$table = $_POST['table'];  //таблица элементов у которых сохраняем сетку
$post_id = $_POST['post_id']; //id поста
$field = $_POST['field'];   //поле в которое записываем сетку в формате json
$elements_table = $_POST['elements_type']; //тиблица элемнтов котрые в сетке
$elements_grid_str = $_POST['elements'];   //json элмементов (невалидированный)


echo $table; echo '<br>';
echo $field; echo '<br>';
echo $post_id; echo '<br>';
echo $elements_grid_str; echo '<br>';


//GET array of grid from JSON to check if user have an access to each block
$els_arr = json_decode($elements_grid_str);
$valid_grid_arr = [];
//echo $elements_grid_str;
//echo '<br>';
/*
foreach($els_arr as $page){

    foreach($page as $column){

        $elements_in_column = [];
        //Разбираю колонку
        foreach($column[1] as $element_id){
            $element = new Post($element_id);
            $element->getTable($elements_table);
            //если элементы существуют и ра разрешенные то пишем и
            if($element->canSee()){
                array_push($elements_in_column, $element->postId());
            }
        }

        //
        $valid_column = array($column[0], $elements_in_column);
        array_push($valid_grid_arr, $valid_column);
    }
    $valid_str = json_encode($valid_grid_arr);
}

*/

$objUpd = new Post($post_id);
$objUpd->getTable($table);

$user = new Member($_COOKIE['member_id']);

if($user->isAdmin()){
    //$objUpd->updateField($field,$valid_str);
    $objUpd->updateField($field,$elements_grid_str);
    echo 'Сохранили';
}else{
    echo "F*ck you, hacker=)";
}


