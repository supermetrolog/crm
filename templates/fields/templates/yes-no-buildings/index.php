<div class=" field-module">
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
        <div>
            <?
            //получить id комплекса
            $complex_id = $_POST['complex_id'] ?? $src['complex_id'];

            //достать id всех зданий на комплексе
            $sql_building = $pdo->prepare("SELECT id,area_building,photo,company_id FROM c_industry WHERE complex_id=$complex_id AND is_land!=1");
            $sql_building->execute();
            while($building = $sql_building->fetch(PDO::FETCH_LAZY)){?>
                <div class="building-check box-vertical ">
                    <input class="hidden" type="checkbox" id="building_select_<?=$building->id?>" name="buildings_on_territory_id[]" <?if(in_array($building->id,json_decode($src['buildings_on_territory_id']))){?> checked  <?}?> value="<?=$building->id?>" />
                    <label for="building_select_<?=$building->id?>" class="pointer">
                        <div style="border: 1px solid grey">
                            <div class="background-fix" style="height: 150px; background-image: url('<?= json_decode($building->photo)[0]?>');">
                                <div class=" isBold" style="width: 60px; color: #ffffff; background: crimson; padding: 5px 10px;">
                                    ID <?=$building->id?>
                                </div>
                            </div>
                            <div class="box-small">
                                <div class="isBold">
                                    <?=$building->area_building?> м кв
                                </div>
                                <div>
                                    <?//=(new Company($building->company_id))->title()?>
                                </div>
                                <div>
                                    Какой корпус? откуда?
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            <?}?>
        </div>
        <div>
            <div class="tabs-block">
                <div class="tabs flex-box">
                    <div class="tab">
                        Описание строений
                    </div>
                </div>
                <div class="tabs-content">
                    <div class="tab-content">
                        <div class="box-small-vertical flex-box">
                            <textarea   class="<?=($field->getField('field_editor_enable')) ? 'textarea-to-modify' : '' ?>"  name='<?=$field->title()?>_description'   placeholder=' '><?=($src[$field->title().'_description'])? $src[$field->title().'_description'] : $field->getField('field_default_text'); ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>