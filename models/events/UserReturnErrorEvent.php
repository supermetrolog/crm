<?php

namespace app\models\events;
use yii\base\Event;

class UserReturnErrorEvent  extends Event
{
    public $model;
}
