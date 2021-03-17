
<?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($actual_link);
$object_id = explode('/',$furl['path'])[2];
$object = new Building($object_id);
$contact = new Contact($object->clientId());
?>

<div class="card-title-area box">
    <div class="flex-box">
        <div class="icon-round" title="ссылка на кадастр">
            <a href="https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129&z=20&text=<?=$object->showField('title')?>&type=1&app=search&opened=1" target="_blank">
                <i class="fas fa-hand-point-down"></i>
            </a>
        </div>
        <div>
            <p><b>ID-<?=$object->itemId()?></b>, <span class="ghost">поступление <?=$object->timeFormat($object->publTime())?>, обновление <?=$object->timeFormat($object->lastUpdate())?></span></p>
        </div>
        <div class="icon-round card-trash delete_post" >
            <span title="Удалить"><a href="javascript: 0"><i class="fas fa-trash-alt"></i></a> </span>
        </div>
    </div>
    <div>
        <h1><?=$object->title()?></h1>
    </div>
    <div class="card-top-pictograms ghost box-vertical">
        <ul>
            <?foreach($object->purposes() as $purpose){
                $purpose = new Post($purpose);
                $purpose->getTable('item_purposes');
                ?>
                <li class="icon-square "><a href="#" title="<?=$purpose->title()?>"><?=$purpose->showField('icon')?></a></li>
            <?}?>
        </ul>
    </div>
</div>
<div class="card-search-area box">
    <div class="card-search-line">
        <form action="" method="">
            <input type="text" name="" value="<?=$object->showField('address')?>" placeholder="" />
            <button><i class="fas fa-map-marker-alt"></i></button>
        </form>
    </div>
    <div class="card-search-tags">
        <ul>
            <?if($object->region()){?><li class="button btn-brown"><?=$object->region()?></li><?}?>
            <?if($object->direction()){?><li class="button btn-brown"><?=$object->direction()?></li><?}?>
            <?if($object->village()){?><li class="button btn-brown"><?=$object->village()?></li><?}?>
            <?if($object->highway()){?><li class="button btn-brown"><?=$object->highway()?></li><?}?>
            <?if($object->fromMkad()){?><li class="button btn-brown"><?=$object->fromMkad()?></li><?}?>
            <?if($object->metro()){?><li class="button"><i class="fab fa-monero"></i> <a href="https://metro.yandex.ru/moscow?from=11&to=<?=$object->metroYandex()?>&route=0" target="_blank"><?=$object->metro()?></a></li><?}?>
            <?if($object->railwayStation()){?><li class="button"><i class="fas fa-subway"></i><?=$object->railwayStation()?></li><?}?>
        </ul>
    </div>
</div>
<div class="card-photo-area" style="height: 270px">
    <div class="card_photo_grid">
        <? $i = 1;
        $photodir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
        $photos = scandir($photodir);
        //echo $_SERVER['DOCUMENT_ROOT']."data/images/c_industry/$object_id/";
        //var_dump($photos);
        foreach($photos as $thumb){
            //foreach($object->thumbs() as $thumb){
            $thumb = trim($thumb,'.');
            if(stristr($thumb, 'del') === FALSE &&  $thumb != NULL){
                ($i > 5)? $height='125' : $height = '250'; ?>
                <div class="flex-box flex-around background-fix grid_photo_<?=$i?>" style="width: 100%; height: <?=$height?>px; background-image: url(<?=PROJECT_URL.'/'."/data/images/c_industry/$object_id/".$thumb?>) " >
                    <?if($i > 14){?>
                        <div class="isBold" style="font-size: 30px; color: white; cursor: pointer; text-shadow: 1px 1px 2px black, 0 0 1em #000000;  ">
                            +<?=(count($photos) - $i)?>
                            <!--+<?=$object->photoCount() - $i?>-->
                        </div>
                    <?}?>
                </div>
                <?$i++;}?>
            <?if($i > 15){break;}?>
        <?}?>
    </div>
</div>
<div class="card-info-area box">
    <ul>
        <li>О строении</li>
        <li>Планировки</li>
        <li>Презентации</li>
        <li>Договора</li>
        <li>Документы</li>
    </ul>
