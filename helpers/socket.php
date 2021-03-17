<?
if(extension_loaded('sockets')) echo "WebSockets OK";
else echo "WebSockets UNAVAILABLE";
?>


<?php
echo dirname(__FILE__);
//require_once ($_SERVER['DOCUMENT_ROOT'].'/system/classes/Workerman/Autoloader.php');
//для запуска из консоли
$path  = dirname(__FILE__);
require_once ($path.'/system/classes/Workerman/Autoloader.php');
//require_once ($path.'/system/classes/Workerman/Worker.php');


// Create a Websocket server
$ws_worker = new Worker("websocket://0.0.0.0:8000");

// 4 processes
$ws_worker->count = 4;

// Emitted when new connection come
$ws_worker->onConnect = function($connection)
{
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data)
{
    // Send hello $data
    $connection->send('hello ' . $data);
};

// Emitted when connection closed
$ws_worker->onClose = function($connection)
{
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();
