<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.08.2018
 * Time: 15:44
 */
?>
<?

class Offer extends Post
{

    public $subitemsActive;

    public function setTable()
    {
        return 'c_industry_offers';
    }

    public function title()
    {
        return $this->getField('title');
    }

    public function offerId(): int
    {
        return $this->getField('id');
    }

    public function subItems(): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND deleted!=1  AND is_fake IS NULL   ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function subItemsAny(): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'   ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function subItemsActive(): array
    {
        if ($this->subitemsActive == null) {
            $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND deal_id=0  AND  deleted!=1 AND is_fake IS NULL  ");
            $sql->execute();
            $this->subitemsActive = $sql->fetchAll();
        }
        return $this->subitemsActive;
    }

    public function isActive(): bool
    {

        $sql = $this->pdo->prepare("SELECT COUNT(id) as num FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND (deal_id=0)  AND  deleted!=1 AND is_fake IS NULL  ");
        $sql->execute();
        $res = $sql->fetch();

        if ($res['num'] > 0) {
            return true;
        }
        return false;
    }

    public function subItemsPassive(): array
    {
        if ($this->subitemsActive == null) {
            $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND status=2  AND  deleted!=1   ");
            $sql->execute();
            $this->subitemsActive = $sql->fetchAll();
        }
        return $this->subitemsActive;
    }

