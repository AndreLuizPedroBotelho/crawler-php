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

echo "<h2 style='display: flex;flex-direction: row;align-items: flex-end;'>
<image width=25 src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/8d/Download_alt_font_awesome.svg/512px-Download_alt_font_awesome.svg.png' />
<a style='text-decoration:none;margin-left: 10px;color: black;' href='results.json' download>Baixar o arquivo aqui!</a>
</h2>";
