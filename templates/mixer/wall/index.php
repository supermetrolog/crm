<div>
    <?

    //include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/global_pass.php';
    if (isset($_POST['complex_id'])) {
        $complex = new Complex((int)$_POST['complex_id']);
    }
    $mixer_parts = $complex->getJsonField('mixer_parts');
    $mixer_parts_str = implode(',', $mixer_parts);
    //echo $mixer_parts;
    //определяем уникальные предложения

    if ($mixer_parts) {
        $sql_offers = $pdo->prepare("SELECT DISTINCT o.id FROM c_industry_offers o LEFT JOIN c_industry_parts p ON  o.id=p.offer_id  WHERE p.id IN($mixer_parts_str) ");
        $sql_offers->execute();
        $offers = [];
        while ($offer = $sql_offers->fetch(PDO::FETCH_LAZY)) {
            $offers[] = $offer->id;
        }
        $offers_str = implode(',', $offers);
        $sql_objs = $pdo->prepare("SELECT DISTINCT i.id FROM c_industry i LEFT JOIN c_industry_offers o ON  i.id=o.object_id  WHERE o.id IN($offers_str) ");
        if ($offers_str != "") {
            $sql_objs->execute();
            $objs = [];
            while ($obj = $sql_objs->fetch(PDO::FETCH_LAZY)) {
                $objs[] = $obj->id;
            }
        }
    ?>
        <? foreach ($objs as $item) { ?>
            <? $obj = new Building($item); ?>
            <div class="mixer-building box-small-vertical">
                <div class="mixer-building-info flex-box">
                    <div>
                        <img style="width: 100px" src="<?= $obj->photo() ?>" />
                    </div>
                    <div class="box-small-wide">
                        <div class="isBold"><?= $obj->getField('area_building') ? $obj->getField('area_building') : $obj->getField('area_field_full') ?> м кв</div>
                        <div><?= $obj->getField('address') ?></div>
                        <div class="attention">ID <?= $obj->postId() ?></div>
                    </div>
                </div>
                <? foreach ($offers as $offer_id) { ?>
                    <? $offer = new Offer($offer_id) ?>
                    <? if ($offer->getField('object_id') == $item) { ?>
                        <div class="mixer-building-deals">
                            <div class="mixer-building-deal-type isBold">
                                <?= $offer->getOfferDealType() ?> (<?= $offer->getOfferCompanyName() ?>)
                            </div>
                            <div class="mixer-building-blocks">
                                <form action="<?= PROJECT_URL ?>/system/controllers/subitems/merge.php" method="get">
                                    <? foreach ($mixer_parts as $part_id) { ?>
                                        <? $part = new Part($part_id) ?>
                                        <? if ($part->getField('offer_id') == $offer_id) { ?>
                                            <div class="flex-box">
                                                <div class="box-small isBold">
                                                    -
                                                </div>
                                                <div class="full-width">
                                                    <div class="mixer-building-block box-small full-width">
                                                        <div>

                                                            <? if ($part->getField('area_field_min') || $part->getField('area_field_max')) { ?>
                                                                <?
                                                                $area_min = $part->getField('area_field_min');
                                                                $area_max = $part->getField('area_field_max');
                                                                ?>
                                                            <? } elseif ($part->getField('area_mezzanine_min') || $part->getField('area_mezzanine_max')) { ?>
                                                                <?
                                                                $area_min = $part->getField('area_mezzanine_min');
                                                                $area_max = $part->getField('area_mezzanine_max');
                                                                ?>
                                                            <? } else { ?>
                                                                <?
                                                                $area_min = $part->getField('area_floor_min');
                                                                $area_max = $part->getField('area_floor_max');
                                                                ?>
                                                            <? } ?>
                                                            <span class="isBold"><?= valuesCompare($area_min, $area_max) ?> м кв</span>,
                                                            <?
                                                            $floor = new Floor($part->getField('floor_id'));
                                                            $floor_obj = new Post($floor->getField('floor_num_id'));
                                                            $floor_obj->getTable('l_floor_nums'); ?>
                                                            <?= $floor_obj->getField('title') ?>
                                                        </div>
                                                        <div class="good">
                                                            Актив
                                                            <input class="" name="blocks[]" checked type="checkbox" value="<?= $part->postId() ?>" />
                                                        </div>
                                                    </div>
                                                    <? if ($offer->getField('deal_type') != 2) { ?>
                                                        <div>
                                                            <div class="flex-box ">
                                                                <? if (stristr($floor_obj->getField('title'), 'Мезонин')) { ?>
                                                                    <div class="area-excluders">
                                                                        <input type="hidden" checked name="<?= $part->postId() ?>_mezz" value="0">
                                                                        без мезю <input type="checkbox" name="<?= $part->postId() ?>_mezz" value="1">
                                                                    </div>
                                                                <? } ?>
                                                                <div class="area-excluders">
                                                                    <input type="hidden" checked name="<?= $part->postId() ?>_office" value="0">
                                                                    без офис <input type="checkbox" name="<?= $part->postId() ?>_office" value="1">
                                                                </div>
                                                                <div class="area-excluders">
                                                                    <input type="hidden" checked name="<?= $part->postId() ?>_tech" value="0">
                                                                    без техн <input type="checkbox" name="<?= $part->postId() ?>_tech" value="1">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        <? } ?>
                                    <? } ?>
                                    <div class="">
                                        Предлагается только целиком
                                        <input onchange="$('.area-excluders').slideToggle(300)" class="" name="is_solid" type="checkbox" value="1" />
                                    </div>
                                    <div class="flex-box">
                                        <div class="to-end">
                                            <button>Собрать</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        <? } ?>
    <? } else { ?>
        <div class="text_center box ghost">
            Ничего не выбрано
        </div>


    <? } ?>



</div>

<script>

</script>