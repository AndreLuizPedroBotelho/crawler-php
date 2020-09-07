<?php

include 'CrawlerMG.php';

$crawlerMG = new CrawlerMG();
$data = $crawlerMG->execute();

$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
fclose($fp);

echo '<h2>Preview</h2>';

$data = json_encode(json_decode(file_get_contents('results.json')), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "<pre style='white-space: pre-wrap;'><code>$data</code></pre>";

echo "<h2><a href='results.json' download>Baixar arquivo aqui!</a></h2>";
