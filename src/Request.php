<?php

use \GuzzleHttp\Client;

class Request
{
  public  static function getRequest(string $url)
  {
    $client = new Client();

    $response = $client->get($url);

    return $response->getBody()->getContents();
  }
}
