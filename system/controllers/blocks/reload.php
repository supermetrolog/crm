<?require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?

$block_id = str_replace("block_","",(int)$_GET['id']);
$block = new Block($block_id);
if($block->blockId()){
    echo $block->description();
}else{
    echo 0;
}

