<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 31.05.2018
 * Time: 15:19
 */
class Subitem extends Post{

    public function setTable()
    {
        return 'c_industry_blocks';
    }

    public function visualId()
    {
        return $this->showField('id_visual');
    }

    public function rentPrice()
    {
        return $this->showField('rent_price');
    }

    public function dealType()
    {
        $deal = new Post($this->showField('deal_type'));
        $deal->getTable('c_deal_types');
        return $deal->title();
    }

    public function showObjectBlockStat($field, $dimension ,$placeholder ){
        if($this->showField($field)){
            return $this->showField($field).' '.$dimension;
        }else{
            return $placeholder;
        }
    }

    public function floorNum()
    {
        return $this->showField('floor');
    }

    public function floorType()
    {
        $floor = new Post($this->showField('floor_type'));
        $floor->getTable('b_floor_types');
        return $floor->title();
    }

    public function floorHeight()
    {
        return $this->showField('floor_height');
    }

    public function areaFrom()
    {
        if($this->showField('area')){
            return $this->showField('area');
        }

    }

    public function areaUpTo()
    {
        if($this->showField('area2') && $this->showField('area2') != $this->showField('area')){
            return $this->showField('area2');
        }

    }

    public function areaHasRange()
    {
        if($this->areaFrom() && $this->areaUpTo())
        return ' - ';
    }


    public function ceilingFrom()
    {
        if($this->showField('ceiling_height') >0){
            return round($this->showField('ceiling_height'));
        }

    }

    public function ceilingUpTo()
    {
        if($this->showField('ceiling_height2') > 0 && $this->showField('ceiling_height') != $this->showField('ceiling_height2')){
            return round($this->showField('ceiling_height2'));
        }

    }

    public function ceilingHasRange()
    {
        if($this->ceilingFrom() && $this->ceilingUpTo())
            return ' - ';
    }

    public function isHeated()
    {
        if ($this->showField('heated')){
            return true;
        }else{
            return false;
        }
    }

    public function incOpex()
    {
        if ($this->showField('payinc_opex')){
            return true;
        }else{
            return false;
        }
    }

    public function incAir()
    {
        if ($this->showField('payinc_water')){
            return true;
        }else{
            return false;
        }
    }

    public function incWater()
    {
        if ($this->showField('payinc_water')){
            return true;
        }else{
            return false;
        }
    }

    public function incElectricity()
    {
        if ($this->showField('payinc_e')){
            return true;
        }else{
            return false;
        }
    }

    public function incHeat()
    {
        if ($this->showField('payinc_heat')){
            return true;
        }else{
            return false;
        }
    }

    public function incNds()
    {
        if ($this->showField('payinc')){
            return true;
        }else{
            return false;
        }
    }

    public function columnGrid()
    {
        $col = new Post($this->showField('collon_mesh'));
        $col->getTable('l_collon_meshes');
        return $col->title();
    }

    public function gateType()
    {
        $gate = new Post($this->showField('gate_type'));
        $gate->getTable('c_industry_gates');
        return $gate->title();
    }








}