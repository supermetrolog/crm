<?php

class Crane extends Post
{

    public function setTable()
    {
        return 'l_cranes';
    }


    public function getCraneType()
    {
        if ($id = $this->getField('crane_type')) {
            $item = new Post($id);
            $item->getTable('l_cranes_types');
            return $item->title();
        }
        return false;
    }


    public function getCraneCapacity()
    {
        return $this->getField('crane_capacity');
    }

    public function getCraneLocation()
    {
        if ($id = $this->getField('crane_location')) {
            $item = new Post($id);
            $item->getTable('l_cranes_locations');
            return $item->title();
        }
        return false;
    }

    public function getCraneSpan()
    {
        return $this->getField('crane_span');
    }

    public function getCraneHookHeight()
    {
        return $this->getField('crane_hook_height');
    }

    public function getCraneControls()
    {

    }

    public function getCraneCondition()
    {
        if ($id = $this->getField('crane_condition')) {
            $item = new Post($id);
            $item->getTable('l_cranes_conditions');
            return $item->title();
        }
        return false;
    }
}