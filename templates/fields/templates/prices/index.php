<?php


$prices = [
    '1f'=>['price_field','Цена уличного'],
    '1'=>['price_floor','Цена пола 1эт'],
    '1m'=>['price_mezzanine','Цена мезонина 1ур'],
    '2m'=>['price_mezzanine_two','Цена мезонина 2ур'],
    '3m'=>['price_mezzanine_three','Цена мезонина 3ур'],
    '4m'=>['price_mezzanine_four','Цена мезонина 4ур'],
    '2'=>['price_floor_two','Цена 2 эт.'],
    '3'=>['price_floor_three','Цена 3 эт.'],
    '4'=>['price_floor_four','Цена 4 эт.'],
    '5'=>['price_floor_five','Цена 5 эт.'],
    '6'=>['price_floor_six','Цена 6 эт.'],
    '-1'=>['price_sub','Цена -1эт.'],
    '-2'=>['price_sub_two','Цена -2эт.'],
    '-3'=>['price_sub_three','Цена -3эт.'],
];



/*
$prices = [
    '1f'=>['price_field','Цена уличного'],
    '1'=>['price_floor','Цена пола 1эт'],
    '1m'=>['price_mezzanine','Цена мезонина 1ур'],
    '2m'=>['price_mezzanine','Цена мезонина 2ур'],
    '3m'=>['price_mezzanine','Цена мезонина 3ур'],
    '4m'=>['price_mezzanine','Цена мезонина 4ур'],
    '2'=>['price_floor','Цена 2 эт.'],
    '3'=>['price_floor','Цена 3 эт.'],
    '4'=>['price_floor','Цена 4 эт.'],
    '5'=>['price_floor','Цена 5 эт.'],
    '6'=>['price_floor','Цена 6 эт.'],
];
*/

if(1){
    if($table_id == 11 && $id){
        $block = new Subitem($id);
        $floors_num = $block->getBlockFloorsNum();
        //var_dump($floors_num);
        foreach($floors_num as $floor_num){?>
            <div>
                <div class="ghost">
                    <?=$prices[$floor_num][1]?>
                    <span class="box-small-wide">(руб/м<sup>2</sup>/год)</span>
                </div>
                <div class="flex-box ">
                    <div  style=" border: 1px solid #E0E0DD; background: #ffffff;">
                        <div>
                            <input  style=" " required  min="1" <?//=$field_max_value?> class="filter-input input-range" name="<?=$prices[$floor_num][0]?>_min" value="<?=$src[$prices[$floor_num][0].'_min'] ? $src[$prices[$floor_num][0].'_min'] : ''?>"  type="number" placeholder=" " />
                        </div>
                    </div>
                    <div>
                        -
                    </div>
                    <div  style="border: 1px solid #E0E0DD;  background: #ffffff;">
                        <div>
                            <input style="" required  min="1" <?//=$field_max_value?> class="filter-input input-range" name="<?=$prices[$floor_num][0]?>_max" value="<?=$src[$prices[$floor_num][0].'_max'] ? $src[$prices[$floor_num][0].'_max'] : ''?>"  type="number" placeholder=" " />
                        </div>
                    </div>
                    <div class="ghost">

                    </div>
                </div>
            </div>


        <?}
    }
}