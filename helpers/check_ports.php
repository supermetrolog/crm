<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 17.12.2018
 * Time: 14:33
 */
$host = '176.99.3.73';
$ports = array(1985, 1986, 80, 1500, 8080, 3030, 53, 22, 143, 2346);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port);

    if (is_resource($connection))
    {
        echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

        fclose($connection);
    }

    else
    {
        echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}