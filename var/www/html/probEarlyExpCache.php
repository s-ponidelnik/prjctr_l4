<?php
include_once 'Cache.php';
$cache = new Cache('probEarlyExpCache');
print $cache->probEarlyExpCache($_GET['k']);