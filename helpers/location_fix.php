<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.07.2020
 * Time: 12:35
 */



include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$location_id_arr = [
    '157'=>[661],
    '19'=>[20,21],
    '502'=>[503],
    '613'=>[614],
    '82'=>[83],
    '56'=>[57],
    '102'=>[103],
    '109'=>[110],
    '190'=>[191],
    '480'=>[481],
    '652'=>[653],
    '543'=>[544],
];

//смотрю все локации в списке
foreach ($location_id_arr as $key=>$value) {

    //для каждого убираемого значения
    foreach ($value as $id) {
        //удаляем правило
        //$sql = $pdo->prepare("DELETE FROM l_locations WHERE id=$id");
        //$sql->execute();

        //обновляем лоты с правилом которое удалили - проставляем правило которое вместо него
        $sql_upd = $pdo->prepare("UPDATE c_industry_complex SET location_id=$key WHERE location_id=$id");
        $sql_upd->execute();
    }
}
