<?php

class Elevator extends Post
{

    public function setTable()
    {
        return 'l_elevators';
    }

    public function getElevatorType()
    {
        if ($id = $this->getField('elevator_type')) {
            $item = new Post($id);
            $item->getTable('l_elevators_types');
            return $item->title();
        }
        return false;
    }


    public function getElevatorCapacity()
    {
        return $this->getField('elevator_capacity');
    }

    public function getElevatorLocation()
    {
        if ($id = $this->getField('elevator_location')) {
            $item = new Post($id);
            $item->getTable('l_cranes_locations');
            return $item->title();
        }
        return false;
    }


    public function getElevatorVolume()
    {
        return $this->getField('elevator_volume');
    }

    public function getCraneControls()
    {

    }

    public function getElevatorCondition()
    {
        if ($id = $this->getField('elevator_condition')) {
            $item = new Post($id);
            $item->getTable('l_cranes_conditions');
            return $item->title();
        }
        return false;
    }


}