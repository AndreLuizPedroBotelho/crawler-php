<?php

class FileJson
{
  public $fileJsonName;

  function __construct($fileJsonName)
  {
    $this->fileJsonName = $fileJsonName;
  }

  public function createFileJson($data)
  {
    $fp = fopen($this->fileJsonName, 'w');
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fclose($fp);
  }

  public function getFileJson()
  {
    return  json_encode(json_decode(file_get_contents($this->fileJsonName)), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }
}
