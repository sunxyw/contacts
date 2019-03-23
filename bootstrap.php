<?php

$database = [
    'host' => '127.0.0.1',
    'port' => 3306,
    'db' => 'contacts',
    'user' => 'root',
    'password' => null,
];

$conn = new mysqli($database['host'], $database['user'], $database['password'], $database['db'], $database['port']);

if ($conn->connect_error) {
    exit('数据库连接失败：' . $conn->connect_error);
}


if (!function_exists('is_post')) {
    function is_post()
    {
        return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }
}