</div>
<div class="object-info-sections">
    <div class="object-about flex-box col-4-grid box text_left">
        <div class="object-about-section object-params-list col-1 ">
            <div class="box"><b>Основное</b></div>
            <ul>
                <li>
                    <div>
                        Общая площадь
                    </div>
                    <div>
                        <?=$object->showField('t_area')?>
                    </div>
                </li>
                <li>
                    <div>
                        Из них мезонин
                    </div>
                    <div>
                        его еще нету
                    </div>
                </li>
                <li>
                    <div>
                        Из них офисов
                    </div>
                    <div>
                        <?=$object->showField('o_area')?>
                    </div>
                </li>
                <li>
                    <div>
                        Этажность склада
                    </div>
                    <div>
                        <?=$object->showField('floors')?> этаж(а)
                    </div>
                </li>
                <li>
                    <div>
                        Площадь участка
                    </div>
                    <div>
                        <?=$object->showField('u_area')?>
                    </div>
                </li>
                <li>
                    <div>
                        Правовой статус
                    </div>
                    <div>
                        смотреть есть или нет
                    </div>
                </li>
                <li>
                    <div>
                        Кадастровый номер
                    </div>
                    <div>
                        этого еще нет
                    </div>
                </li>
                <li>
                    <div>
                        Уличное хранение
                    </div>
                    <div>
                        этого еще нету
                    </div>
                </li>
                <li>
                    <div>
                        Год постройки
                    </div>
                    <div>
                        <?=$object->showField('year_build')?>
                    </div>
                </li>
                <li>
                    <div>
                        Внешняя отделка
                    </div>
                    <div>
                        <?=$object->showField('facing_type')?>
                    </div>
                </li>
                <li>
                    <div>
                        Класс объекта
                    </div>
                    <div>
                        <?=$object->classType()?>
                    </div>
                </li>
            </ul>
        </div>
        <div class="object-about-section object-params-list col-2 ">
            <div class="box"><b>Коммуникации</b></div>
            <ul>
                <li>
                    <div>
                        Электричество
                    </div>
                    <div>
                        <?= ($object->showField('power_all')) ? $object->showField('power_all')  :  $object->showField('power')?>
                    </div>
                </li>
                <li>
                    <div>
                        Отопление
                    </div>
                    <div>
                        <?=$object->heatType()?>
                    </div>
                </li>
                <li>
                    <div>
                        Водоснабжение
                    </div>
                    <div>
                        <?=$object->waterType()?>
                    </div>
                </li>
                <li>
                    <div>
                        Канализация
                    </div>
                    <div>
                        <?= ($object->showField('sewage')) ? $object->sewageType() : '-'?>
                    </div>
                </li>
                <li>
                    <div>
                        Вентиляция
                    </div>
                    <div>
                        <?= ($object->showField('ventilation')) ? $object->ventilationType() : '-'?>
                    </div>
                </li>
                <li>
                    <div>
                        Газ
                    </div>
                    <div>
                        <?= ($object->showField('gas')) ? 'есть' : 'нет'?>
                        <?= ($object->showField('gas')) ? $object->showField('gas_how') : ''?>
                    </div>
                </li>
                <li>
                    <div>
                        Пар
                    </div>
                    <div>
                        <?= ($object->showField('vape')) ? 'есть' : 'нет'?>
                        <?= ($object->showField('vape_how')) ? $object->showField('vape_how') : ''?>
                    </div>
                </li>
                <li>
                    <div>
                        Телефония
                    </div>
                    <div>
                        <?= ($object->showField('telephony')) ? $object->telType() : '-'?>
                    </div>
                </li>
                <li>
                    <div>
                        Интернет
                    </div>
                    <div>
                        <?= ($object->showField('internet')) ? $object->internetType() : '-'?>
                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
            </ul>
        </div>
        <div class="object-about-section object-params-list col-3 ">
            <div class="box"><b>Безопасность</b></div>
            <ul>
                <li>
                    <div>
                        Охрана объекта
                    </div>
                    <div>
                        <?=$object->guardType()?>
                    </div>
                </li>
                <li>
                    <div>
                        Пожаротушение
                    </div>
                    <div>
                        <?=$object->firefightingType()?>
                    </div>
                </li>
                <li>
                    <div>
                        Видеонаблюдение
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Контроль доступа
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Охранная сигнализация
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Пожарная сигнализация
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Дымоудаление
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
            </ul>
        </div>
        <div class="object-about-section object-params-list col-4 ">
            <div class="box"><b>Ж/Д на территории</b></div>
            <ul>
                <li>
                    <div>
                        Ж/Д ветка
                    </div>
                    <div>
                        <?= ($object->showField('railway')) ? 'есть' : '-'?>
                        <?= ($object->showField('railway_length')) ? $object->showField('railway_length').'м' : ''?>
                    </div>
                </li>
                <li>
                    <div>
                        Козловые краны
                    </div>
                    <div>
                        2222
                    </div>
                </li>
                <li>
                    <div>
                        Ж/Д краны
                    </div>
                    <div>
                        222222
                    </div>
                </li>
                <li>
                    <div>
                        &#160;
                    </div>
                    <div>

                    </div>
                </li>
                <li>
                    <div>
                        <b>Инфраструктура</b>
                    </div>

                </li>
                <li>
                    <div>
                        Вьезд
                    </div>
                    <div>
                        <?=$object->entranceType()?>
                    </div>
                </li>
                <li>
                    <div>
                        &#171;P&#187; легковая
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        &#171;P&#187; 3-10 тонн
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        &#171;P&#187; от 10 тонн
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Столовая/кафе
                    </div>
                    <div>
                        2222222
                    </div>
                </li>
                <li>
                    <div>
                        Общежитие
                    </div>
                    <div>
                        2222
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="object-plans">

    </div>
    <div class="object-presentations">

    </div>
    <div class="object-contracts">

    </div>
    <div class="object-documents">

    </div>
    <div class="flex-box flex-center box">
        <div class="icon-round icon-dark">
            <i class="fas fa-angle-up"></i>
        </div>
    </div>
