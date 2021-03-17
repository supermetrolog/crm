<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.06.2018
 * Time: 11:58
 */
class Marker extends Unit
{

    public function setTable()
    {
        return 'core_markers';
    }

    public function markerLatitude()
    {
        return $this->showField('latitude');
    }

    public function markerLongitude()
    {
        return $this->showField('longitude');
    }


}