<?php

class Floor extends Post
{

    public function setTable()
    {
        return 'c_industry_floors';
    }

    public function getFloorOfferBlocksSumArea($offer_id)
    {
        $sql = $this->pdo->prepare("SELECT area_floor_max,area_mezzanine_max FROM c_industry_parts WHERE floor_id=" . $this->id . "   AND offer_id=" . $offer_id . " AND deleted!=1 ");
        $sql->execute();
        $area_sum = 0;
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            if ($item->area_floor_max) {
                $area_sum += $item->area_floor_max;
            } else {
                $area_sum += $item->area_mezzanine_max;
            }
        }
        return $area_sum;
    }

    public function getFloorOfferBlocksCount($offer_id)
    {
        $sql = $this->pdo->prepare("SELECT COUNT(*) as num FROM c_industry_parts WHERE floor_id=" . $this->id . "   AND offer_id=" . $offer_id . " AND deleted!=1 ");
        $sql->execute();
        $area_sum = 0;
        $item = $sql->fetch(PDO::FETCH_LAZY);

        return $item['num'];
    }

    public function getFloorFieldByObjectId($object_id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_floors WHERE object_id=$object_id  AND  deleted!=1 LIMIT 1");
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        if ($id = $item->id) {
            $this->id = $id;
            return $id;
        } else {
            return 0;
        }
    }


    public function findFloorByTypeId(int $object_id, int $floor_num_id)
    {
        $sql = $this->pdo->prepare("SELECT id FROM c_industry_floors WHERE object_id=$object_id  AND floor_num_id=" . $floor_num_id);
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        if ($this->id = $item->id) {
            return true;
        }
        return false;
    }

    public function getFloorOfferFreeSpace($field, int $offer_id)
    {
        $field_max = $field . '_max';
        $sql = $this->pdo->prepare("SELECT SUM($field_max) as occupied FROM c_industry_parts WHERE floor_id=" . $this->id . "  AND  offer_id=" . $offer_id . " AND deleted!=1 ");
        //echo "SELECT SUM($field_max) as occupied FROM c_industry_floors WHERE floor_id=".$this->id."  AND offer_id=".$offer_id;
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        $free = $this->getField($field . '_full') - $item->occupied;
        return $free;
    }

    public function getComplexId()
    {
        $sql = $this->pdo->prepare("SELECT c.id as cid FROM " . $this->setTable() . " f LEFT JOIN c_industry i ON f.object_id= i.id LEFT JOIN c_industry_complex c ON i.complex_id=c.id WHERE f.id=" . $this->id);
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);

        return $item['cid'];
    }


}