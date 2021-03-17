<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 29.09.2018
 * Time: 10:17
 */
namespace Bitkit\Core\Cron;
class Plan extends \Post
{
    public function setTable()
    {
        return 'core_plans';
    }

}