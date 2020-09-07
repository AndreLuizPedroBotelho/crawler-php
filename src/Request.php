<?php

use \GuzzleHttp\Client;

class Request
{
  public $client;

  function __construct()
  {
    $this->client = new Client();
  }

  public function getRequest(string $url)
  {
    $response = $this->client->get($url);

    return $response->getBody()->getContents();
  }
}
