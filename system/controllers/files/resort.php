
<? require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
$post = new Post($_POST['id']);
$post->getTable((new Table($_POST['table_id']))->tableName());

$post->updateField($_POST['field'],$_POST['files']);
