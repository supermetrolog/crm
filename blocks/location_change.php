<?if($_GET['type'] == 'location'){?>
    <?if($_GET['type'] == 'location'){?>
        <?$location = new Location($_GET['id']); ?>
        <li class="button btn-transparent isBold isUnderline"><?=$location->getLocationRegion()?></li>

        <?if($location->getField('district') || $location->getField('district_moscow')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDistrictType()?> <?=$location->getLocationDistrict()?></li><?}?>

        <?if($location->getLocationDirection()){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDirection()?></li><?}?>

        <?if($location->getField('town')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationTownType()?> <?=$location->getLocationTown()?></li><?}?>

        <?if($location->getLocationHighway()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighway()?></li><?}?>
        <?if($location->getLocationHighwayMoscow()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighwayMoscow()?></li><?}?>

        <?if($location->getField('metro')){?><li class="button"><i class="fab fa-monero"></i> <a href="https://metro.yandex.ru/moscow?from=11&to=&route=0" target="_blank"><?=$location->getLocationMetro()?></a></li><?}?>
    <?}?>

    <?if($logedUser->isAdmin() && ($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150  )){?>
        <div class="box-wide pointer modal-call-btn" data-form="" data-id="<?=$location->postId()?>" data-table="<?=$location->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
            <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
        </div>
    <?}?>
<?} elseif($_GET['type'] == 'district') {?>
    <?$town = new Post($_GET['id']);?>
    <?$town->getTable('l_districts')?>
    <div class="flex-box">
        <div>
            <?=$town->title()?>
        </div>
        <?if($logedUser->isAdmin() && ($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150  )){?>
            <div class="box-wide pointer modal-call-btn" data-form="" data-id="<?=$town->postId()?>" data-table="<?=$town->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
                <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
            </div>
        <?}?>
    </div>

<?} elseif($_GET['type'] == 'district_former') {?>
    <?$town = new Post($_GET['id']);?>
    <?$town->getTable('l_districts_former')?>
    <div class="flex-box">
        <div>
            <?=$town->title()?>
        </div>
        <?if($logedUser->isAdmin() && ($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150  )){?>
            <div class="box-wide pointer modal-call-btn" data-form="" data-id="<?=$town->postId()?>" data-table="<?=$town->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
                <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
            </div>
        <?}?>
    </div>

<?} else {?>
    <?$town = new Post($_GET['id']);?>
    <?$town->getTable('l_towns')?>
    <div class="flex-box">
        <div>
            <?=$town->title()?>
        </div>
        <?if($logedUser->isAdmin() && ($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150  )){?>
            <div class="box-wide pointer modal-call-btn" data-form="" data-id="<?=$town->postId()?>" data-table="<?=$town->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
                <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
            </div>
        <?}?>
    </div>
<?}?>

<script>
    setTimeout(function(){
        $('.modal-call-btn').click();
    },300);

</script>
