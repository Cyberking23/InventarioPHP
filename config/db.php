<?php

$host = getenv('mysql.railway.internal');
$user = getenv('root');
$pass = getenv('CyHwCLiyidUKfilOjTwZJrtsguXAqVGg');
$dbname = getenv('railway');

$conn = new mysqli($host, $user, $pass, $dbname);


?>