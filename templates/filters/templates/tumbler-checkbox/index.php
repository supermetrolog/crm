<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.07.2018
 * Time: 12:36
 */
?>

<input type="checkbox" name="<?=trim($filter->filterName())?>[]" value="<?=trim($filter->filterName())?>" <?=(in_array(trim($filter_item->filter_value),$_POST[trim($filter->filterName())])) ? 'checked' : '' ;?> class="tumbler-checkbox" id="checkbox_<?=trim($filter->filterName())?>_<?=trim($filter_item->filter_value)?>" />
<label for="checkbox_<?=trim($filter_item->description)?>_<?=trim($filter_item->filter_value)?>"><?=$filter_item->title?></label>
