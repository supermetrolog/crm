<?if($table == 'c_industry_floors'){?>
    <?
    if($src['id']){
        $floor = new Floor($src['id']);
        $complex_id = $floor->getComplexId();
    }else{
        $complex_id = $_POST['complex_id'];
    }
    $complex = new Complex($complex_id);
    ?>
    <?if(in_array($field->title(),['water','sewage','gas','steam','internet','phone_line'])){?>
        <div class="flex-box flex-wrap">
            <div class="toggle-checkbox" style="margin: 3px; position: relative;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-1">
                    да
                </label>
                <?if($complex->getField($field->title()) == 2){?>
                    <div title="Невозможно выбрать пока в комлексе не проставлено <?=$field->getField('title_show')?>"  style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                    </div>
                <?}?>
            </div>

            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-2">
                    нет
                </label>
            </div>

            <?if($complex->getField($field->title()) != 1 && $src[$field->title()] == 1 ){?>
                <div class="isBold attention">
                    НЕ СООТВЕТСТВУЕТ КОМПЛЕКСУ
                </div>
            <?}?>

        </div>
    <?}elseif($field->title() == 'heated'){?>
        <div class="flex-box flex-wrap">
            <div class="toggle-checkbox" style="margin: 3px; position: relative;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-1">
                    да
                </label>
                <?if($complex->getField('heating_central') == 2 && $complex->getField('heating_autonomous')==2){?>
                    <div title="Невозможно выбрать пока в комлексе не проставлено отопление" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                    </div>
                <?}?>
            </div>

            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-2">
                    нет
                </label>
            </div>
        </div>
    <?}else{?>
        <div class="flex-box flex-wrap">
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-1">
                    да
                </label>
            </div>
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-2">
                    нет
                </label>
            </div>
        </div>
    <?}?>
<?}else{?>
    <?if($table == 'c_industry_parts'){?>
        <?
        $floor = new Floor($_POST['floor_id'] ?? $src['floor_id']);
        ?>
        <?if($src['id']){?>
            <div class="flex-box flex-wrap">
                <div class="toggle-checkbox" style="margin: 3px; position: relative;">
                    <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-1">
                        да
                    </label>
                    <?if( $floor->getField($field->title()) == 2){?>
                        <div title="Невозможно выбрать пока в этаже не проставлено" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                        </div>
                    <?}?>
                </div>
                <div class="toggle-checkbox" style="margin: 3px;">
                    <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-2">
                        нет
                    </label>
                </div>
                <?if($floor->getField($field->title()) != 1 && $floor->hasField($field->title())  && $src[$field->title()] == 1 ){?>
                    <div class="isBold attention">         
                        НЕ СООТВЕТСТВУЕТ ЭТАЖУ
                    </div>
                <?}?>
            </div>
        <?}else{?>
            <div class="flex-box flex-wrap">
                <div class="toggle-checkbox" style="margin: 3px;">
                    <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $floor->getField($field->title())) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-1">
                        да
                    </label>
                    <?if( $floor->hasField($field->title()) &&  1 != $floor->getField($field->title())){?>
                        <div title="Невозможно выбрать пока в этаже не проставлено" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                        </div>
                    <?}?>
                </div>
                <div class="toggle-checkbox" style="margin: 3px;">
                    <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $floor->getField($field->title())) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-2">
                        нет
                    </label>
                </div>
            </div>
        <?}?>
    <?}else{?>
        <div class="flex-box flex-wrap">
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-1">
                    да
                </label>
            </div>
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-2">
                    нет
                </label>
            </div>
        </div>
    <?}?>
<?}?>

<?//=$table?>