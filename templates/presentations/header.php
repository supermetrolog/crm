<div class="pdf-header flex-box " style="position: relative; height: 235px;">
    <div class="pdf_logo  inline-block" >
        <a href="realtor.ru">
            <img style="width:  708px;" src="<?=PROJECT_URL?>/img/pdf/logo.png"/>
        </a>
    </div>
    <div class="pdf_main_contacts inline-block to-end  inline-block " style="font-size: 48px; margin-bottom: 10px; position: absolute; right: 10px; top: 55px; ">
        <div class="box-small-wide text_right" style="border-right: 1px solid red; ">
            <div class="">
                <?$agent = new Member($user_id)?>
                <?=$agent->title()?>
            </div>
            <div class="attention" style="font-size: 32px;">
                Ведущий консультант
            </div>
        </div>
        <div class="box-small">
            <?$phones = $agent->getJsonField('phones')?>
            <?if(($tel_amount = count($phones)) > 0){?>
                <?for($i =0; $i < $tel_amount; $i = $i+2){?>
                        <div class="box-wide">
                            <div>
                                <?=$phones[$i]?>
                                <?if($phones[$i+1]){?>
                                    доб. <?=$phones[$i+1]?>
                                <?}?>
                            </div>
                        </div>
                <?}?>
            <?}?>
        </div>
    </div>
</div>