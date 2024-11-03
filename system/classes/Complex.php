<?php

class Complex extends Post
{


    public function setTable()
    {
        return 'c_industry_complex';
    }

    public function title()
    {
        return $this->getField('title');
    }


    public function photos()
    {
        return json_decode($this->getField('photo'));
    }

    public function getComplexOwnLawTypeLand()
    {
        if ($item = $this->getField('own_type_land')) {
            $item = new Post($item);
            $item->getTable('l_own_type_land');
            return $item->title();
        }
        return null;
    }

    public function getComplexCategoryLand()
    {
        if ($item = $this->getField('land_category')) {
            $item = new Post($item);
            $item->getTable('l_land_categories');
            return $item->title();
        }
        return null;
    }

    public function getComplexLandscapeLand()
    {
        if ($item = $this->getField('landscape_type')) {
            $item = new Post($item);
            $item->getTable('l_landscape');
            return $item->title();
        }
        return null;
    }

    public function waterType()
    {
        if ($item = $this->getField('water_type')) {
            $item = new Post($item);
            $item->getTable('l_waters');
            return $item->title();
        }
        return null;
    }

    public function internetType()
    {
        if ($item = $this->getField('internet_type')) {
            $item = new Post($item);
            $item->getTable('l_internet');
            return $item->title();
        }
        return 0;
    }

    public function heatingType()
    {
        if ($item = $this->getField('heating')) {
            $item = new Post($item);
            $item->getTable('l_heatings');
            return $item->title();
        }
        return 0;
    }

    public function guardType()
    {
        if ($item = $this->getField('guard')) {
            $item = new Post($item);
            $item->getTable('l_guards_industry');
            return $item->title();
        }
        return 0;
    }

    public function entranceType()
    {
        if ($item = $this->getField('entry_territory')) {
            $item = new Post($item);
            $item->getTable('l_entry_territory');
            return $item->title();
        }
        return false;
    }

}

