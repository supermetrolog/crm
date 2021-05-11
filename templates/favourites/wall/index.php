<?php



$selected = $logedUser->getJsonField('favourites');

$presentations = $logedUser->getJsonField('presentations');

$favourites = $logedUser->getJsonField('favourites');



?>



<?foreach ($selected as $item) {
    $offer = new OfferMix();
    $offer->getRealId($item[0],$item[1]);
    //var_dump($presentations);
    if(in_array([$item[0],$item[1]],$presentations)){
        $pres = 1;
    }else{
        $pres = 0;
    }
    $is_favourites_catalog = true;
    //var_dump($offer);

    $offer = new OfferMix($offer->id);
    //echo $pres ;
    //include (PROJECT_ROOT.'/templates/favourites/list/index.php');
    include (PROJECT_ROOT.'/templates/offers/list/index_mix.php');
}?>

<div  style="position: fixed; z-index: 99; right: 0; top: 300px; width: 50px; height: 150px;  font-size :30px;">
    <div class=" flex-box flex-center-center box-vertical" title="удалить все" style=" background:red; ">
        <a href="https://pennylane.pro/system/controllers/favourites/clear_all.php" style="color: white">
            <i class="fas fa-broom"></i>
        </a>
    </div>
    <div class="pdf-download-all flex-box flex-center-center box-vertical" title="скачать все" style=" background:lime;">
        <a href="https://pennylane.pro/system/controllers/presentations/download.php?member_id=<?=$logedUser->member_id()?>" style="color: white">
            <i class="fas fa-file-download"></i>
        </a>
    </div>
    <div class="pdf-select-all flex-box flex-center-center box-vertical pointer" title="Отметить все" style=" background: deepskyblue; ">
        <i class="fas fa-list"></i>
    </div>
</div>

<script>
    $('body').on('click','.pdf-select-all',function(){
        let buttons = document.getElementsByClassName('icon-send-check');
        for(let i = 0; i < buttons.length; i++){
            //console.log(buttons.length);
            //console.log(buttons[i]);
            $(buttons[i]).click();

        }
    });

</script>

<script>
    $('body').on('click', '.icon-star-active', function(){ // лoвим клик пo кнопке
        $(this).closest('.object-item').remove();
    });
</script>





