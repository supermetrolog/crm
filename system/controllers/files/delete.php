
<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
$post = new Post($_POST['id']);
$post->getTable((new Table($_POST['table_id']))->tableName());


echo $_POST['table_id'];
echo '<br>';
echo $_POST['id'];


$post->fileDeleteFromPost($_POST['field'],$_POST['file']);