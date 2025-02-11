<div class="field-module" >
    <div class="flex-box flex-wrap field-step-1">
        <div class="toggle-checkbox yes-value" style="margin: 3px;">
            <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="has_<?=trim($field->title())?>" <?=(1 == $src['has_'.$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-1">
                да
            </label>
        </div>
        <div class="toggle-checkbox no-value" style="margin: 3px;">
            <input   <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="has_<?=trim($field->title())?>" <?=(2 == $src['has_'.$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label  for="<?=trim($field->title())?>-2">
                нет
            </label>
        </div>
    </div>
    <div class="box-wide <?if($src['has_'.$field->title()] != 1){?> hidden <?}?> field-step-2">
        <div class=" flex-wrap cranes-field">
            <input type="hidden" name="<?=trim($field->title())?>" value="0" />
            <?
//            var_dump($src);

            if ($table === 'c_industry') {
	            $object_id = $src['id'];
            } else {
	            $floor = new Floor($_POST['floor_id'] ?? $src['id']);

	            $object_id = $floor->getField('object_id');

				if ($object_id == "") $object_id = null;
            }

            $object = new Building($object_id);

            if($field->title() == 'cranes'){
                $items = $object->getCranes();
                $class = 'Crane';
            }else{
                $items = $object->getElevators();
                $class = 'Elevator';
            }

            $i = 0;
            ?>

            <?foreach($items as $field_item){
                $i++;
                $item_lift = new $class($field_item)?>
                <div class="flex-box">
                    <div class="box-wide">
                        <?=$i?>.
                    </div>
                    <div class="toggle-checkbox full-width" style="border: 1px solid #e1e1e1;" title="<?=$field_item['title']?>">
                        <input  id="<?=trim($field->title())?>-<?=$field_item?>" value="<?=$field_item?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item,json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                        <label style="text-align: left; justify-content: flex-start" class="full-width text_left " for="<?=trim($field->title())?>-<?=$field_item?>">
                            <?if($field->title() == 'cranes'){?>
                                <?=($item = $item_lift->getCraneType()) ?  $item.' /' : '' ?>
                                <?=$item_lift->getCraneCapacity()?> тонн /
                                <?=$item_lift->getCraneLocation()?> /
                                <?=($item = $item_lift->getCraneSpan()) ?  'пролёт '.$item.' м /' : '' ?>
                                <?=($item = $item_lift->getCraneHookHeight()) ?  'до крюка '.$item.' м /' : '' ?>
                                <?=($item = $item_lift->getCraneCondition()) ?  $item.' /' : '' ?>
                            <?}else{?>
                                <?=($item = $item_lift->getElevatorType()) ?  $item.' /' : '' ?>
                                <?=$item_lift->getElevatorCapacity()?> тонн /
                                <?=$item_lift->getElevatorLocation()?> /
                                <?=($item = $item_lift->getElevatorVolume()) ?  $item.' п.м. /' : '' ?>
                                <?=($item = $item_lift->getElevatorCondition()) ?  $item.' /' : '' ?>
                            <?}?>
                        </label>
                    </div>
                </div>

            <?}?>
        </div>
    </div>
</div>

<?/*


<div class=" flex-wrap cranes-field">
    <input type="hidden" name="<?=trim($field->title())?>" value="0" />
    <?

    $floor = new Floor($_POST['floor_id'] ?? $src['floor_id']);
    $object = new Building($floor->getField('object_id'));
    if($field->title() == 'cranes'){
        $items = $object->getCranes();
        $class = 'Crane';
    }else{
        $items = $object->getElevators();
        $class = 'Elevator';
    }

    $i = 0;
    ?>

    <?foreach($items as $field_item){
        $i++;
        $item_lift = new $class($field_item)?>
        <div class="flex-box">
            <div class="box-wide">
                <?=$i?>.
            </div>
            <div class="toggle-checkbox full-width" style="border: 1px solid #e1e1e1;" title="<?=$field_item['title']?>">
                <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                <label style="text-align: left; justify-content: flex-start" class="full-width text_left " for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                    <?if($field->title() == 'cranes'){?>
                        <?=($item = $item_lift->getCraneType()) ?  $item.' /' : '' ?>
                        <?=$item_lift->getCraneCapacity()?> тонн /
                        <?=$item_lift->getCraneLocation()?> /
                        <?=($item = $item_lift->getCraneSpan()) ?  'пролёт '.$item.' м /' : '' ?>
                        <?=($item = $item_lift->getCraneHookHeight()) ?  'до крюка '.$item.' м /' : '' ?>
                        <?=($item = $item_lift->getCraneCondition()) ?  $item.' /' : '' ?>
                    <?}else{?>
                        <?=($item = $item_lift->getElevatorType()) ?  $item.' /' : '' ?>
                        <?=$item_lift->getElevatorCapacity()?> тонн /
                        <?=$item_lift->getElevatorLocation()?> /
                        <?=($item = $item_lift->getElevatorVolume()) ?  $item.' п.м. /' : '' ?>
                        <?=($item = $item_lift->getElevatorCondition()) ?  $item.' /' : '' ?>
                    <?}?>
                </label>
            </div>
        </div>

    <?}?>
</div>
?>
<style>
    .cranes-field .toggle-checkbox:nth-child(2){
        background: #f5f5f5;
    }
</style>
