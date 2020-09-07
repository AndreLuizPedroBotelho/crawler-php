<?php

include 'CrawlerMG.php';
include 'FileJson.php';

//Create crawler
$crawlerMG = new CrawlerMG();
$data = $crawlerMG->execute();

//Create json file
$fileJson = new FileJson('results.json');
$fileJson->createFileJson($data);

// Print in screen
echo '<h2>Preview</h2>';

$fileJsonPrint = $fileJson->getFileJson();

echo "<pre style='white-space: pre-wrap;'><code>$fileJsonPrint</code></pre>";

echo "<h2 style='display: flex;flex-direction: row;align-items: flex-end;'>
<image width=25 src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/8d/Download_alt_font_awesome.svg/512px-Download_alt_font_awesome.svg.png' />
<a style='text-decoration:none;margin-left: 10px;color: black;' href='results.json' download>Baixar o arquivo aqui!</a>
</h2>";