    public function subItemsId(): array
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1 AND is_fake IS NULL  ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function subItemsIdFake(): array
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1 AND is_fake=1   ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }


    public function subItemsIdFloors(): array
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1 AND deal_id<=0  AND is_fake IS NULL ORDER BY publ_time    ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function subItemsIdFloorsOld(): array
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  (deleted=1 OR deal_id>0) AND is_fake IS NULL ORDER BY publ_time    ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function adOnRealtor() : int
    {
        $sql = $this->pdo->prepare("SELECT COUNT(*) as num FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND ad_realtor=1 AND  deleted!=1    ");
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        if ($item->num > 0) {
            return 1;
        }
        return 0;
    }

    public function subItemsSortByFloors(): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1 AND is_fake IS NULL  ORDER BY floor    ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item;
        }
        return $result;
    }

    public function offerBlocksAdCount(string $field)
    {
        $sql = $this->pdo->prepare("SELECT COUNT(id) as num FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1 AND $field=1    ");
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        return $item['num'];
    }

    public function subItemsCount(): int
    {
        return count($this->subItems());
    }

    public function subItemsActiveCount(): int
    {
        return count($this->subItemsActive());
    }

    public function getOfferObject(): int
    {
        return $this->getField('object_id');
    }

    public function getOfferNeighbors()
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_offers_mix WHERE  object_id=" . $this->getField('object_id') . " AND type_id IN(2,3) AND area_min > 0 AND id!=" . $this->getField(`id`) . "   ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function getOfferStatus()
    {
        foreach ($this->subItems() as $subItem) {
            if ($subItem['deal_id'] == 0) {
                return 1;
            }
        }
        return 2;
    }

    public function getOfferBlocksPriceForAllSum($field): int
    {
        $sum = 0;
        foreach ($this->subItemsActive() as $subItem) {
            $sum += $subItem[$field] * $subItem['area_max'];
        }
        return $sum;
    }

    public function getOfferBlocksPriceMinValue($field): int
    {
        $min_value = $this->getOfferBlocksPriceForAllSum($field);
        foreach ($this->subItemsActive() as $subItem) {
            if ($min_value > $subItem[$field] * $subItem['area_min'] && $subItem[$field] != 0) {
                $min_value = $subItem[$field] * $subItem['area_min'];
            }
        }
        return $min_value;
    }

    public function getOfferSumAreaMin()
    {
        $min_value = $this->getOfferSumAreaMax();
        foreach ($this->subItemsActive() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMin();
            if ($min_value && $area < $min_value && $area) {
                $min_value = $area;
            }
        }
        return $min_value;
    }

    public function getOfferSumAreaMax()
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMax();
            $max_value += $area;

        }
        return (int)$max_value;
    }


    public function getOfferSumAreaMinPassive()
    {
        $min_value = $this->getOfferSumAreaMaxPassive();
        foreach ($this->subItemsPassive() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMin();
            if ($min_value && $area < $min_value) {
                $min_value = $area;
            }
        }
        return $min_value;
    }

    public function getOfferSumAreaMaxPassive()
    {
        $max_value = 0;
        foreach ($this->subItemsPassive() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMax();
            $max_value += $area;
        }
        return (int)$max_value;
    }


    public function getOfferSumAreaMinAll()
    {
        $min_value = $this->getOfferSumAreaMaxAll();
        foreach ($this->subItems() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMin();
            if ($min_value && $area < $min_value) {
                $min_value = $area;
            }
        }
        return $min_value;
    }

    public function getOfferSumAreaMaxAll()
    {
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            $block = new Subitem($subItem['id']);
            $area = $block->getBlockSumAreaMax();
            $max_value += $area;
        }
        return (int)$max_value;
    }


    public function getOfferBlocksMaxValue($field)
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            if ($subItem[$field] > $max_value && $subItem[$field] != 0 && $subItem['deal_id'] <= 0) {
                $max_value = $subItem[$field];
            }
        }
        return (int)$max_value;
    }

    public function getOfferBlocksMaxValueAll($field)
    {
        $max_value = 0;
        foreach ($this->subItemsAny() as $subItem) {
            if ($subItem[$field] > $max_value && $subItem[$field] != 0) {
                $max_value = $subItem[$field];
            }
        }
        return (int)$max_value;
    }


    public function getOfferBlocksMaxSumValue($field)
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }

    /**
     * @return array
     * Получаем уникальные куски входящие в состав АКТИВНЫХ ТП
     */
    public function getOfferPartsUnique()
    {
        $parts_unique_active = [];
        $sql = $this->pdo->prepare("SELECT *  FROM c_industry_blocks WHERE offer_id=" . $this->id . " AND deleted!=1 AND deal_id=0  ");
        $sql->execute();
        while ($block = $sql->fetch(PDO::FETCH_LAZY)) {
            $blockParts = json_decode($block->parts);
            foreach ($blockParts as $part) {
                if (!in_array($part,$parts_unique_active)) {
                    $parts_unique_active[] = $part;
                }
            }
        }

        return $parts_unique_active;
    }

    public function getOfferPartsUniqueTaken()
    {
        $parts_unique_taken = [];
        $sql = $this->pdo->prepare("SELECT id  FROM c_industry_blocks WHERE offer_id=".$this->id."  AND deal_id>0 ");
        $sql->execute();
        while ($block = $sql->fetch(PDO::FETCH_LAZY)) {
            $parts_block = json_decode($block->parts);
            foreach($parts_block as $part) {
                if (!in_array($part,$parts_unique_taken)) {
                    $parts_unique_taken[] = $part;
                }
            }
        }
        return $parts_unique_taken;
    }

    public function getOfferBlocksRealAreaMin($field)
    {
        if (arrayIsNotEmpty($this->getOfferPartsUnique())) {
            $id_str = implode(',', $this->getOfferPartsUnique());
            $sql = $this->pdo->prepare("SELECT MIN($field) as min FROM c_industry_parts WHERE id IN($id_str)");
            $sql->execute();
            $res = $sql->fetch();
            return $res['min'];
        }
        return 0;

    }

    public function getOfferBlocksRealAreaSum($field)
    {
        if (arrayIsNotEmpty($this->getOfferPartsUnique())) {
            $id_str = implode(',', $this->getOfferPartsUnique());
            $sql = $this->pdo->prepare("SELECT SUM($field) as sum FROM c_industry_parts WHERE id IN($id_str) AND deleted!=1");
            $sql->execute();
            $res = $sql->fetch();
            return $res['sum'];
        }
        return 0;
    }

    public function getOfferBlocksMaxSumValueAll($field)
    {
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }

    public function getOfferBlocksMaxSumValueAllExcept(int $block_id, $field): int
    {
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            if ($block_id != $subItem['id']) {
                $max_value += $subItem[$field];
            }
        }
        return $max_value;
    }

    public function getOfferBlocksMinValue($field)
    {
        $min_value = $this->getOfferBlocksMaxValue($field);
        foreach ($this->subItemsActive() as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }


    public function getOfferBlocksMaxValuePassive($field)
    {
        $max_value = 0;
        foreach ($this->subItemsPassive() as $subItem) {
            if ($subItem[$field] > $max_value) {
                $max_value = $subItem[$field];
            }
        }
        return (int)$max_value;
    }


    public function getOfferBlocksMinValuePassive($field)
    {
        $min_value = $this->getOfferBlocksMaxValuePassive($field);
        foreach ($this->subItemsPassive() as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }


    public function getOfferBlocksMinValueAll($field)
    {
        $min_value = $this->getOfferBlocksMaxValueAll($field);
        foreach ($this->subItems() as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }

    public function getOfferLastUpdate()
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            if ($subItem['last_update'] > $max_value) {
                $max_value = $subItem['last_update'];
            }
        }
        $max_value =  $max_value ? $max_value :  $this->getField('last_update');
        return (int)$max_value;
    }

    public function lastUpdateActive()
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            if ($subItem['last_update'] > $max_value) {
                $max_value = $subItem['last_update'];
            }
        }
        return (int)$max_value;
    }

    public function lastUpdatePassive()
    {
        $max_value = 0;
        foreach ($this->subItemsPassive() as $subItem) {
            if ($subItem['last_update'] > $max_value) {
                $max_value = $subItem['last_update'];
            }
        }
        return (int)$max_value;
    }


    public function getOfferBlocksArrayValuesUnique($field)
    {
        $arr_unique = [];
        $sum_array = $this->getOfferBlocksArrayValues($field);
        foreach ($sum_array as $item) {
            if (!in_array($item, $arr_unique)) {
                $arr_unique[] = $item;
            }
        }

        return $arr_unique;
    }

    public function getOfferBlocksArrayValues($field)
    {
        $sum_array = [];
        foreach ($this->subItemsActive() as $subItem) {
            $field_data_arr = json_decode($subItem[$field]);
            if (arrayIsNotEmpty($field_data_arr)) {
                $sum_array = array_merge($sum_array, $field_data_arr);
            }
        }

        return $sum_array;
    }

    public function getOfferBlocksArrayValuesOdd($field)
    {
        $res_array = [];
        foreach ($this->subItemsActive() as $subItem) {
            $field_data_arr = json_decode($subItem[$field]);
            $length = count($field_data_arr);
            for ($i = 0; $i < $length; $i = $i + 2) {
                if ($field_data_arr[$i]) {
                    $res_array[] = $field_data_arr[$i];
                }
            }
        }
        return $res_array;
    }

    public function getOfferBlocksArrayValuesEven($field)
    {
        $res_array = [];
        foreach ($this->subItemsActive() as $subItem) {
            $field_data_arr = json_decode($subItem[$field]);
            $length = count($field_data_arr);
            for ($i = 1; $i < $length; $i = $i + 2) {
                if ($field_data_arr[$i]) {
                    $res_array[] = $field_data_arr[$i];
                }
            }
        }
        return $res_array;
    }

    public function getOfferBlocksArrayValuesOddMultiple(array $fields)
    {
        $res_array = [];
        foreach ($fields as $field) {
            foreach ($this->subItemsActive() as $subItem) {
                $field_data_arr = json_decode($subItem[$field]);
                $length = count($field_data_arr);
                for ($i = 0; $i < $length; $i = $i + 2) {
                    if ($field_data_arr[$i]) {
                        $res_array[] = $field_data_arr[$i];
                    }
                }
            }
        }
        return $res_array;
    }

    public function getOfferBlocksArrayValuesEvenMultiple(array $fields)
    {
        $res_array = [];
        foreach ($fields as $field) {
            foreach ($this->subItemsActive() as $subItem) {
                $field_data_arr = json_decode($subItem[$field]);
                $length = count($field_data_arr);
                for ($i = 1; $i < $length; $i = $i + 2) {
                    if ($field_data_arr[$i]) {
                        $res_array[] = $field_data_arr[$i];
                    }
                }
            }
        }
        return $res_array;
    }


    public function getOfferBlocksMaxValueMultiple(array $fields): int
    {
        $max_value = 0;
        foreach ($fields as $field) {
            foreach ($this->subItemsActive() as $subItem) {
                if ($subItem[$field] > $max_value) {
                    $max_value = $subItem[$field];
                }
            }
        }
        return $max_value;
    }

    public function getOfferBlocksMinValueMultiple(array $fields): int
    {
        $min_value = $this->getOfferBlocksMaxValueMultiple($fields);
        foreach ($fields as $field) {
            foreach ($this->subItemsActive() as $subItem) {
                if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                    $min_value = $subItem[$field];

                }
            }
        }
        return $min_value;
    }


    public function getOfferBlocksValues($field): array
    {
        $array_values = [];
        foreach ($this->subItemsActive() as $subItem) {
            $array_values[] = $subItem[$field];
        }
        return $array_values;
    }

    public function getOfferBlocksValuesUnique($field): array
    {
        $array_unique = [];
        foreach ($this->subItemsActive() as $subItem) {
            if (is_array($vars = json_decode($subItem[$field]))) {
                //$vars = json_decode($subItem[$field]);
                foreach ($vars as $item) {
                    if (!in_array($item, $array_unique) && $item != 0) {
                        $array_unique[] = $item;
                    }
                }
            } else {
                if (!in_array($subItem[$field], $array_unique) && $subItem[$field] != 0) {
                    $array_unique[] = $subItem[$field];
                }
            }
        }
        return $array_unique;
    }

    public function getOfferBlocksValuesUniqueAll($field): array
    {
        $array_unique = [];
        foreach ($this->subItemsAny() as $subItem) {
            if (is_array($vars = json_decode($subItem[$field]))) {
                //$vars = json_decode($subItem[$field]);
                foreach ($vars as $item) {
                    if (!in_array($item, $array_unique) && $item != 0) {
                        $array_unique[] = $item;
                    }
                }
            } else {
                if (!in_array($subItem[$field], $array_unique)) {
                    $array_unique[] = $subItem[$field];
                }
            }
        }
        return $array_unique;
    }

    public function hasBlocksAlive(): bool
    {
        $sql = $this->pdo->prepare("SELECT COUNT(*) as num FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND deleted!=1  AND is_fake IS NULL   ");
        $sql->execute();
        $info = $sql->fetch(PDO::FETCH_LAZY);
        if ($info['num'] > 0) {
            return true;
        }
        return false;
    }

    public function getOfferDealType()
    {
        $deal = new Post($this->getField('deal_type'));
        $deal->getTable('l_deal_types');
        return $deal->title();
    }


    public function getOfferFloors(): array
    {
        $floors_arr = array();
        foreach ($this->subItemsActive() as $subItem) {
            if (!in_array($subItem['floor'], $floors_arr)) {
                $floors_arr[] = $subItem['floor'];
            }
        }
        sort($floors_arr);
        return $floors_arr;
    }


    public function floorSubItems(int $floor): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted!='1' AND status=1 AND floor='$floor' AND offer_id=" . $this->postId());
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getOfferFloorBlocksMaxValue(int $floor, $field)
    {
        $max_value = 0;
        foreach ($this->floorSubItems($floor) as $subItem) {
            if ($max_value < $subItem[$field]) {
                $max_value = $subItem[$field];
            }
        }
        return $max_value;
    }

    public function getOfferFloorBlocksMinValue(int $floor, $field)
    {
        $min_value = $this->getOfferFloorBlocksMaxValue($floor, $field);
        foreach ($this->floorSubItems($floor) as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }

    public function getOfferFloorBlocksMaxSumValue(int $floor, $field)
    {
        $max_value = 0;
        foreach ($this->floorSubItems($floor) as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }


    public function showOfferCalcStat($value, $dimension, $placeholder)
    {
        if ($value) {
            return $value . ' ' . $dimension;
        } else {
            return $placeholder;
        }
    }


    public function agent()
    {
        $supervisor = new Member($this->getField('agent_id'));
        return $supervisor->name();
    }

    public function getOfferContact()
    {
        $client = new Client($this->getField('client_id'));
        return $client->getField('c_fio');
    }

    public function getOfferCompany()
    {
        return $this->getField('company_id');
    }

    public function getOfferCompanyName()
    {
        $company = new Company($this->getOfferCompany());
        return $company->title();
    }


    public function getOfferCommissionOwner()
    {
        return $this->getField('commission_owner');
    }

    public function getOfferCommissionClient()
    {
        return $this->getField('commission_client');
    }

    public function payCommissionThroughHolidays()
    {
        if ($this->getField('pay_through_holidays')) {
            return true;
        } else {
            return false;
        }
    }

    public function agentVisited()
    {
        return $this->getField('agent_visited');
    }

    public function clientId()
    {
        return $this->getField('client_id');
    }


    public function getOfferDescription()
    {

    }

    public function getOfferDescriptionAutomatic()
    {

    }


}
