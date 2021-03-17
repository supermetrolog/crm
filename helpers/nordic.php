<?php
function countCoders($number) {
    $divTen = $number % 10;
    $divHund = $number % 100;

    if ($divHund == 11 ) {
        $word = ' программистов';
	} elseif ($divTen > 1 && $divTen < 5) {
        $word = ' программиста';
    } elseif ($divTen == 1) {
        $word = ' программист';
	} else {
        $word = ' программистов';
	}

    return $number . $word;

}

echo countCoders(1) . '<br>';
echo countCoders(11) . '<br>';
echo countCoders(23) . '<br>';
echo countCoders(4) . '<br>';
echo countCoders(1711) . '<br>';
echo countCoders(5) . '<br>';
echo countCoders(111) . '<br>';
echo countCoders(1111) . '<br>';
echo countCoders(21) . '<br>';
echo countCoders(1121) . '<br>';
echo countCoders(0) . '<br>';