<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 20.06.2018
 * Time: 11:11
 */
class Filter extends Post
{

    public function setTable()
    {
        return 'core_filters';
    }

    public function variantsTable()
    {
        return $this->showField('linked_table');
    }

    public function getFilterVariants()
    {
        $filter_vars = new Post(0);
        $filter_vars->getTable($this->variantsTable());
        return $filter_vars->getAllUnits();
    }

    public function filterName()
    {
        return $this->showField('filter_name');
    }

    public function filterDimension()
    {
        return $this->showField('dimension');
    }

    public function showTitle()
    {
        if ($this->showField('show_title')) {
            return true;
        } else {
            return false;
        }
    }

    public function titleFilled()
    {
        return $this->showField('filter_title_filled');
    }

    public function filterGroupTemplate()
    {
        $filter_group = new FilterGroup($this->showField('filter_group'));
        return $filter_group->showField('filter_name');
    }

    public function filterVariantsTable()
    {
        return $this->showField('filter_table');
    }


}