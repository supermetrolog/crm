<div class="flex-box field-module">
    <div class="flex-box flex-wrap field-step-1">
        <div class="toggle-checkbox yes-value" style="margin: 3px;">
            <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-1">
                да
            </label>
        </div>
        <div class="toggle-checkbox no-value" style="margin: 3px;">
            <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-2">
                нет
            </label>
        </div>
    </div>
    <div class="field-step-2 <?if($src[$field->title()] != 1){?> hidden <?}?>">
        <select style="max-width: 120px;" id="field-<?=$field->title()?>" class="<?= (trim($value_item)) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>_type' <?=($field->getField('field_is_disabled') || $src[$field->title()] == 2) ? 'disabled' : '' ?>>
            <?

            if(trim($src[$field->title().'_type'])){
                $table_post = new Post(trim($src[$field->title().'_type']));
                $table_post->getTable($field->getField('linked_table'));
                echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
            }else{
                echo "<option value=''>Выберите</option>";
            }
            if(!$field->getField('field_list_empty')){
                $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." $active ");
                $sql->execute();
                while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
                    if($src[$field->title().'_type'] != $sql_src->id && $sql_src->title){
                        echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
                    }
                }
            }
            ?>
        </select>
    </div>
</div>