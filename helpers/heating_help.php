<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = $pdo->prepare("UPDATE c_industry_complex SET heating_central=1 WHERE heating=2");
$sql->execute();

$sql = $pdo->prepare("UPDATE c_industry_complex SET heating_autonomous=1 WHERE heating=1");
$sql->execute();

