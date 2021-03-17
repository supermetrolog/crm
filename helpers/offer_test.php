<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 09.10.2020
 * Time: 14:43
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$offer = new Offer(3013);

var_dump($offer->hasBlocksAlive());