<div class="flex-box">
    <?

    if($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150){

        $has_max = 0;

        //если создание блоков
        if($table == 'c_industry_blocks'){

            $subitem = new Subitem($src['id']);

            //список полей суммирования
            $fields_check_arr = [
                    'area_floor',
                    'area_mezzanine',
                    'area_office',
                    'area_field',
                    'area_tech',
                    //'pallet_place',

            ];

            //если учавствует в списке полей суммирования
            if(in_array($field->title(),$fields_check_arr)){

                $has_max = 1;

                //общее суммарное поле
                $help_field_all = $field->title().'_full';

                //если блок уже есть
                if($src['id']){
                    //предложение блока и здание блока
                    $help_offer = new Offer($subitem->getField('offer_id'));
                    $help_obj = new Building($help_offer->getField('object_id'));

                    //если аренда или продажа то считаем все в здании минус сумма остальных
                    if($help_offer->getField('deal_type') == 1 || $help_offer->getField('deal_type') == 2){
                        //общая у здания
                        $help_all = $help_obj->getField($help_field_all);
                        //максимальная сумма всех остальных
                        $help_sum = $help_obj->getObjectBlocksMaxSumValueExcept($src['id'],$field->title().'_max');
                    //если субаренда и ответка то все доступное в ПРЕДЛОЖЕНИИ минус сумма других в этом предложении
                    }else{
                        //общая доступная в пердложении
                        $help_all = $help_offer->getField($help_field_all);
                        //максимальная сумма всех остальных в предложении
                        $help_sum = $help_offer->getOfferBlocksMaxSumValueAllExcept($src['id'],$field->title().'_max');
                        //echo 2222;
                    }
                    //var_dump($help_obj->subItems());
                    //echo $help_sum;
                    //вычитаем
                    $help_res = $help_all - $help_sum ;

                //если еще нету
                }else{
                    //предложение блока и здание блока
                    $help_offer = new Offer($_POST['offer_id']);
                    $help_obj = new Building($help_offer->getField('object_id'));


                    if($help_offer->getField('deal_type') == 1 || $help_offer->getField('deal_type') == 2){
                        //общая доступная в здании
                        $help_all = $help_obj->getField($help_field_all);
                    }else{
                        //общая доступная в пердложении
                        $help_all = $help_offer->getField($help_field_all);
                    }

                    //финальное доступное значение)
                    $help_res = $help_all;
                }


                if(!$help_res){
                    $help_res = 0;
                }
            }

        }

        if($has_max){
            $field_max_value = 'max="'.$help_res.'"';
        }else{
            $field_max_value = '';
        }

    }




    ?>
    <?if($table == 'c_industry_parts' ){?>
        <?php
        if($src['id']){
            $floor_id = $src['floor_id'];
            $offer_id = $src['offer_id'];
            $correction_area = $src[$field->title().'_max'];
        }else{
            $floor_id = $_POST['floor_id'];
            $offer_id = $_POST['offer_id'];
            $correction_area = 0;

        }
        $floor= new Floor($floor_id);
        //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        //echo $floor_id;

        //echo $offer_id;

        if(in_array($field->title(),['area_floor','area_mezzanine','area_field','area_office','area_tech'])){
            $min = 0;
            $max = $floor->getFloorOfferFreeSpace($field->title(),$offer_id) + $correction_area;
            $value_min = $max;
            $value_max = $max;
        }elseif(in_array($field->title(),['temperature','ceiling_height','load_floor','load_mezzanine'])){
            $min = $floor->getField($field->title().'_min');
            $max = $floor->getField($field->title().'_max');
            $value_min = $min;
            $value_max = $max;   
        }else{
            $min = '';
            $max = '';
            $value_min = '';
            $value_max = '';
        }



        ?>
        <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
            <div>
                <input step="0.1" <?if($min !==''){?> min="<?=$min?>" <?}?>  <?if($max !==''){?>max="<?=$max?>"  <?}?>  <?//=$field_max_value?> class="filter-input input-range"  <?=($field->getField('field_required')  || $is_required_by_fuck? 'required' : '')?> name="<?=$field->title()?>_min" value="<?=$src[$field->title().'_min'] ?? $value_min?>"  type="number" placeholder=" " />
            </div>
        </div>
        <div>
            -
        </div>
        <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
            <div>
                <input step="0.1" <?if($min !==''){?> min="<?=$min?>" <?}?>  <?if($max !==''){?>max="<?=$max?>"  <?}?>  <?//=$field_max_value?> class="filter-input input-range" <?=($field->getField('field_required') || $is_required_by_fuck ? 'required' : '')?> name="<?=$field->title()?>_max" value="<?=$src[$field->title().'_max'] ?? $value_max?>"   type="number" placeholder=" " />
            </div>
        </div>
    <?}else{?>
        <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
            <div>
                <input step="0.1" <?if(!in_array($field->title(),['temperature'])){?> min="0" <?}?> <?//=$field_max_value?> class="filter-input input-range"  <?=($field->getField('field_required') || $is_required_by_fuck ? 'required' : '')?> name="<?=$field->title()?>_min" value="<?=$src[$field->title().'_min'] ? $src[$field->title().'_min'] : ''?>"  type="number" placeholder=" " />
            </div>
        </div>
        <div>
            -
        </div>
        <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">  
            <div>
                <input step="0.1" <?if(!in_array($field->title(),['temperature'])){?>  min="0" <?}?> <?//=$field_max_value?> class="filter-input input-range" <?=($field->getField('field_required') || $is_required_by_fuck ? 'required' : '')?> name="<?=$field->title()?>_max" value="<?=$src[$field->title().'_max'] ? $src[$field->title().'_max'] : ''?>"  type="number" placeholder=" " />
            </div>
        </div>
    <?}?>

</div>