<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 31.05.2018
 * Time: 15:19
 */
class Subitem extends Post
{

    public function setTable()
    {
        return 'c_industry_blocks';
    }



    public function visualId()
    {
        return $this->showField('id_visual');
    }

    public function dealType(): int
    {
        $offer = new Offer($this->getField('offer_id'));
        return $offer->getField('deal_type');
    }

    public function isLand()
    {
        // $offer = new Offer($this->getField('offer_id'));
        // $object = new Building($offer->getField('object_id'));
        $offer_id = $this->getField('offer_id');
        $offer_id = ($offer_id == "") ? null : $offer_id;
        $offer = new Offer($offer_id);
        $object_id = $this->getField('object_id');
        $object_id = ($object_id == "") ? null : $object_id;
        $object = new Building($object_id);
        return $object->getField('is_land');
    }

    public function hasNoPrice(): bool
    {
        $sum = 0;
        $arr = [
            'price_sub',
            'price_sub_two',
            'price_sub_three',

            'price_field',

            'price_floor',
            'price_floor_two',
            'price_floor_three',
            'price_floor_four',
            'price_floor_five',
            'price_floor_six',

            'price_mezzanine',
            'price_mezzanine_two',
            'price_mezzanine_three',
            'price_mezzanine_four',

            'price_sale',

            'price_safe_floor',
            'price_safe_pallet_eu',
            'price_safe_pallet_fin',
            'price_safe_pallet_us',


        ];

        foreach ($arr as $item) {
            $sum += $this->getField($item . '_min');
            $sum += $this->getField($item . '_max');
        }
        if ($sum > 0) {
            return false;
        }
        return true;

    }

    public function price()
    {
        return $this->getField('price');
    }


    public function showObjectBlockStat($field, $dimension, $placeholder)
    {
        if ($this->showField($field)) {
            return $this->showField($field) . ' ' . $dimension;
        } else {
            return $placeholder;
        }
    }

    public function floorNum()
    {
        return $this->showField('floor');
    }

    public function floorType()
    {
        if ($this->isLand()) {
            $floor = new Post($this->showField('floor_type_land'));
            $floor->getTable('l_floor_types_land');
        } else {
            $floor = new Post($this->showField('floor_type'));
            $floor->getTable('l_floor_types');
        }
        return $floor->title();

    }

    public function landscapeType()
    {
        $landscape = new Post($this->showField('landscape_type'));
        $landscape->getTable('l_landscape');
        return $landscape->title();

    }

    public function floorHeight()
    {
        return $this->showField('floor_height');
    }

    public function getVisualId()
    {
        $offer = new Offer($this->getField('offer_id'));
        $building = new Building($offer->getField('object_id'));
        $row = $offer->subItemsIdFloors();
        $num = count($row);
        $visual_num = 1;
        for ($i = 1; $i <= $num; $i++) {
            if ($row[$i] == $this->postId()) {
                $visual_num = $i + 1;
                break;
            }
        }
        return $building->postId() . '-' . preg_split('//u', $offer->getOfferDealType(), -1,
                PREG_SPLIT_NO_EMPTY)[0] . '-' . $visual_num;

    }


    public function getBlockStacks()
    {
        $ids = [];
        $like = "'%" . '"' . $this->postId() . '"' . "%'";
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE parts LIKE $like AND deleted !=1 ");
        $sql->execute();
        while ($unit = $sql->fetch(PDO::FETCH_LAZY)) {
            $ids[] = $unit->id;
        }
        return $ids;
    }

    public function hasDeal()
    {
        $sql = $this->pdo->prepare("SELECT COUNT(id) as deal_num FROM c_industry_deals WHERE block_id=" . $this->id);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);

