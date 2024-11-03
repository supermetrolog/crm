<?
if($_POST[$field->title()]) {
    $value_item = $_POST[$field->title()];
}elseif($value_item && $field->getField('is_multifield')){

}else{
    if($src[$field->title()]){
        $value_item = $src[$field->title()];
    }else{
        $value_item = '';
    }
}

?>

<div class="flex-box address-validation">
    <div class="full-width">
        <input id="field-<?=$field->title()?>"  type="text"   name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=($value_item)? $value_item : ''; ?>'/>
    </div>
    <div class="to-end box-wide" style="width: 20px;">
        <?php
        $url = 'https://geocode-maps.yandex.ru/1.x/?apikey=7cb3c3f6-2764-4ca3-ba87-121bd8921a4e&format=json&geocode='.urlencode($src[$field->title()]);


        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            //echo $out;
            curl_close($curl);
        }

        $data = json_decode($out);

        ?>
        <?if($data->response->GeoObjectCollection->featureMember[0] && !$data->response->GeoObjectCollection->featureMember[1]){?>
            <i class="fas fa-check good"></i>
        <?}else{?>
            <i class="fas fa-times attention"></i>
        <?}?>
    </div>

</div>
<div id="address-transport">
    <? include_once $_SERVER['DOCUMENT_ROOT'].'/helpers/stations.php' ?>
</div>


<?
$value_item = '';
?>
