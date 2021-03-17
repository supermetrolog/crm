<?if($field->showField('field_input_type') == 'address'){?>
    <input type='text' id="address"  name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
<?}else{?>
    <input type='<?=$field->getField('field_input_type')?>' name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
<?}?>