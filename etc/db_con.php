<?php
$filename = "dbconf.ini";
$config = parse_ini_file($filename);   

$mysqli = new mysqli('localhost', $config['username'], $config['password'], $config['dbname']);
