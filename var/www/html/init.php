<?php

$dbh = new PDO('mysql:host=prjctr_l4_mysql;dbname=prjctr_l4', 'root', 'root');
$dbh->exec("CREATE TABLE IF NOT EXISTS prjctr (id INT AUTO_INCREMENT PRIMARY KEY, k VARCHAR(255) UNIQUE NOT NULL, v VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)  ENGINE=INNODB;");
$count = $dbh->query('SELECT count(*) FROM prjctr')->fetchColumn(0);
$max = 1000000;
while ($count < $max) {
    $time = str_replace(['.',' '],'',microtime());
    try {
        $insert = $dbh->prepare("INSERT INTO prjctr (k, v) VALUES ('" . 'k_' . $time . "','" . 'v_' . $time . "');");
        $insert->execute();
        $count++;
    }catch (Throwable $throwable){
        $count = $dbh->query('SELECT count(*) FROM prjctr')->fetchColumn(0);
    }
    print (($count/$max)*100)."%\n";
}
$data= $dbh->query('SELECT k FROM prjctr ORDER BY RAND() LIMIT 100')->fetchAll();
$simple=[];
$nocache=[];
$prop=[];
foreach ($data as $v){
    $nocache[]='http://localhost/noCache.php?k='.$v['k'];
    $simple[]='http://localhost/simpleCache.php?k='.$v['k'];
    $prop[]='http://localhost/probEarlyExpCache.php?k='.$v['k'];
}
file_put_contents('../siege/noCache_urls.txt',implode("\n",$nocache));
file_put_contents('../siege/simpleCache_urls.txt',implode("\n",$simple));
file_put_contents('../siege/probEarlyExpCache_urls.txt',implode("\n",$prop));