</div>
<div style="height: 20px">

</div>
<div class="card-body">

    <div class="card-buy-type flex-box flex-center" >
        <div class="search-categories box">
            <?foreach($object->dealTypes() as $dealType){
                $dealType1 = new Post($dealType);
                $dealType1->getTable('c_deal_types');?>
                <div>
                    <label class="radio-container">
                        <input type="radio" <?=($dealType['id'] == $_POST['deal_type']) ? 'checked' : '' ;?> value="<?=$dealType['id']?>" name="deal_type"/>
                        <span class="checkmark"><?=$dealType1->title()?></span>
                    </label>
                </div>
            <?}?>
        </div>
    </div>
    <div class="card-buy-type-customer flex-box flex-center">
        <div class="search-categories box">
            <div>
                <label class="radio-container">
                    <input type="radio" value="1" name="deal_type">
                    <span class="checkmark">ООО Каприз 500-5000м2</span>
                </label>
            </div>
            <div>
                <label class="radio-container">
                    <input type="radio" value="1" name="deal_type">
                    <span class="checkmark">ООО Машина 500-5000м2</span>
                </label>
            </div>
            <div>
                <label class="radio-container">
                    <input type="radio" value="1" name="deal_type">
                    <span class="checkmark">ООО Зюганов 500-5000м2</span>
                </label>
            </div>
            <div>
                <label class="radio-container">
                    <input type="radio" value="1" name="deal_type">
                    <span class="checkmark">ООО МЛЗ 500-5000м2</span>
                </label>
            </div>
            <div>
                <label class="radio-container">
                    <input type="radio" value="1" name="deal_type">
                    <span class="checkmark">ООО Каприз 500-5000м2</span>
                </label>
            </div>
        </div>
    </div>
    <div class="card-params-area">
        <div class="card-stats-area flex-box flex-wrap">
            <div class=" half text_left  box">
                <div class="box">
                    <h1>2 000 - 15 000 м2</h1>
                </div>
                <div class="object-params-list">
                    <ul>
                        <li>
                            <div>
                                Из них мезонин
                            </div>
                            <div>
                                222
                            </div>
                        </li>
                        <li>
                            <div>
                                + площадь офисов
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кол-во палет-мест
                            </div>
                            <div>
                                222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Стеллажи
                            </div>
                            <div>
                                222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Зарядная комната
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Складская техника
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Высота, рабочая
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Тип ворот
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кол-во ворот
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Тип пола
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Нагрузка на пол
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                 Нагрузка на мезонин
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Шаг колонн
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Отопление
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                температурный режим
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Лифты/подъемники
                            </div>
                            <div>
                                22222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кран-балки
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                        <li>
                            <div>
                                Мостовые краны
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                        <li>
                            <div>
                                Тельферы
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="half text_left  box">
                <div class="box">
                    <h1>3 000 - 6 500 м2</h1>
                </div>
                <div style="padding: 0 20px 12px 20px">
                    <ul class="flex-box icon-row">
                        <li class="icon-square"><a href="#" title="НДС включено">ндс</a></li>
                        <li class="icon-square"><a href="#" title="OPEX включено">opex</a></li>
                        <li class="icon-square"><a href="#" title="НДС включено">ндс</a></li>
                        <li class="icon-square"><a href="#" title="OPEX включено">opex</a></li>
                    </ul>
                </div>
                <div class="object-params-list">
                    <ul>
                        <li>
                            <div>
                                Из них мезонин
                            </div>
                            <div>
                                222
                            </div>
                        </li>
                        <li>
                            <div>
                                + площадь офисов
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кол-во палет-мест
                            </div>
                            <div>
                                222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Зарядная комната
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Складская техника
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Высота, рабочая
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Тип ворот
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кол-во ворот
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Тип пола
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Нагрузка на пол
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Нагрузка на мезонин
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Шаг колонн
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Отопление
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                температурный режим
                            </div>
                            <div>
                                2222222
                            </div>
                        </li>
                        <li>
                            <div>
                                Лифты/подъемники
                            </div>
                            <div>
                                22222
                            </div>
                        </li>
                        <li>
                            <div>
                                Кран-балки
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                        <li>
                            <div>
                                Мостовые краны
                            </div>
                            <div>
                                2222
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box">
                <div>
                    <b>Описание <span><i class="fas fa-angle-up"></i></span></b>
                </div>
            </div>
        </div>
        <div class="card-contacts-area">
            <div class="flex-box box">
                <div>
                    <select>
                        <option>Сдается</option>
                        <option>Сдано</option>
                    </select>
                </div>
                <div class=" flex-box to-end">
                    <div class="icon-round"><a href=""><i class="fas fa-rocket"></i></a></div>
                    <div class="icon-round"><a class="modal-call-btn" data-modal="object-edit"><i class="fas fa-pencil-alt"></i></a></div>
                    <div class="icon-round"><a href=""><i class="fas fa-envelope"></i></a></div>
                    <div class="icon-round"><a href=""><i class="far fa-file-pdf"></i></a></div>
                    <div class="icon-round"><a class="icon-star" href=""><i class="fas fa-star"></i></a></div>
                    <div class="icon-round"><a class="icon-bell" href=""><i class="fas fa-bell"></i></a></div>
                    <div class="icon-round"><a class="icon-thumbs-down" href=""><i class="fas fa-thumbs-down"></i></a></div>
                </div>
            </div>
            <div class="card-contacts-area-inner flex-box box text_left flex-box-verical flex-between flex-box-to-left">
                <?php
                $client = new Client($object->clientId());
                $company = new Company($client->company());

                ?>
                <div>
                    <div>
                        <b>
                            <?=$company->title()?>
                        </b>
                    </div>
                    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

                    <div class="star-rating">
                        <div class="star-rating__wrap">
                            <?php
                            $rating = new Post(0);
                            $rating->getTable('rating_points');
                            foreach ($rating->getAllUnitsReverse() as $raiting_unit){
                                ?>
                                <input disabled <?=($company->rating() == $raiting_unit['id'])? 'checked' : ''?> class="star-rating__input" id="star-rating-<?=$raiting_unit['id']?>" type="radio" name="rating" value="<?=$raiting_unit['id']?>">
                                <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-<?=$raiting_unit['id']?>" title="<?=$raiting_unit['title']?>"></label>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <?=$object->ownerPerson()?>
                    </div>
                    <div class="ghost">
                        <?=$contact->group_name()?>
                    </div>
                    <div>
                        <?=$contact->phone()?>
                    </div>
                </div>
            </div>
            <div class="card-brocker-area">
                <div class="card-brocker-area-inner box text_left flex-box flex-vertical-top ">
                    <div>
                        <div class="ghost">
                            Консультант PLR
                        </div>
                        <div>
                            <b>
                                <?=$object->supervisor()?>
                            </b>
                        </div>
                        <div class="attention">
                            Комиссия 100%, с каникулами
                        </div>
                        <div class="card-agent-history">
                            <ul>
                                <li> Для клиента 30%</li>
                                <li> скрыл цену</li>
                            </ul>
                        </div>
                    </div>
                    <?if($object->agentVisit()){?>
                    <div class="icon-round right" title="агент был на обьекте">
                            <i class="fas fa-binoculars"></i>
                    </div>
                    <?}?>
                </div>
            </div>
        </div>

    </div>
    <div class="box-vertical">
        <div class="card-description-area">
            <div class="card-description-text box">
                <?=$object->description()?>
            </div>
            <div class="card-adv-tmblr box text_left">
                <div class="search-categories ">
                    <div>
                        <label class="radio-container">
                            <input type="radio" />
                            <span class="checkmark">Вручную</span>
                        </label>
                        <label class="radio-container">
                            <input type="radio" />
                            <span class="checkmark">Автоформа</span>
                        </label>
                    </div>
                </div>
                <div class="flex-box box-vertical ">
                    <div class="box-vertical">
                        <span class="toggle-item">
                         <span class="toggle-bg">
                             <input type="radio" name="activity" value="0">
                             <input type="radio" name="activity" value="1">
                             <span class="switch"></span>
                         </span>
                    </span>
                    </div>

                    <div>
                        <span>использовать в рекламе</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-blocks-area text_left flex-box flex-vertical-top">
        <div class="card-blocks-base" style=" width: 250px">
            <div class="box" style="background: #e1e1e1">
                <b>Деление: 12 блоки</b>
            </div>
            <div style="border: 1px solid #ffffff">
                <div class="box" style="border-bottom: 1px dashed #b5b5b5">
                    № блока, связи
                </div>
                <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                    <ul>
                        <li>Общая площадь: <span> *</span></li>
                        <li>Из них мезонин: </li>
                        <li>+площадь офисов:</li>
                        <li>Кол-во палет-мест: <span> *</span></li>
                        <li>Стеллажи: <span> *</span></li>
                        <li>Высота рабочая: <span> *</span></li>
                        <li>Тип ворот:</li>
                        <li>Количество ворот:<span> *</span></li>
                        <li>Тип пола:</li>
                        <li>Нагрузка на пол:</li>
                        <li>Нагрузка на мезонин:</li>
                        <li>Сетка колонн:</li>
                        <li>Отопление:<span> *</span></li>
                        <li>Темперетурный режим:</li>
                        <li>Лифты/подъемники:</li>
                        <li>Кран-балки:</li>
                        <li>Мостовые краны:</li>
                        <li>Тельферы:</li>
                    </ul>
                </div>
                <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                    <ul>
                        <li>Цена склада: <span> *</span></li>
                        <li>за м2 в год</li>
                        <li>&#160;</li>
                        <li>Цена мезонина:</li>
                        <li>Цена офиса:</li>
                        <li>Цена эксплуатации:</li>
                        <li>Цена коммуналки:</li>
                    </ul>
                </div>
                <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                    Статус
                </div>
                <div class="box" style="background: #e1e1e1">
                    Коротко <i class="fas fa-angle-up"></i>
                </div>
            </div>
        </div>
        <div class="card-blocks-list flex-box flex-vertical-top" style="  overflow-x: scroll; overflow-y: hidden;">
            <?foreach ($object->subItems() as $obj_block){?>
                <?$obj_block = new Subitem($obj_block['id'])?>
                <div>
                    <div class="box" style="background: #03c1eb; color: #FFFFFF;">
                        <?=$obj_block->floorNum()?> этаж
                    </div>
                    <div style="border: 1px solid #79a768">
                        <div class="box" style="border-bottom: 1px dashed #b5b5b5">
                            <input type="checkbox"/> <?=$obj_block->showField('parent_id')?>-<?=$obj_block->showField('id_visual')?>
                        </div>
                        <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                            <ul>
                                <li><b><?= ($obj_block->showField('area') != $obj_block->showField('area2')) ? $obj_block->showField('area').'-'.$obj_block->showField('area2') : $obj_block->showField('area') ?> м2</b></li>
                                <li><?= ($obj_block->showField('area_mezz')) ? $obj_block->showField('area_mezz').'м2' : '-'?> </li>
                                <li><?= ($obj_block->showField('area_office')) ? $obj_block->showField('area_office').'м2' : '-'?> </li>
                                <li><?= ($obj_block->showField('pallet_mest2')) ? $obj_block->showField('pallet_mest2').'п.м.' : '-'?> </li>
                                <li><?= ($obj_block->showField('pallet_mest2')) ? 'стеллажирован' : 'нет'?></li>
                                <li><?= ($obj_block->showField('ceiling_height') != $obj_block->showField('ceiling_height2')) ? rtrim(rtrim($obj_block->showField('ceiling_height'),'0'),'.').' - '.rtrim(rtrim($obj_block->showField('ceiling_height2'),'0'),'.') : rtrim(rtrim($obj_block->showField('ceiling_height'), '0'), '.')?> м</li>
                                <li><?= ($obj_block->showField('gate_type')) ? $obj_block->gateType() :  '-'?></li>
                                <li><?= ($obj_block->showField('gates_number')) ? $obj_block->showField('gates_number').' шт' : '-' ?></li>
                                <li><?= ($obj_block->showField('floor_type')) ? $obj_block->floorType() :  '-'?></li>
                                <li><?=$obj_block->showField('floor_load')?> т/м2</li>
                                <li><?= ($obj_block->showField('mezz_load')) ? $obj_block->showField('mezz_load').'т/м2' : '-'?> </li>
                                <li><?= ($obj_block->showField('collon_mesh')) ? $obj_block->columnGrid().' м' :  '-'?></li>
                                <li><?=($obj_block->showField('heated')) ? 'есть' : 'нет'?></li>
                                <li><?= ($obj_block->showField('temp')) ? $obj_block->showField('temp') : '-'?></li>
                                <li>Лифты/подъемники:</li>
                                <li>Кран-балки:</li>
                                <li>Мостовые краны:</li>
                                <li>Тельферы:</li>
                            </ul>
                        </div>
                        <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                            <ul>
                                <li><b><?=$obj_block->showField('rent_price')?> Р м2/год</b></li>
                                <li>&#160;</li>
                                <li>&#160;</li>
                                <li><?= ($obj_block->showField('mezz_price')) ? $obj_block->showField('mezz_price').'м2/год' : '-'?></li>
                                <li><?= ($obj_block->showField('office_price')) ? $obj_block->showField('office_price').'м2/год' : '-'?></li>
                                <li><?= ($obj_block->showField('office_price')) ? $obj_block->showField('office_price').'м2/год' : '-'?></li>
                                <li><?= ($obj_block->showField('office_price')) ? $obj_block->showField('office_price').'м2/год' : '-'?></li>
                            </ul>
                        </div>
                        <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                            <select>
                                <option>Сдается</option>
                                <option>Сдано</option>
                            </select>
                        </div>
                        <div class="flex-box box" style="background: #e1e1e1">
                            <div class="icon-round"><a href=""><i class="fas fa-rocket"></i></a></div>
                            <div class="icon-round"><a class="modal-call-btn" data-modal="object-edit"><i class="fas fa-pencil-alt"></i></a></div>
                            <div class="icon-round"><a href=""><i class="fas fa-envelope"></i></a></div>
                            <div class="icon-round"><a href=""><i class="far fa-file-pdf"></i></a></div>
                            <div class="icon-round"><a class="icon-star" href=""><i class="fas fa-star"></i></a></div>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>

    </div>
    <div class="card-history-area">
        <div class="card-history-form">

        </div>
        <div class="card-history-events">
            <div class="card-history-event">

            </div>
        </div>
    </div>
</div>
<? include_once($_SERVER["DOCUMENT_ROOT"].'/system/templates/modals/object-edit/index.php')?>