
<?

$object_id = $obj['id'];


$object = new Building($object_id);

$favourites = $logedUser->getJsonField('favourites');


//include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php');
?>

<?//$deal_forms_arr = ['rent','sale','safe','rent'];?>
<?$deal_forms_offers_arr = [['rent','sale','safe','subrent'],['rent_land','sale_land','safe_land','rent_land']];?>
<?$deal_forms_blocks_arr = [['rent','sale','safe','subrent'],['land','land','land','land']];?>



