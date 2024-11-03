<style>
    .field-list-variants{

    }

    .field-list-variants > div:hover{
        background: blue;
        color: white;
    }
</style>






<?if($src[$field->title()]){
    $val = new Post($src[$field->title()]);
    $val->getTable($field->getField('linked_table'));

    if($val->getField('town')){
        $town_curr = new Post($val->getField('town'));
        $town_curr->getTable('l_towns');
        $town_val = $town_curr->title();
    }

    if($val->getField('metro')){
        $metro_curr = new Post($val->getField('metro'));
        $metro_curr->getTable('l_metros');
        $metro_val = $metro_curr->title();
    }

}?>



<?// include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>
<?
$sql = $pdo->prepare("SELECT * FROM l_locations WHERE deleted!=1");
$sql->execute();

$arr_towns = [];
$arr_metros = [];

while($item = $sql->fetch(PDO::FETCH_LAZY)) {
    $unit_arr_towns = [];
    $unit_arr_metros = [];

    $unit_arr_towns[0] = $item->id;


    $town = new Post($item->town);
    $town->getTable('l_towns');
    //$unit_arr_towns[1] = str_replace('"', '', $town->title());
    $unit_arr_towns[1] = $town->title();

    $town_type = new Post($item->town_type);
    $town_type->getTable('l_towns_types');
    //$unit_arr_towns[2] = str_replace('"', '', $town_type->title());
    $unit_arr_towns[2] = $town_type->title();

    $town_region = new Post($item->region);
    $town_region->getTable('l_regions');
    //$unit_arr_towns[3] = str_replace('"', '', $town_region->title());
    $unit_arr_towns[3] = $town_region->title();

    $arr_towns[] = $unit_arr_towns;

    if($item->metro){
        $unit_arr_metros[0] = $item->id;
        $metro = new Post($item->metro);
        $metro->getTable('l_metros');
        //$unit_arr_metros[1] = str_replace('"', '', $metro->title());
        $unit_arr_metros[1] = $metro->title();
        $arr_metros[] = $unit_arr_metros;
    }

}
?>

<div class="tabs-block flex-box" style="background: rgba(0,0,0,0.05)">
    <div class="tabs flex-box">
        <div class="tab location-tab box-small" id="location-metro">
            Метро
        </div>
        <div class="tab location-tab box-small" id="location-town">
            Город
        </div>
    </div>
    <div class="tabs-content full-width">
        <div class="tab-content full-width">
            <div class="datalist-field full-width"  style="position: relative;">
                <span style="display: none">
                    <?=json_encode($arr_metros, JSON_UNESCAPED_UNICODE)?>
                </span>
                <input data-table="<?=$field->getField('linked_table')?>" class="datalist-input"   type="text" value="<?=$metro_val?>" />
                <input class="field-location-id location-metro full-width" type="hidden" name="<?=$field->title()?>" value="<?=($post)? $post->getField('location_id') : ''?>"/>
                <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey">

                </div>
            </div>
        </div>
        <div class="tab-content full-width">
            <div class="datalist-field full-width"  style="position: relative;">
                <span style="display: none">
                </span>
                <input data-table="<?=$field->getField('linked_table')?>" class="datalist-input" data-async="1"   type="text" value="<?=$town_val?>" />
                <input class="field-location-id location-town full-width" type="hidden" name="<?=$field->title()?>" value="<?=($post)? $post->getField('location_id') : ''?>" disabled="disabled" />
                <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey">

                </div>
            </div>
        </div>
    </div>
</div>

<div id="location_info">
    <?if($src['location_id']){
        include_once $_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/location/panel.php';
    }?>
</div>





