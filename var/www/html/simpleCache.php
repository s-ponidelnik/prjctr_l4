<?php
include_once 'Cache.php';
$cache = new Cache('simpleCache');
print $cache->simpleCache($_GET['k']);