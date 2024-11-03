<?
require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


isset($_GET['table']) ? $table = $_GET['table']: '' ;



if($table != NULL && $table != 'dashboard') {

    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $filter_line = "OR";
        $table1 = new Post(0);
        $table1->getTable($table);
        foreach($table1->getTableColumnsNames() as $column_name){
            $filter_line = $filter_line." $column_name LIKE '%$search%' OR";
        }
        $filter_line = trim($filter_line,'OR');
        $filter_line = 'AND ('.$filter_line.')';
    }



    $source = $pdo->prepare("SELECT * FROM $table WHERE deleted!='1' $filter_line ORDER BY order_row DESC LIMIT 100  ");
    $source->execute();
    if($source->rowCount()){
        while($src = $source->fetch(PDO::FETCH_LAZY)){
            $post = new Post($src->id);
            $post->getTable($table);
            $photo = json_decode($src['photo']);
            $id = $src['id'];
            if($post->isActive()){
                $vis_icon='<i class="fa fa-eye" aria-hidden="true" title="Показывается(нажмите чтобы изменить)"></i>';
            }else {
                $vis_icon = '<i class="fa fa-eye-slash" aria-hidden="true" title="Скрыто(нажмите чтобы изменить)"></i>';
            }
            if($_GET['view'] == 'list'){
                require(PROJECT_ROOT.'/admin/templates/post/list/row/index.php');
            }else{
                require(PROJECT_ROOT.'/admin/templates/post/list/tile/index.php');
            }
        }
    }else{
        echo "не найдено";
    }

}
?>
<? require_once(PROJECT_ROOT.'/admin/components/fieldslist/index.php');?>
