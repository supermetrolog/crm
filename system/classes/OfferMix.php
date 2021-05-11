<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.08.2018
 * Time: 15:44
 */
?>
<?

class OfferMix extends Post
{

    public $id;

    public function setTable()
    {
        return 'c_industry_offers_mix';
    }


    public function offerId(): int
    {
        return $this->getField('id');
    }

    public function getRealId(int $original_id, int $type_id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE original_id=$original_id AND type_id=$type_id LIMIT 1 ");
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $result->id;

    }

    public function subItems(): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND deleted!=1   ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function subItemsActive(): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "' AND status='1'  AND  deleted!=1   ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function subItemsId(): array
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE offer_id='" . $this->postId() . "'  AND  deleted!=1   ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function subItemsCount(): int
    {
        return count($this->subItems());
    }

    public function getOfferObject(): int
    {
        return $this->getField('object_id');
    }

    public function getOfferNeighbors()
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_offers_mix WHERE  object_id=" . $this->getField('object_id') . " AND type_id IN(2,3)  AND area_min > 0  AND id!=" . $this->id . "    ");
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
            if ($subItem['status'] == 1) {
                return 1;
            }
        }
        return 2;
    }


    public function getOfferBlocksMaxValue($field): int
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            if ($subItem[$field] > $max_value) {
                $max_value = $subItem[$field];
            }
        }
        return $max_value;
    }

    public function getOfferBlocksMaxSumValue($field): int
    {
        $max_value = 0;
        foreach ($this->subItemsActive() as $subItem) {
            $max_value += $subItem[$field];
        }
        return $max_value;
    }

    public function getOfferBlocksMinValue($field): int
    {
        $min_value = $this->getOfferBlocksMaxValue($field);
        foreach ($this->subItemsActive() as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
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
        foreach ($this->subItems() as $subItem) {
            $array_values[] = $subItem[$field];
        }
        return $array_values;
    }

    public function getOfferBlocksValuesUnique($field): array
    {
        $array_unique = [];
        foreach ($this->subItems() as $subItem) {
            if (!in_array($subItem[$field], $array_unique) && $subItem[$field] != 0) {
                $array_unique [] = $subItem[$field];
            }
        }
        return $array_unique;
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
        foreach ($this->subItems() as $subItem) {
            if (!in_array($subItem['floor'], $floors_arr)) {
                $floors_arr[] = $subItem['floor'];
            }
        }
        sort($floors_arr);
        return $floors_arr;
    }


    public function floorSubItems(int $floor): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted!='1' AND floor='$floor' AND offer_id=" . $this->postId());
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

    public function dealType()
    {
        $dealType = new Post($this->getField('deal_type'));
        $dealType->getTable('l_deal_types');
        return $dealType->title();
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
