<div class="card-blocks-area text_left  tabs-block box-vertical " style="max-width: 1600px;">
    <div class="flex-box flex-vertical-top">
        <div class="card-blocks-base " style=" width: 250px">
            <div class="box" style="background: #e1e1e1">
                <b>Этаж</b>
            </div>
            <div style="border: 1px solid #ffffff">
                <div class="obj-block-stats" style="border-bottom: 1px solid #cfcfcf;" >
                    <ul>
                        <li><b>Площади</b></li>
                        <li>S - пола <span> *</span></li>
                        <li>S - офиснов</li>
                        <li>S - техническая</li>
                        <li>Кол-во палет-мест</li>
                    </ul>
                    <ul>
                        <li><b>Назначения</b></li>
                        <li>---</li>
                    </ul>
                    <ul>
                        <li><b>Характеристики</b></li>
                        <li>Высота рабочая<span> *</span></li>
                        <li class="block-info-floor-types">Тип пола: <span> *</span></li>
                        <li>Нагрузка на пол:</li>
                        <li class="block-info-grid-types">Сетка колонн</li>
                        <li class="block-info-gates">Тип/кол-во ворот<span> *</span></li>
                        <li>Вход в блок</li>
                        <li>Темперетурный режим</li>




                        <li>Габариты участка</li>
                        <li>Рельеф участка</li>
                    </ul>
                    <ul>
                        <li><b>Оборудование</b></li>
                        <li>Стеллажи</li>
                        <li class="block-info-racks">Тип стеллажей</li>
                        <li class="block-info-safe-types">Тип хранения</li>
                        <li>Ячейки</li>
                        <li>Зарядная комната </li>
                        <li>Складская техника </li>
                    </ul>
                    <ul>
                        <li><b>Коммуникации</b></li>
                        <li>Доступная мощность</li>
                        <li>Освещение</li>
                        <li>Отопление</li>
                        <li>Вид отопления</li>
                        <li>Водоснабжение</li>
                        <li>Канализация</li>
                        <li>Вентиляция</li>
                        <li>Климат-контроль</li>
                        <li>Газа для производства</li>
                        <li>Пар для производства</li>
                        <li>Интернет</li>
                        <li>Телефония</li>
                    </ul>
                    <ul>
                        <li><b>Подъемные устройства</b></li>
                        <li class="block-info-elevators">Лифты/подъемники</li>
                        <li class="block-info-cranes_cathead">Кран-балки</li>
                        <li class="block-info-cranes_overhead">Мостовые краны</li>
                        <li class="block-info-telphers">Тельферы</li>
                        <li>Подкрановые пути </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="card-blocks-list flex-box flex-vertical-top" >
            <?$parts = $obj_block->getJsonField('parts')?>
            <?
            $parts_line = implode(',',$parts);
            if(!$parts_line){
                $parts_line = 0;
            }
            $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
            $sql->execute();
            while($part = $sql->fetch(PDO::FETCH_LAZY)){?>
                <?$part= new Part($part->id)?>

                <div class="flex-box flex-vertical-top tab stack-block <?=($obj_block->getField('status') == 2 ) ? 'ghost' : ''?>">
                    <div id="subitem-<?=$obj_block->postId()?>" class="object-block " style="width: 200px ;">
                        <div class="box " style="background: <?=$part->getFloorColor()?>; color: #FFFFFF;">
                            <?=$part->getFloorName()?>
                        </div>
                        <div class="block_stats" style="border: 1px solid #79a768">
                            <div class="wer obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                <ul>
                                    <li>
                                        &#160;
                                    </li>
                                    <li>
                                        <?if(in_array($part->getFloorNumId(),[16])){
                                            $area_min = $part->getField('area_field_min');
                                            $area_max = $part->getField('area_field_max');
                                        }elseif(in_array($part->getFloorNumId(),[2,3,4,5])){
                                            $area_min = $part->getField('area_mezzanine_min');
                                            $area_max = $part->getField('area_mezzanine_max');
                                        }else{
                                            $area_min = $part->getField('area_floor_min');
                                            $area_max = $part->getField('area_floor_max');
                                        }?>
                                        <b>
                                            <?= valuesCompare($area_min,$area_max) ?> <span>м<sup>2</sup></span>
                                        </b>
                                    </li>

                                    <li>
                                        <?if($part->getField('area_office_min')){?>
                                        <?= valuesCompare($part->getField('area_office_min'),$part->getField('area_office_max')) ?> <span>м<sup>2</sup>
                                            <?}else{?>
                                                -
                                            <?}?>
                                    </li>
                                    <li>
                                        <?if($part->getField('area_tech_min')){?>
                                            <?= valuesCompare($part->getField('area_tech_min'),$part->getField('area_tech_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li>
                                        <?if($part->getField('pallet_place_min')){?>
                                            <?= valuesCompare($part->getField('pallet_place_min'),$part->getField('pallet_place_max')) ?>  п.м.
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                </ul>
                                <ul>
                                    <li style="height: 47px;">
                                        <div>
                                            <?if(arrayIsNotEmpty($part->getJsonField('purposes_block'))){?>
                                                <?foreach($part->getJsonField('purposes_block') as $purpose){?>
                                                    <?
                                                    $purpose = new Post((int)$purpose);
                                                    $purpose->getTable('l_purposes');
                                                    ?>
                                                    <div class="icon-square">
                                                        <a href="#" title="<?=$purpose->title()?>"><?=$purpose->getField('icon')?></a>
                                                    </div>
                                                <?}?>
                                            <?}?>
                                        </div>
                                    </li>
                                </ul>
                                <ul>
                                    <li>&#160;</li>
                                    <li>
                                        <?if($part->getField('ceiling_height_min')){?>
                                            <?= valuesCompare($part->getField('ceiling_height_min'),$part->getField('ceiling_height_max')) ?> м
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li class="block-info-floor-types">
                                        <?if($part->getField('floor_types')){
                                            $floor_type = 'floor_types';
                                            $floor_type_table = 'l_floor_types';
                                        }elseif($part->getField('floor_type_land')){
                                            $floor_type = 'floor_type_land';
                                            $floor_type_table = 'l_floor_types_land';
                                        }else{
                                            $floor_type = 0;
                                            $floor_type_table = '';
                                        }?>
                                        <?if($floor_type) {?>
                                            <?foreach($part->getJsonField($floor_type) as $type){?>
                                                <? $rack = new Post($type)?>
                                                <? $rack->getTable($floor_type_table)?>
                                                <div>
                                                    <?=$rack->title()?>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li>
                                        <?if(in_array($part->getFloorNumId(),[2,3,4,5])){
                                            $load = valuesCompare($part->getField('load_mezzanine_min'),$part->getField('load_mezzanine_max'));
                                        }else{
                                            $load = valuesCompare($part->getField('load_floor_min'),$part->getField('load_floor_max'));
                                        }?>
                                        <?if($load){?>
                                            <?= $load ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li class="block-info-grid-types">
                                        <?if(arrayIsNotEmpty($part->getJsonField('column_grids'))) {?>
                                            <?foreach($part->getJsonField('column_grids') as $type){?>
                                                <? $rack = new Post($type)?>
                                                <? $rack->getTable('l_pillars_grid')?>
                                                <div>
                                                    <?=$rack->title()?>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <?
                                    $gates = $part->getJsonField('gates');
                                    $gate_types = [];
                                    $amount = count($gates);
                                    for($i = 0; $i < $amount; $i = $i+2) {
                                        if ($gate_types[$gates[$i]]) {
                                            $gate_types[$gates[$i]] += $gates[$i+1] ;
                                        }else{
                                            $gate_types[$gates[$i]] = $gates[$i+1];
                                        }
                                    }
                                    ?>
                                    <li class="block-info-gates">
                                        <?if($gates && $gate_types){?>
                                            <?foreach($gate_types as $key=>$value){?>
                                                <?
                                                $gate = new Post($key);
                                                $gate->getTable('l_gates_types');
                                                ?>
                                                <div class="flex-box">
                                                    <div class="ghost"><?=$value?> шт /</div>  <div><?=$gate->title()?></div>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li>
                                        <?if($part->getField('enterance_block')){?>
                                            <?
                                            $enterance_block = new Post($part->getField('enterance_block'));
                                            $enterance_block->getTable('l_enterances');
                                            ?>
                                            <?=$enterance_block->title()?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>

                                    <li>
                                        <?if($part->getField('heated') == 1){?>
                                            тёплый
                                        <?}else{?>
                                            -
                                        <?}?>
                                        <?if($temp_min = $part->getField('temperature_min')){?>
                                            <?=($temp_min > 0) ? '+' : ''?>
                                            <?=$temp_min?>
                                            &#176;С
                                        <?}?>

                                        <?if($temp_max = $part->getField('temperature_max')){?>
                                            /
                                            <?=($temp_max > 0) ? '+' : ''?>
                                            <?=$temp_max?>
                                            &#176;С
                                        <?}?>
                                    </li>
                                    <li>
                                        <?if($part->getField('land_length') && $part->getField('land_width')){?>
                                            <?=$part->getField('land_length')?><i class="fal fa-times"></i><?=$part->getField('land_width')?>  м.
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li>
                                        <?= ($part->getField('landscape_type')) ? $part->landscapeType() :  '-'?>
                                    </li>
                                </ul>
                                <ul>
                                    <li>&#160;</li>
                                    <li><?= ($part->getField('racks')) ? 'есть' : '-'?></li>
                                    <li class="block-info-racks">
                                        <?if($part->getField('rack_types')) {?>
                                            <?foreach($part->getJsonField('rack_types') as $type){?>
                                                <? $rack = new Post($type)?>
                                                <? $rack->getTable('l_racks_types')?>
                                                <div>
                                                    <?=$rack->title()?>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li class="block-info-safe-types">
                                        <?if($part->getField('safe_type')) {?>
                                            <?foreach($part->getJsonField('safe_type') as $type){?>
                                                <? $safe_type = new Post($type)?>
                                                <? $safe_type->getTable('l_safe_types')?>
                                                <div>
                                                    <?=$safe_type->title()?>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li><?= ($part->getField('cells')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('charging_room')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('warehouse_equipment')) ? 'есть' : '-'?></li>
                                </ul>
                                <ul>
                                    <li>&#160;</li>
                                    <li>
                                        <?if($power = $part->getField('power')){?>
                                            <?=$power?> кВт
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('cells1')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('climate_control')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('gas')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('steam')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('internet')) ? 'есть' : '-'?></li>
                                    <li><?= ($part->getField('phone_line')) ? 'есть' : '-'?></li>
                                </ul>
                                <ul>
                                    <li>&#160;</li>
                                    <?
                                    $cranes = ['elevators','cranes_cathead','cranes_overhead','telphers'];

                                    foreach($cranes as $crane){
                                        $items = $part->getJsonField($crane);
                                        $types = [];
                                        $sorted_arr = [];

                                        for($i = 0; $i < count($items); $i = $i+2) {
                                            if (!in_array($items[$i+1], $types) && $items[$i+1]!=0) {
                                                array_push($types, $items[$i+1]);
                                            }
                                        }

                                        //var_dump($types);

                                        //подсчитываем колво каждого типа
                                        foreach($types as $elem_unique){
                                            for($i = 0; $i < count($items); $i = $i+2) {
                                                if ($items[$i+1] == $elem_unique) {
                                                    $sorted_arr[$elem_unique] += $items[$i];
                                                }
                                            }
                                        }
                                        ?>

                                        <li class="block-info-<?=$crane?>">
                                            <?if($sorted_arr){?>
                                                <?foreach($sorted_arr as $key=>$value){?>
                                                    <div class="flex-box">
                                                        <div class="ghost"><?=$value?> шт /</div>  <div><?=$key?> т.</div>
                                                    </div>
                                                <?}?>
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </li>

                                    <?}?>
                                    <li><?= ($part->getField('cranes_runways')) ? 'есть' : '-'?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>
        </div >
    </div>
</div>