<?php
///////////СОБИРАЕМ ПРЕДЛОЖЕНИЯ
$sql1 = $pdo->prepare("TRUNCATE TABLE c_industry_offers");
$sql1->execute();


$agent_types_arr = array('1'=>'agent','2'=>'agent_sale', '3'=>'agent_safe', '4'=>'agent_subrent');
$agent_visit_types_arr = array('1'=>'agent_visited','2'=>'agent_visited_sale', '3'=>'agent_visited_safe', '4'=>'agent_visited_subrent');

$num = 1;
$sql = $pdo->prepare("SELECT * FROM c_industry");
$sql->execute();
while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $deals = $item->deal_type;
    $deals = trim($deals,',');
    $deals_arr = explode(',',$deals);
    $obj_id = $item->id;
    $company_id = $item->company_id;
    $contact_id = $item->ccontact_id;
    $agent_id = $item->agent;
    $agent_visit = $item->agent_visited;



    foreach($deals_arr as $offer_deal){
        //echo $num.'<br>';
        // echo $offer_deal;
        echo '<br>';


        $deposit = $item->deposit; //залог

        $prepay_value =  $item->prepay; //старховой депозит



        $agent_field = $agent_types_arr[$offer_deal];
        //$agent_id = $item->$agent_field;

        //echo $agent_field;
        echo '<br>';

        $agent_visited_field = $agent_visit_types_arr[$offer_deal];
        //$agent_visit = $item->$agent_visited_field;


        $site_noprice = $item->onsite_noprice;
        $site_show = $item->onsite;
        $site_show_top = $item->onsite_top;

        $desc = $item->description;
        //$desc = 'fddfd';
        $desc_hand = $item->description_handmade;
        //$desc_hand = 'dfdfdfdf111';

        if($offer_deal == 2){
            $commission_owner = $item->owner_pays_howmuch_sale;
        }else{
            $commission_owner = $item->owner_pays_howmuch;
        }

        $offer_status = $item->result;

        $commission_client = $item->owner_pays_howmuch_4client;
        $pay_through_holidays = $item->owner_pays_howmuch_rentholidays;


        $ins_text = "INSERT INTO c_industry_offers(object_id, company_id, contact_id deal_type, offer_status, agent_id,  agent_visited, description, description_handmade, pay_through_holidays, commission_owner, commission_client, site_price_hide, site_show, site_show_top, deposit, prepay_value)
                                            VALUES('$obj_id', $company_id, $contact_id, '$offer_deal', '$offer_status', '$agent_id', '$agent_visit', '$desc', '$desc_hand', '$pay_through_holidays', '$commission_owner', '$commission_client', '$site_noprice', '$site_show', '$site_show_top', '$deposit', '$prepay_value')";
        echo $ins_text;

        $ins_sql = $pdo->prepare($ins_text);


        $ins_sql->execute();

        echo 'dick';

        $offer_id = $pdo->lastInsertId();



        $upd_sql = $pdo->prepare("UPDATE c_industry_blocks SET offer_id='$offer_id' WHERE parent_id='$obj_id' AND deal_type='$offer_deal'");
        $upd_sql->execute();

        $num++;
        //echo $num.'<br>';
    }
}