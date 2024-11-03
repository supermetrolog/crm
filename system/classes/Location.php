<?php

class Location extends Post
{

    public function setTable()
    {
        return 'l_locations';
    }

    public function getLocationRegion()
    {
        if ($this->getField('region')) {
            $item = new Post($this->getField('region'));
            $item->getTable('l_regions');
            return $item->title();
        } else {
            return 0;
        }
    }

    public function getLocationTown()
    {
        if ($this->getField('town')) {
            $item = new Post($this->getField('town'));
            $item->getTable('l_towns');
            return $item->title();
        }
        return 0;

    }

    public function getLocationTownType()
    {

        if ($this->getField('town_type')) {
            $item = new Post($this->getField('town_type'));
            $item->getTable('l_towns_types');
            return $item->title();
        }
        return 0;
    }

    public function getLocationDistrictType()
    {
        if ($this->getField('district_type')) {
            $item = new Post($this->getField('district_type'));
            $item->getTable('l_districts_types');
            return $item->title();
        }

    }


    public function getLocationHighway1()
    {
        if ($this->getField('region') == '6' && $this->getField('highway_moscow')) {
            $highways_table = 'l_highways_moscow';
            $field = 'highway_moscow';
        } elseif ($this->getField('region') == '1' && $this->getField('highway')) {
            $highways_table = 'l_highways';
            $field = 'highway';
        } else {

        }
        if ($field) {
            $item = new Post($this->getField($field));
            $item->getTable($highways_table);
            return $item->title();
        } else {
            return 0;
        }

    }

    public function getLocationHighway()
    {
        if ($this->getField('highway_moscow')) {
            $highways_table = 'l_highways_moscow';
            $field = 'highway_moscow';
        }
        if ($field) {
            $item = new Post($this->getField($field));
            $item->getTable($highways_table);
            return $item->title();
        } else {
            return 0;
        }

    }

    public function getLocationHighwayMoscow()
    {
        if ($this->getField('highway')) {
            $highways_table = 'l_highways';
            $field = 'highway';
        }
        if ($field) {
            $item = new Post($this->getField($field));
            $item->getTable($highways_table);
            return $item->title();
        } else {
            return 0;
        }

    }

    public function getLocationDistrict()
    {
        if ($this->getField('district_moscow')) {
            $highways_table = 'l_districts_moscow';
            $field = 'district_moscow';
            $item = new Post($this->getField($field));
            $item->getTable($highways_table);
            return $item->title();
        } elseif ($this->getField('district')) {
            $highways_table = 'l_districts';
            $field = 'district';
            $item = new Post($this->getField($field));
            $item->getTable($highways_table);
            return $item->title();
        } else {
            return 0;
        }

    }

    public function getLocationDirection()
    {
        if ($this->getField('direction')) {
            $item = new Post($this->getField('direction'));
            $item->getTable('l_directions');
            return $item->title();
        } else {
            return 0;
        }

    }


    public function getLocationMetro()
    {
        if ($this->getField('metro')) {
            $item = new Post($this->getField('metro'));
            $item->getTable('l_metros');
            return $item->title();
        }
        return 0;

    }


}