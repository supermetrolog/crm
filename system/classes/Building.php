<?php

class Building extends Post
{


    public function setTable()
    {
        return 'c_industry';
    }

    public function title()
    {
        return $this->getField('title');
    }

    public function itemId()
    {
        return $this->getField('id');
    }

    public function photos()
    {
        return json_decode($this->getField('photo'));
    }

    public function classType()
    {
        if ($this->getField('object_class')) {
            $object_class = new Post($this->getField('object_class'));
            $object_class->getTable('l_classes');
            return $object_class->title();
        }
    }

    public function getCranes(): array
    {
        $cranes = [];
        $sql = $this->pdo->prepare("SELECT id FROM " . (new Crane())->setTable() . " WHERE object_id=" . $this->id);
        $sql->execute();
        while ($crane = $sql->fetch(PDO::FETCH_LAZY)) {
            $cranes[] = $crane->id;
        }
        return $cranes;
    }

    public function hasCranes(): int
    {
        $sql = $this->pdo->prepare("SELECT COUNT(id) as num FROM l_cranes WHERE object_id=" . $this->id);
        $sql->execute();
        $crane = $sql->fetch(PDO::FETCH_LAZY);
        if ($crane['num'] > 0) {
            return 1;
        }
        return 0;
    }

    public function getBlocksLastUpdate(): int
    {
        if ($this->id) {
            $sql = $this->pdo->prepare("SELECT MAX(last_update) as max FROM c_industry_blocks WHERE object_id=" . $this->id);
            echo "SELECT MAX(last_update) as max FROM c_industry_blocks WHERE object_id=" . $this->id;
            $sql->execute();
            $info = $sql->fetch(PDO::FETCH_LAZY);
            echo 111111;
            return (int)$info->max;
        }
        return time();
    }

    public function getBlocksHeating(): bool
    {

        $sql = $this->pdo->prepare("SELECT heated FROM c_industry_blocks WHERE object_id=" . $this->id);
        $sql->execute();
        while ($info = $sql->fetch(PDO::FETCH_LAZY)) {
            if ($info->heated == 1) {
                return true;
            }
        }
        return false;

    }

    public function getOffersLastUpdate(): int
    {
        if ($this->id) {
            $sql = $this->pdo->prepare("SELECT MAX(last_update) AS max FROM c_industry_offers WHERE object_id=" . $this->id);
            $sql->execute();
            $info = $sql->fetch(PDO::FETCH_LAZY);
            return (int)$info->max;
        }
        return time();
    }

    public function getElevators(): array
    {
        $elevators = [];
        $sql = "SELECT id FROM " . (new Elevator())->setTable() . " WHERE object_id=" . $this->id;
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        while ($elevator = $sql->fetch(PDO::FETCH_LAZY)) {
            $elevators[] = $elevator->id;
        }
        return $elevators;
    }

    public function findBuildingByAddress($address)
    {
        $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE address=:address LIMIT 1");
        $sql->bindParam(':address', $address);
        $sql->execute();
        $building = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $building->id;
        return $this->id;
    }

    public function getFloors()
    {
        $result = [];
        $sql = $this->pdo->prepare("SELECT id FROM c_industry_floors WHERE deleted !='1'  AND object_id=" . $this->itemId());
        $sql->execute();
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }

