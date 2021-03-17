<?php

function classLoader1($class) {
    require_once( $_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/'.str_replace('\\','/',$class.'.php'));
}
spl_autoload_register('classLoader1');


