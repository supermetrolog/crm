<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.08.2018
 * Time: 15:44
 */
?>
<?
class Offer extends Post{

    public function setTable()
    {
        return 'c_industry_offers';
    }

    public function title(){
        return $this->showField('title');
    }

    public function offerId(){
        return $this->showField('id');
    }

    public function subItems(){
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted!='1' AND offer_id=".$this->postId());
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getOfferObject(){
        return $this->showField('object_id');
    }

    public function getOfferNeighbors(){
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_offers WHERE  object_id='".$this->getOfferObject()."'   ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getOfferStatus(){
        $status = new Post($this->showField('offer_status'));
        $status->getTable('c_industry_results');
        return  $status->showField('title');
    }


    public function getOfferBlocksMaxValue($field){
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            $max_value = $subItem[$field];
        }
        return $max_value;
    }

    public function getOfferBlocksMaxSumValue($field){
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }

    public function getOfferBlocksMinValue($field){
        $min_value = $this->getOfferBlocksMaxValue($field);
        foreach ($this->subItems() as $subItem) {
            if($min_value > $subItem[$field]){
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }

    public function getOfferDealType()
    {
        $deal = new Post($this->showField('deal_type'));
        $deal->getTable('c_deal_types');
        return $deal->title();
    }


    public function getOfferFloors(){
        $floors_arr = array();
        foreach ($this->subItems() as $subItem) {
            if(!in_array($subItem['floor'], $floors_arr)){
               array_push($floors_arr, $subItem['floor']);
            }
        }
        sort($floors_arr);
        return $floors_arr;
    }

    public function floorSubItems(int $floor){
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted!='1' AND floor='$floor' AND offer_id=".$this->postId());
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getOfferFloorBlocksMaxValue(int $floor, $field){
        $max_value = 0;
        foreach ($this->floorSubItems($floor) as $subItem) {
            $max_value = $subItem[$field];
        }
        return $max_value;
    }

    public function getOfferFloorBlocksMinValue(int $floor, $field){
        $min_value = $this->getOfferFloorBlocksMaxValue($floor, $field);
        foreach ($this->floorSubItems($floor) as $subItem) {
            if($min_value > $subItem[$field]){
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }

    public function getOfferFloorBlocksMaxSumValue(int $floor, $field){
        $max_value = 0;
        foreach ($this->floorSubItems($floor) as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }


    public function showOfferCalcStat($value, $dimension ,$placeholder ){
        if($value){
            return $value.' '.$dimension;
        }else{
            return $placeholder;
        }
    }


    public function supervisor(){
        $supervisor = new Member($this->showField('agent_id'));
        return  $supervisor->name();
    }

    public function getOfferContact(){
        $client = new Client($this->showField('client_id'));
        return  $client->showField('c_fio');
    }

    public function getOfferCompany(){
        return $this->showField('company_id');
    }


    public function getOfferCommissionOwner(){
        return $this->showField('commission_owner');
    }

    public function getOfferCommissionClient(){
        return $this->showField('commission_client');
    }

    public function payCommissionThroughHolidays(){
        if($this->showField('pay_through_holidays')){
            return true;
        }else{
            return false;
        }
    }

    public function agentVisited(){
        return $this->showField('agent_visited');
    }

    public function clientId(){
        return  $this->showField('client_id');
    }



    public function getOfferDescription(){

    }

    public function getOfferDescriptionAutomatic(){

    }


}
