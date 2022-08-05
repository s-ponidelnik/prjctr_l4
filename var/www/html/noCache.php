<?php
include 'Cache.php';
$cache = new Cache('noCache');
print $cache->getByIndex($_GET['k']);