<?php

namespace Drupal\weather;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

/**
 * Provides a response using GuzzleHttp.
 */
class WeatherServices
{

  protected $client;
  protected $base_url;
  protected $response;

  /**
   * Constructs a new WeatherServices.
   *
   * @param GuzzleHttp\Client $entity_manager $client
   *   The client manager.
   */
  public function __construct(Client $client, $base_url)
  {
    $this->client = $client;
    $this->base_url = $base_url;
  }

  /**
   * Getter for the client.
   *
   * @return string
   *   The type of the client object.
   */
  public function getClient()
  {
    return $this->client;
  }


  /**
   * Getter for the baseurl.
   *
   * @return string
   *  An url.
   */
  public function getBaseUrl()
  {
    return $this->base_url;
  }


  /**
   * Getter for the response.
   *
   * @return object array
   *  The type of the object array format
   */
  public function getResponse($appid, $config)
  {
    try {
      $this->response = $this->client->get($this->base_url . $config['city_name'] . '&appid=' . $appid);
      return $this->getJsonDecodeValues();
    } catch (RequestException $ex) {
      return 0;
    }
  }

  /**
   * Getter for the resonse.
   *
   * @return Json
   *  Decode the type of the json format
   */
  public function getJsonDecodeValues()
  {
    return json_decode($this->response->getBody()->getContents());
  }

}
