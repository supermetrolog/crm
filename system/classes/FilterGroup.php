<?php

class FilterGroup extends Post
{

    public function setTable()
    {
        return 'core_filter_groups';
    }

    public function filterGroupName()
    {
        return $this->showField('title');
    }

    public function filterGroupId()
    {
        return $this->showField('id');
    }

    public function filterGroupTemplateName()
    {
        return $this->showField('filter_name');
    }


}