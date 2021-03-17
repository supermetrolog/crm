<? $obj_block = new Subitem($src['id'] ?? 0) ?>
<div class="object-params-list">
    <ul>
        <li>
            <div class="isBold">

            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div class="isBold">
                Площадь
            </div>
            <div>
                &#160;
            </div>
        </li>
        <?

        $parts_line = implode(',',$obj_block->getJsonField('parts'));
        //$sql = $pdo->prepare("SELECT * FROM c_industry_parts WHERE id IN($parts_line)");
        if(!$parts_line){
            $parts_line = 0;
        }
        $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
        $sql->execute();


        $parts = [];
        $floors_unique = [];
        while($part = $sql->fetch(PDO::FETCH_LAZY)){
            $floor = $part->floor;
            if(isset($floors_unique[$floor])){
                $arr = $floors_unique[$floor];
                $arr[] = $part->id;
                $floors_unique[$floor] = $arr;
            }else{
                $arr = [$part->id] ;
                $floors_unique[$floor] = $arr;
            }
        }
        //var_dump($floors_unique);

        $array_floor_new  = [];

        foreach($floors_unique as $key=>$value){

            $test_part = new Part($value[0]);
            $floor_name = $test_part->getFloorName();

            $areas = [];
            foreach($value as $part_id){
                $part = new Part($part_id);

                if(in_array((string)$key,['1f'])){
                    $areas['min'][] = $part->getField('area_field_min');
                    $areas['max'][] = $part->getField('area_field_max');
                }elseif(in_array((string)$key,['1m','2m','3m','4m'])){
                    $areas['min'][] = $part->getField('area_mezzanine_min');
                    $areas['max'][] = $part->getField('area_mezzanine_max');
                }else{
                    $areas['min'][] = $part->getField('area_floor_min');
                    $areas['max'][] = $part->getField('area_floor_max');
                }
            }
            $array_floor_new[$floor_name] = $areas;

        }

        //var_dump($array_floor_new);


        ?>
        <li>
            <div>
                S-складская
            </div>
            <div>
                <?= valuesCompare($obj_block->getField('area_floor_min'),$obj_block->getField('area_floor_max') + $obj_block->getField('area_mezzanine_max') + $obj_block->getField('area_field_max')  ) ?> м<sup>2</sup>    
            </div>
        </li>
        <?foreach($array_floor_new as $key=>$value){?>
            <li>
                <div>S-<?=$key?></div>
                <div class="to-end"><?=valuesCompare(numFormat(min($value['min'])),numFormat(array_sum($value['max'])))?> м<sup>2</sup></div>
            </li>
        <?}?>
        <?if($obj_block->getField('pallet_place_min')){?>
            <li>
                <div>N - паллет мест</div>
                <div class="to-end">
                    <?= valuesCompare($obj_block->getField('pallet_place_min'),$obj_block->getField('pallet_place_max')) ?> п.м.
                </div>
            </li>
        <?}?>
        <?if($obj_block->getField('area_office_min')){?>
            <li>
                <div>S-офисов</div>
                <div class="to-end">
                    <?= valuesCompare($obj_block->getField('area_office_min'),$obj_block->getField('area_office_max')) ?> м<sup>2</sup>
                </div>
            </li>
        <?}?>
        <?if($obj_block->getField('area_tech_min')){?>
            <li>
                <div>S-техническая</div>
                <div class="to-end">
                    <?= valuesCompare($obj_block->getField('area_tech_min'),$obj_block->getField('area_tech_max')) ?> м<sup>2</sup>
                </div>
            </li>
        <?}?>

        <li>
            <div class="isBold">

            </div>
            <div>
                &#160;
            </div>
        </li>
        <div class="box-small">
            <div class="isBold">
                Возможные назначения
            </div>
            <div>
                <?if(arrayIsNotEmpty($obj_block->getJsonField('purposes_block'))){?>
                    <?foreach($obj_block->getJsonField('purposes_block') as $purpose){?>
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
        </div>
        <li>
            <div class="isBold">

            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div class="isBold">
                Характеристики
            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div>
                Тип пола
            </div>
            <div>
                <? if (!$obj_block->isLand()) {?>
                    <?$grids = $obj_block->getJsonField('floor_types');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post($grid);
                            $grid->getTable('l_floor_types');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                <? } else { ?>
                    <?$grids = $obj_block->getJsonField('floor_types_land');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post($grid);
                            $grid->getTable('l_floor_types_land');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                <? } ?>
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Высота, рабочая
                </div>
                <div>
                    <?= valuesCompare($obj_block->getBlockPartsMinValue('ceiling_height_min'), $obj_block->getBlockPartsMaxValue('ceiling_height_max')) ?> <span>м</span>
                </div>
            </li>
            <li>
                <div>
                    Нагрузка на пол
                </div>
                <div>
                    <?= valuesCompare($obj_block->getField('load_floor_min'), $obj_block->getField('load_floor_max'))?> <span>т/м<sup>2</sup></span>
                </div>
            </li>
            <li>
                <div>
                    Нагрузка на мезонин
                </div>
                <div>
                    <?= valuesCompare($obj_block->getField('load_mezzanine_min'), $obj_block->getField('load_mezzanine_max'))?> <span>т/м<sup>2</sup></span>
                </div>
            </li>
            <li>
                <div>
                    Шаг колонн
                </div>
                <div>
                    <?$grids = $obj_block->getJsonField('column_grids');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post($grid);
                            $grid->getTable('l_pillars_grid');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
            <?
            $gates = $obj_block->getBlockArrayValues('gates');
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
            <li>
                <div>
                    Тип/кол-во ворот
                </div>
                <div>
                    <?if($gate_types){?>
                        <?foreach($gate_types as $key=>$value){
                            $gate = new Post($key);
                            $gate->getTable('l_gates_types');
                            ?>
                            <div class="flex-box">
                                <div><?=$value?> шт </div>/<div  class="box-wide"> <?=$gate->title()?></div>
                            </div>
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
            <li>
                <div>
                    Температурный режим
                </div>
                <div>
                    <?if($temp_min = $obj_block->getBlockPartsMinValue('temperature_min')){?>
                        <?=($temp_min > 0) ? '+' : ''?>
                        <?=$temp_min?>
                    <?}?>
                    <?if($temp_max = $obj_block->getBlockPartsMaxValue('temperature_max')){?>
                        /
                        <?=($temp_max > 0) ? '+' : ''?>
                        <?=$temp_max?>
                    <?}?>
                    <?//= valuesCompare($offer->getOfferBlocksMinValue('temperature_min'), $offer->getOfferBlocksMaxValue('temperature_max'))?> <span>градусов</span>
                </div>
            </li>
            <li>
                <div>
                    Вход в блок
                </div>
                <div>
                    <?if($item = $obj_block->getField('enterance_block')){?>
                        <?=getPostTitle($item,'l_enterances')?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <?}?>
        <li>
            <div>
                &#160;
            </div>
            <div>
                &#160;
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
        <li>
            <div class="isBold">
                Оборудование
            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div>
                Стеллажи
            </div>
            <div>
                <?$racks = $obj_block->getBlockPartsMaxSumValue('racks')?>
                <?=($racks) ? 'есть' : '-' ?> <?=($racks && (($racks/count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : ''?>
            </div>
        </li>
        <li>
            <div>
                Типы стеллажей
            </div>
            <div>
                <?$racks_types = $obj_block->getJsonField('rack_types')?>
                <?if($racks_types) {?>
                    <?foreach($racks_types  as $type){?>
                        <? $rack = new Post($type)?>
                        <? $rack->getTable('l_racks_types')?>
                        <?=$rack->title()?>
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Количество ярусов
            </div>
            <div>
                <?if($levels = $obj_block->getField('rack_levels') ) {?>
                    <?=$levels?> ярусов
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Типы хранения
            </div>
            <div>
                <?if($safe_types = $obj_block->getJsonField('safe_type') ) {?>
                    <?foreach($safe_types as $type){?>
                        <? $safe_type = new Post($type)?>
                        <? $safe_type->getTable('l_safe_types')?>
                        <?=$safe_type->title()?>
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Зарядная комната
            </div>
            <div>
                <?$charging_room = $obj_block->getField('charging_room')?>
                <?=($charging_room) ? 'есть' : '-' ?>
            </div>
        </li>
        <li>
            <div>
                &#160;
            </div>
            <div>
                &#160;
            </div>
        </li>
        <? } ?>
        <li>
            <div class="isBold">
                Коммуникации
            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div>
                Мощность
            </div>
            <div>
                <?if($power_offer = $obj_block->getField('power')){?>
                    <?=$power_offer?> кВт
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Освещение
                </div>
                <div>
                    <?$grids = $obj_block->getJsonField('lighting');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post($grid);
                            $grid->getTable('l_lighting');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <? } ?>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Отопление
                </div>
                <div>
                    <?if($item = $obj_block->getField('heated')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <? } ?>
        <li>
            <div>
                Водоснабжение
            </div>
            <div>
                <?if($item = $obj_block->getField('water')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Канализация
            </div>
            <div>
                <?if($item = $obj_block->getField('sewage')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Вентиляция
                </div>
                <div>
                    <?$grids = $obj_block->getJsonField('ventilation');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post($grid);
                            $grid->getTable('l_ventilations');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
            <li>
                <div>
                    Климат контроль
                </div>
                <div>
                    <?if($item = $obj_block->getField('climate_control')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <? } ?>
        <li>
            <div>
                Газ для производства
            </div>
            <div>
                <?if($item = $obj_block->getField('gas')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Пар для производства
            </div>
            <div>
                <?if($item = $obj_block->getField('steam')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Интернет
            </div>
            <div>
                <?if($item = $obj_block->getField('internet')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Телефония
            </div>
            <div>
                <?if($item = $obj_block->getField('phone_line')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                &#160;
            </div>
            <div>
                &#160;
            </div>
        </li>
        <li>
            <div class="isBold">
                Системы безопасности
            </div>
            <div>
                &#160;
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Пожаротушение
                </div>
                <div>
                    <?// include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php'?>
                    <?$grids = $obj_block->getJsonField('firefighting_type');?>
                    <?if(count($grids)){?>
                        <?foreach($grids as $grid){
                            $grid = new Post((int)2);
                            $grid->getTable('l_firefighting');
                            ?>
                            <?=$grid->title()?> ,
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
            <li>
                <div>
                    Дымоудаление
                </div>
                <div>
                    <?if($item = $obj_block->getField('smoke_exhaust')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <? } ?>
        <li>
            <div>
                Видеонаблюдение
            </div>
            <div>
                <?if($item = $obj_block->getField('video_control')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Контроль доступа
            </div>
            <div>
                <?if($item = $obj_block->getField('access_control')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li>
            <div>
                Охранная сигнализация
            </div>
            <div>
                <?if($item = $obj_block->getField('security_alert')){?>
                    <?if($item == 1){?>
                        есть
                    <?}else{?>
                        нет
                    <?}?>
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <? if (!$obj_block->isLand()) {?>
            <li>
                <div>
                    Пожарная сигнализация
                </div>
                <div>
                    <?if($item = $obj_block->getField('fire_alert')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <?}?>
        <? if ($obj_block->isLand()) {?>
            <li>
                <div>
                    Забор по периметру
                </div>
                <div>
                    <?if($item = $obj_block->getField('fence')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <?}?>
        <? if ($obj_block->isLand()) {?>
            <li>
                <div>
                    Шлагбаум
                </div>
                <div>
                    <?if($item = $obj_block->getField('barrier')){?>
                        <?if($item == 1){?>
                            есть
                        <?}else{?>
                            нет
                        <?}?>
                    <?}else{?>
                        -
                    <?}?>
                </div>
            </li>
        <?}?>

        <li>
            <div>
                &#160;
            </div>
            <div>
                &#160;
            </div>
        </li>

        <li>
            <div class="isBold">
                Краны/Подъемники
            </div>
            <div>
                &#160;
            </div>
        </li>
        <? if (arrayIsNotEmpty($cranes = $obj_block->getJsonField('cranes'))) { ?>
            <? foreach ($cranes as $crane) {?>
                <?if ($crane) {?>
                    <? $crane = new Crane((int)$crane) ?>
                    <?if ($crane->getCraneCapacity()) {?>
                        <li>
                            <div>
                                <?=$crane->getCraneType()?>
                            </div>
                            <div>
                                <?=$crane->getCraneCapacity()?> тонн
                            </div>
                        </li>
                    <? } ?>
                <? } ?>
            <? } ?>
        <? } ?>
        <? if (arrayIsNotEmpty($elevators = $obj_block->getJsonField('elevators'))) { ?>
            <? foreach ($elevators as $elevator) {?>
                <?if ($elevator) {?>
                    <? $elevator = new Elevator((int)$elevator) ?>
                    <?if ($elevator->getElevatorCapacity()) {?>
                        <li>
                            <div>
                                <?=$elevator->getElevatorType()?>
                            </div>
                            <div>
                                <?=$elevator->getElevatorCapacity()?> тонн
                            </div>
                        </li>
                    <? } ?>
                <? } ?>

            <? } ?>
        <? } ?>


        <li>
            <div>
                &#160;
            </div>
            <div>
                &#160;
            </div>
        </li>

        <li>
            <div class="isBold ghost">
                Краны (старое)
            </div>
            <div>
                &#160;
            </div>
        </li>
        <li class="ghost">
            <?
            $elevators = $obj_block->getJsonField('elevators');
            $amount = count($elevators);

            $elevators_types = [];
            $elevators_amount = [];

            for($i = 0; $i < $amount; $i = $i+2) {
                if (!in_array($elevators[$i+1], $elevators_types) && $elevators[$i+1]!=0) {
                    $elevators_types[] = $elevators[$i+1];
                }
                $elevators_amount[] =  $elevators[$i];
            }

            ?>
            <div>
                Лифты/подъемники
            </div>
            <div>
                <?if(count($elevators)){?>
                    <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li class="ghost">
            <?
            $elevators = $obj_block->getJsonField('cranes_cathead');
            $amount = count($elevators);

            $elevators_types = [];
            $elevators_amount = [];

            for($i = 0; $i < $amount; $i = $i+2) {
                if (!in_array($elevators[$i+1], $elevators_types) && $elevators[$i+1]!=0) {
                    $elevators_types[] = $elevators[$i+1];
                }
                $elevators_amount[] =  $elevators[$i];
            }

            ?>
            <div>
                Кран-балки
            </div>
            <div>
                <?if(count($elevators)){?>
                    <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li class="ghost">
            <?
            $elevators = $obj_block->getJsonField('cranes_overhead');
            $amount = count($elevators);

            $elevators_types = [];
            $elevators_amount = [];

            for($i = 0; $i < $amount; $i = $i+2) {
                if (!in_array($elevators[$i+1], $elevators_types) && $elevators[$i+1]!=0) {
                    $elevators_types[] = $elevators[$i+1];
                }
                $elevators_amount[] =  $elevators[$i];
            }

            ?>
            <div>
                Мостовые краны
            </div>
            <div>
                <?if(count($elevators)){?>
                    <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li class="ghost">
            <?
            $elevators = $obj_block->getJsonField('telphers');
            $amount = count($elevators);

            $elevators_types = [];
            $elevators_amount = [];

            for($i = 0; $i < $amount; $i = $i+2) {
                if (!in_array($elevators[$i+1], $elevators_types) && $elevators[$i+1]!=0) {
                    $elevators_types[] = $elevators[$i+1];
                }
                $elevators_amount[] =  $elevators[$i];
            }

            ?>
            <div>
                Тельферы
            </div>
            <div>
                <?if(count($elevators)){?>
                    <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                <?}else{?>
                    -
                <?}?>
            </div>
        </li>
        <li class="ghost">
            <div>
                Подкрановые пути
            </div>
            <div>
                <?$cross = $obj_block->getField('crane_runways')?>
                <?=($cross) ? 'есть' : '-' ?>
            </div>
        </li>

    </ul>
</div>