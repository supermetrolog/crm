<?php
/**
 * Created by PhpStorm.
 * User: timondecathlon
 * Date: 24.08.20
 * Time: 20:10
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$offer = new Offer(2503);

var_dump($offer->getOfferPartsUnique());