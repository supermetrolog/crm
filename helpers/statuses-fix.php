<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 17.06.2020
 * Time: 16:01
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE status=2 ");
$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $offer = new Offer($item->offer_id);

    $offer->getField('company_id');

    $deal = new Post();
    $deal->getTable('c_industry_deals');
    $deal_id = $deal->createLine(['company_id','client_company_id','agent_id','block_id','description'],[9258,$offer->getField('company_id') ,11,$item->id,'создано автоматом']);

    $block = new Subitem($item->id);
    $block->updateField('deal_id',$deal_id);
}