        return $result;
    }

    public function getFloorsAreaSum()
    {
        $sql = $this->pdo->prepare("SELECT id,area_floor_full,area_mezzanine_full,area_field_full,area_office_full,area_tech_full  FROM c_industry_floors WHERE  object_id=" . $this->itemId() . " AND deleted !='1'");
        $sql->execute();
        $sum = 0;
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $floor_obj = new Floor($item->id);
            if (in_array($floor_obj->getField('floor_num_id'), [2, 3, 4, 5])) {
                $sum += $item->area_mezzanine_full;
            } elseif (in_array($floor_obj->getField('floor_num_id'), [16])) {
                $sum += $item->area_field_full;
            } else {
                $sum += $item->area_floor_full;
            }
            $sum += $item->area_office_full;
            $sum += $item->area_tech_full;
        }

        return $sum;
    }

    public function getObjectFloorsInfo()
    {
        $result = [];
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_floors WHERE deleted !='1'  AND object_id=" . $this->itemId());
        $sql->execute();
        return $sql->fetchAll();
    }

    public function getObjectFloorsMinValue($field): int
    {
        $min_value = $this->getObjectFloorsMaxValue($field);
        foreach ($this->getObjectFloorsInfo() as $subItem) {
            if ($subItem[$field] && $min_value > $subItem[$field]) {
                $min_value = $subItem[$field];
            }
        }
        return (int)$min_value;
    }

    public function getObjectFloorsMaxValue($field): int
    {
        $max_value = 0;
        foreach ($this->getObjectFloorsInfo() as $subItem) {
            if ($subItem[$field] > $max_value) {
                $max_value = $subItem[$field];
            }
        }
        return (int)$max_value;
    }

    public function getObjectFloorsArrayValuesUnique($field)
    {
        $sum_array = [];
        foreach ($this->getObjectFloorsInfo() as $subItem) {
            $field_data_arr = json_decode($subItem[$field]);
            if (arrayIsNotEmpty($field_data_arr)) {
                $sum_array = array_merge($sum_array, $field_data_arr);
            }
        }

        $arr_unique = [];
        foreach ($sum_array as $item) {
            if (!in_array($item, $arr_unique)) {
                $arr_unique[] = $item;
            }
        }

        return $arr_unique;
    }

    public function getObjectFloorsArrayValuesEven($field)
    {
        $res_array = [];
        foreach ($this->getObjectFloorsInfo() as $subItem) {
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

    public function getObjectFloorsArrayValuesEvenMultiple(array $fields)
    {
        $res_array = [];
        foreach ($fields as $field) {
            foreach ($this->getObjectFloorsInfo() as $subItem) {
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

    public function getFloorsNums()
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_floors WHERE deleted !='1'  AND object_id=" . $this->itemId());
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->floor_num_id;
        }
        return $result;
    }

    public function getFloorsTitle()
    {
        $floors_real = [];
        foreach ($this->getFloorsNums() as $floor) {
            if ($floor) {
                $floors_real[] = $floor;
            }
        }
        $floors_nums_id = implode(',', $floors_real);

        if ($floors_nums_id) {
            $sql = $this->pdo->prepare("SELECT * FROM l_floor_nums WHERE id IN($floors_nums_id) ORDER BY order_row DESC ");
            $sql->execute();
            $result = [];
            while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
                $result[] = $item->title;
            }
            return $result;
        }
        return [];

    }

    public function getObjectTypeId()
    {
        return $this->getJsonField('object_type');
    }

    public function getObjectPreview()
    {
        return $this->getJsonField('photo')[0];
    }

    public function getObjectType()
    {
        $object_type = new Post($this->getJsonField('object_type'));
        $object_type->getTable('l_object_types');
        return $object_type->title();
    }


    public function showObjectStat($field, $dimension, $placeholder)
    {
        if ($this->getField($field)) {
            return $this->getField($field) . ' ' . $dimension;
        } else {
            return $placeholder;
        }
    }

    public function region()
    {
        $region = new Post($this->getField('region'));
        $region->getTable('regions');
        return $region->title();
    }

    public function getObjectOwnLawType()
    {
        if ($this->getField('own_type')) {
            $law_type = new Post($this->getField('own_type'));
            $law_type->getTable('l_own_type');
            return $law_type->title();
        }
        return 0;
    }

    public function getObjectOwnLawTypeLand()
    {
        if ($this->getField('own_type_land')) {
            $law_type = new Post($this->getField('own_type_land'));
            $law_type->getTable('l_own_type_land');
            return $law_type->title();
        }
        return 0;
    }

    public function getObjectCategoryLand()
    {
        if ($this->getField('land_category')) {
            $law_type = new Post($this->getField('land_category'));
            $law_type->getTable('l_land_categories');
            return $law_type->title();
        }
        return 0;
    }

    public function parkingCarType()
    {
        $parking_type = new Post($this->getField('parking_car_type'));
        $parking_type->getTable('l_parkings_type');
        return $parking_type->title();
    }


    public function direction()
    {
        $direction = new Post($this->getField('direction'));
        $direction->getTable('directions');
        return $direction->title();
    }

    public function metroYandex()
    {

        $metro = new Post($this->getField('metro'));
        $metro->getTable('metros');
        return $metro->getField('yandex_id');
    }

    public function metro()
    {
        $metro = new Post($this->getField('metro'));
        $metro->getTable('metros');
        return $metro->title();
    }

    public function village()
    {
        $village = new Post($this->getField('village'));
        $village->getTable('villages');
        return $village->title();
    }

    public function highway()
    {
        $highway = new Post($this->getField('highway'));
        $highway->getTable('highways');
        return $highway->title();
    }

    public function railwayStation()
    {
        $railwayStation = new Post($this->getField('railway_station'));
        $railwayStation->getTable('c_railway_station');
        return $railwayStation->title();
    }

    public function fromMkad()
    {
        if ($this->getField('from_mkad')) {
            return $this->getField('from_mkad');
        } else {
            return false;
        }

    }

    public function clientId()
    {
        return $this->getField('clyent_id');
    }

    public function ownerPerson()
    {
        $owner = new Post($this->getField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return $owner->title();
    }

    public function ownerPersonPosition()
    {
        $owner = new Member($this->getField('clyent_id'));
        return $owner->group_name();
    }

    public function ownerPhone()
    {
        $owner = new Post($this->getField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return $owner->getField('c_phone');
    }

    public function ownerCompany()
    {
        $owner = new Post($this->getField('clyent_id'));
        $owner->getTable('c_industry_customers');
        return $owner->getField('c_company');
    }

    public function ventilationType()
    {
        $ventilation = new Post($this->getField('ventilation'));
        $ventilation->getTable('l_ventilations');
        return $ventilation->title();
    }

    public function internetType()
    {
        $internet = new Post($this->getField('internet_type'));
        $internet->getTable('l_internet');
        return $internet->title();
    }

    public function telType()
    {
        $tel = new Post($this->getField('telephony'));
        $tel->getTable('l_telecommunications_retail');
        return $tel->title();
    }

    public function waterType()
    {
        $water = new Post($this->getField('water'));
        $water->getTable('l_waters');
        return $water->title();
    }

    public function heatType()
    {
        $heating = new Post($this->getField('heating'));
        $heating->getTable('l_heatings');
        return $heating->title();
    }

    public function firefightingType()
    {
        if ($this->getField('firefighting_type')) {
            $firefighting = new Post($this->getField('firefighting_type'));
            $firefighting->getTable('l_firefighting');
            return $firefighting->title();
        } else {
            return 0;
        }

    }

    public function entranceType()
    {
        if ($this->getField('entry_territory')) {
            $entry = new Post($this->getField('entry_territory'));
            $entry->getTable('l_entry_territory');
            return $entry->title();
        }
        return false;
    }

    public function facingType()
    {
        $facing = new Post($this->getField('facing_type'));
        $facing->getTable('l_facing_types');
        return $facing->title();
    }

    public function guardType()
    {
        $guard = new Post($this->getField('guard'));
        $guard->getTable('l_guards_industry');
        return $guard->title();
    }

    public function sewageType()
    {
        $sewage = new Post($this->getField('sewage'));
        $sewage->getTable('l_sewages');
        return $sewage->title();
    }

    public function author()
    {
        return $this->getField('author');
    }


    public function purposes()
    {
        return json_decode($this->getField('purposes'));
    }

    public function dealTypes()
    {
        return json_decode($this->getField('deal_type'));
    }

    public function status()
    {
        $status = new Post($this->getField('item_status'));
        $status->getTable('items_status');
        return $status->title();
    }

    public function subItemsId()
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_blocks WHERE deleted !='1'  AND object_id=" . $this->itemId());
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function getObjectOffersId()
    {
        $sql = $this->pdo->prepare("SELECT (id) FROM c_industry_offers WHERE deleted !='1' AND  object_id='" . $this->itemId() . "' ");
        $sql->execute();
        $result = [];
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $result[] = $item->id;
        }
        return $result;
    }

    public function subItems()
    {
        $offer_ids = $this->getObjectOffersId();
        $offer_line = implode(',', $offer_ids);
        if ($offer_line == '') {
            $offer_line = 0;
        }
        //echo $offer_line;
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted !='1' AND is_fake IS NULL AND offer_id IN($offer_line) ");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function subItemsDealType(int $deal_type)
    {
        $offer_ids = $this->getObjectOffersId();
        $offer_deal_ids = [];
        foreach ($offer_ids as $offer_id) {
            $offer_obj = new Offer($offer_id);
            if ($offer_obj->getField('deal_type') == $deal_type) {
                $offer_deal_ids[] = $offer_id;
            }
        }
        $offer_line = implode(',', $offer_deal_ids);
        //echo $offer_line;
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted !='1' AND is_fake IS NULL AND offer_id IN($offer_line) ");
        $sql->execute();
        return $sql->fetchAll();
    }


    public function getObjectOffers()
    {
        $sql = $this->pdo->prepare("SELECT * FROM c_industry_offers WHERE deleted !='1' AND  object_id='" . $this->itemId() . "' ");
        $sql->execute();
        return $sql->fetchAll();
    }


    public function getObjectBlocksMaxValue($field): int
    {
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {
            if ($subItem[$field] > $max_value) {
                $max_value = $subItem[$field];
            }

        }
        return $max_value;
    }

    public function getObjectBlocksMaxSumValue($field): int
    {
        $max_value = 0;
        foreach ($this->subItems() as $subItem) {

            $max_value += $subItem[$field];
        }
        return $max_value;
    }

    public function getObjectBlocksMaxSumValueExcept(int $block_id, $field): int
    {
        $max_value = 0;
        $subItem = new Subitem($block_id);
        $offer = new Offer($subItem->getField('offer_id'));
        foreach ($this->subItemsDealType($offer->getField('deal_type')) as $subItem) {
            if ($block_id != $subItem['id']) {
                $max_value += $subItem[$field];
            }
        }
        return $max_value;
    }

    public function getObjectBlocksMinValue($field): int
    {
        $min_value = $this->getObjectBlocksMaxValue($field);
        foreach ($this->subItems() as $subItem) {
            if ($min_value > $subItem[$field] && $subItem[$field] != 0) {
                $min_value = $subItem[$field];
            }
        }
        return $min_value;
    }

    public function getObjectBlocksValues($field): array
    {
        $array_values = [];
        foreach ($this->subItems() as $subItem) {
            $array_values[] = $subItem[$field];
        }
        return $array_values;
    }

    public function getObjectBlocksValuesUnique($field): array
    {
        $array_unique = [];
        foreach ($this->subItems() as $subItem) {
            if (!in_array($subItem[$field], $array_unique) && $subItem[$field] != 0) {
                $array_unique[] = $subItem[$field];
            }
        }
        return $array_unique;
    }

    public function getObjectMinArea()
    {
        $min_area = 99999999999999999;
        foreach ($this->subItems() as $subItem) {
            if ($min_area > $subItem['area']) {
                $min_area = $subItem['area'];
            }
            return $min_area;
        }
    }


    //ТУТ НУЖНО БРАТЬ ПОТОМ НОРМАЛЬНУЮ ЦЕНУ А НЕ ТУ ИЛИ ТУ
    public function getObjectMinPrice()
    {
        $min_price = 99999999999999999;
        foreach ($this->subItems() as $subItem) {
            if ($min_price > $subItem['rent_price']) {
                $min_price = $subItem['rent_price'];
            }
            return $min_price;
        }
    }

    public function hasSubItems()
    {
        if ($this->subItems() != null) {
            return true;
        } else {
            return false;
        }
    }

    public function photo()
    {
        return $this->photos()[0];
    }

    public function photoCount()
    {
        return count($this->photos());
    }

    public function thumbs()
    {
        return json_decode($this->getField('thumbs'));
    }

    public function publTime()
    {
        return date('d-m-Y', $this->getField('publ_time'));
    }

    public function lastUpdate()
    {
        return date('d-m-Y в H:i', $this->getField('last_update'));
    }

    public function timeFormat(int $time)
    {
        return date_format_rus($time);
    }


    public function thumb()
    {
        //return $this->thumbs()[0];
        return 'http://www.sklad-man.ru/uploads/images/sklad666.jpg';
    }

    public function agentVisit()
    {
        return $this->getField('agent_visited');
    }

    public function description()
    {
        return $this->getField('description');
    }


    public function metaTitle()
    {
        if ($this->getField('content_title')) {
            return $this->getField('content_title');
        } else {
            return $this->getField('title');
        }
    }

    public function metaKeywords()
    {
        if ($this->getField('content_keywords')) {
            return $this->getField('content_keywords');
        } else {
            return $this->getField('title');
        }
    }

    public function metaDescription()
    {
        if ($this->getField('content_description')) {
            return $this->getField('content_description');
        } else {
            return $this->getField('title');
        }
    }

    public function metaIcon()
    {
        return unserialize($this->getField('photo'))[0];
    }


    public function price()
    {
        return $this->getField('price');
    }

    public function articul()
    {
        return $this->getField('articul');
    }

    public function pack()
    {
        return $this->getField('pack');
    }

    public function sale()
    {
        return $this->getField('sale');
    }

    public function discount()
    {
        return $this->getField('discount');
    }

    public function size()
    {
        return $this->getField('size');
    }

    public function color()
    {
        return $this->getField('color');
    }


}

