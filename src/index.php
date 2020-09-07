<?php

include 'CrawlerMG.php';

$crawlerMG = new CrawlerMG();
$data = $crawlerMG->execute();

$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
fclose($fp);

echo "<h2><a href='results.json' download>Baixar arquivo aqui!</a></h2>";

echo '<h2>Preview</h2>';

$data = file_get_contents('results.json');

echo "<div style='background: #d2d2d2;padding: 13px;'>$data</div>";