        if ($unit['deal_num'] > 0) {
            return true;
        }
        return false;
    }

    public function hasPartUnactive()
    {
        if (!$this->hasDeal()) {
            $parts = $this->getJsonField('parts');
            foreach ($parts as $part) {
                if ((new Part($part))->hasDeal()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getBlockFloorsNum()
    {
        $arr = [];
        $parts_line = implode(',', $this->getJsonField('parts'));
        if (!$parts_line) {
            $parts_line = 0;
        }
        $sql = $this->pdo->prepare("SELECT DISTINCT(p.floor) FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row DESC");
        $sql->execute();
        while ($unit = $sql->fetch(PDO::FETCH_LAZY)) {
            $arr[] = $unit->floor;
        }
        return $arr;
    }

    public function getDealId(): int
    {
        $sql = $this->pdo->prepare("SELECT id FROM c_industry_deals WHERE block_id=" . $this->id);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        if ($unit['id']) {
            return $unit['id'];
        }
        return 0;
    }

    public function hasStacksStrict()
    {
        $ids = [];
        $like = "'%" . '"' . $this->postId() . '"' . "%'";
        $sql = $this->pdo->prepare("SELECT COUNT(id) FROM " . $this->setTable() . " WHERE parts LIKE $like AND stack_strict=1 AND deleted !=1 ");
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        return $unit[0];
    }


    public function getBlockArrayValueEven($field)
    {
        $res_array = [];

        $field_data_arr = json_decode($this->getField($field));
        $length = count($field_data_arr);
        for ($i = 1; $i < $length; $i = $i + 2) {
            if ($field_data_arr[$i]) {
                $res_array[] = $field_data_arr[$i];
            }
        }
        return $res_array;
    }

    public function getBlockArrayValuesEvenMultiple(array $fields)
    {
        $res_array = [];
        foreach ($fields as $field) {
            $field_data_arr = json_decode($this->getField($field));
            $length = count($field_data_arr);
            for ($i = 1; $i < $length; $i = $i + 2) {
                if ($field_data_arr[$i]) {
                    $res_array[] = $field_data_arr[$i];
                }
            }
        }
        return $res_array;
    }

    public function getBlockArrayValuesUnique($field): array
    {
        $res_array = [];
        $parts_line = implode(',', $this->getJsonField('parts'));
        if (!$parts_line) {
            $parts_line = 0;
        }

        $sql = $this->pdo->prepare("SELECT $field FROM c_industry_parts WHERE id IN($parts_line) ");
        $sql->execute();
        while ($unit = $sql->fetch(PDO::FETCH_LAZY)) {
            $arr[] = $unit->$field;
            foreach ($arr as $elem) {
                if (!in_array($elem, $res_array)) {
                    $res_array[] = $elem;
                }
            }
        }

        return $res_array;
        /*

        $res_array = [];

        $arr[] = $this->getBlockArrayValues($field);
        foreach($arr as $elem){
            if(!in_array($elem,$res_array)){
                $res_array[] = $elem;
            }
        }

        return $res_array;*/
    }

    public function getBlockArrayValues($field): array
    {
        $array_values = [];
        foreach ($this->getBlockParts() as $part) {
            $arr = json_decode($part[$field]);
            foreach ($arr as $elem) {
                $array_values[] = $elem;
            }
        }
        return $array_values;
    }

    /**
     * @return string
     *
     * метод для подсчета минимальной площади у ТП
     */
    public function getBlockSumAreaMin()
    {
        if ($this->isLand()) {
            if ($this->dealType() == 3) {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
            } elseif ($this->dealType() == 2) {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
            } else {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
            }
        } else {
            if ($this->dealType() == 3) {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
                if ($this->getField('area_mezzanine_add')) {
                    $area += $this->getField('area_mezzanine_max');
                }
                if ($this->getField('area_tech_add')) {
                    $area += $this->getField('area_tech_max');
                }
            } elseif ($this->dealType() == 2) {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }
                $area = $area + $this->getField('area_mezzanine_min') + $this->getField('area_office_min') + $this->getField('area_tech_max');
            } else {
                $area = $this->getField('area_floor_min');
                if (!$area) {
                    $area = $this->getField('area_floor_max');
                }

                if ($this->getField('area_mezzanine_max')) {
                    $area += $this->getField('area_mezzanine_max');
                }

            }

        }
        return $area;
    }

    /**
     * @return int
     *
     * метод для подсчета суммарной площади у ТП
     */
    public function getBlockSumAreaMax()
    {
        $area = 0;
        if ($this->isLand()) {
            if ($this->dealType() == 3) {
                $area = $this->getField('area_floor_max');
            } elseif ($this->dealType() == 2) {
                $area = $this->getField('area_floor_max');
            } else {
                $area = $this->getField('area_floor_max');
            }
        } else {
            if ($this->dealType() == 3) {
                $area = $this->getField('area_floor_max') + $this->getField('area_mezzanine_max');
            } elseif ($this->dealType() == 2) {
                $area = $this->getField('area_floor_max') + $this->getField('area_mezzanine_max') + $this->getField('area_office_max') + $this->getField('area_tech_max');
            } else {
                $area = $this->getField('area_floor_max') + $this->getField('area_mezzanine_max');
            }
        }
        return $area;
    }

    public function getBlockFieldValueAvailable($field)
    {
        /*
        $max_value = 0;
        $offer = new Offer($this->getField('offer_id'));
        $obj = new Building($offer->getField('object_id'));

        foreach ($obj->subItemsDealType($offer->getField('deal_type')) as $subItem) {
            if($this->postId() != $subItem['id']){
                $max_value += $subItem[$field];
            }
        }

        //если аренда или продажа то считаем все в здании минус сумма остальных
        if($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 2){
            //общая у здания
            $help_all = $obj->getField($field);
            //максимальная сумма всех остальных
            $help_sum = $obj->getObjectBlocksMaxSumValueExcept($src['id'],$field->title().'_max');
            //если субаренда и ответка то все доступное в ПРЕДЛОЖЕНИИ минус сумма других в этом предложении
        }else{
            //общая доступная в пердложении
            $help_all = $help_offer->getField($help_field_all);
            //максимальная сумма всех остальных в предложении
            $help_sum = $help_offer->getOfferBlocksMaxSumValueAllExcept($src['id'],$field->title().'_max');
            //echo 2222;
        }
        return $max_value;
        */
    }

    public function areaFrom()
    {
        if ($this->showField('area_min')) {
            return $this->showField('area_min');
        }

    }

    public function areaUpTo()
    {
        if ($this->showField('area_max') && $this->showField('area_max') != $this->showField('area_min')) {
            return $this->showField('area_max');
        }

    }

    public function areaHasRange()
    {
        if ($this->areaFrom() && $this->areaUpTo()) {
            return ' - ';
        }
    }


    public function ceilingFrom()
    {
        if ($this->showField('ceiling_height_min') > 0) {
            return round($this->showField('ceiling_height_min'));
        }

    }

    public function ceilingUpTo()
    {
        if ($this->showField('ceiling_height_max') > 0 && $this->showField('ceiling_height') != $this->showField('ceiling_height_max')) {
            return round($this->showField('ceiling_height_max'));
        }

    }

    public function ceilingHasRange()
    {
        if ($this->ceilingFrom() && $this->ceilingUpTo()) {
            return ' - ';
        }
    }

    public function isHeated()
    {
        if ($this->showField('heated')) {
            return true;
        } else {
            return false;
        }
    }

    public function incOpex()
    {
        if ($this->showField('payinc_opex')) {
            return true;
        } else {
            return false;
        }
    }

    public function getBlockPartsId()
    {
        return $this->getJsonField('parts');
    }

    public function getBlockParts()
    {
        $res_array = [];
        $parts_line = implode(',', $this->getBlockPartsId());
        if (!$parts_line) {
            $parts_line = 0;
        }


        $sql = $this->pdo->prepare("SELECT * FROM c_industry_parts WHERE id IN($parts_line) ");
        $sql->execute();
        while ($unit = $sql->fetch()) {
            $res_array[] = $unit;
        }
        return $res_array;
    }

    public function getBlockPartsMaxSumValue($field)
    {
        $max_value = 0;
        foreach ($this->getBlockParts() as $part) {
            $max_value += $part[$field];
        }
        return $max_value;
    }

    public function getBlockPartsMaxValue($field)
    {
        $max_value = 0;
        foreach ($this->getBlockParts() as $part) {
            if ($max_value < $part[$field]) {
                $max_value = $part[$field];
            }
        }
        return $max_value;
    }

    public function getBlockPartsMinValue($field)
    {
        $min_value = $this->getBlockPartsMaxValue($field);
        foreach ($this->getBlockParts() as $part) {
            if ($min_value > $part[$field] && $part[$field] != 0) {
                $min_value = $part[$field];
            }
        }
        return $min_value;
    }


    public function getBlockMaxValueMultiple(array $fields): int
    {
        $max_value = 0;
        foreach ($fields as $field) {
            if ($this->getField($field) > $max_value) {
                $max_value = $this->getField($field);
            }
        }
        return $max_value;
    }

    public function getBlockMinValueMultiple(array $fields): int
    {
        $min_value = $this->getBlockMaxValueMultiple($fields);
        foreach ($fields as $field) {
            if ($min_value > $this->getField($field) && $this->getField($field) != 0) {
                $min_value = $this->getField($field);

            }
        }
        return $min_value;
    }


    public function incAir()
    {
        if ($this->showField('payinc_water')) {
            return true;
        } else {
            return false;
        }
    }

    public function incWater()
    {
        if ($this->showField('payinc_water')) {
            return true;
        } else {
            return false;
        }
    }

    public function incElectricity()
    {
        if ($this->showField('payinc_e')) {
            return true;
        } else {
            return false;
        }
    }

    public function incHeat()
    {
        if ($this->showField('payinc_heat')) {
            return true;
        } else {
            return false;
        }
    }

    public function incNds()
    {
        if ($this->showField('payinc')) {
            return true;
        } else {
            return false;
        }
    }

    public function columnGrid()
    {
        $col = new Post($this->showField('column_grid'));
        $col->getTable('l_pillars_grid');
        return $col->title();
    }

    public function gateType()
    {
        $gate = new Post($this->showField('gate_type'));
        $gate->getTable('l_gates_types');
        return $gate->title();
    }


}