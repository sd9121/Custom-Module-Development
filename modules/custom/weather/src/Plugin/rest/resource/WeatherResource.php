<?php

namespace Drupal\weather\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Weather Resource
 *
 * @RestResource(
 *   id = "weatherresource_01",
 *   label = @Translation("Weather Resource"),
 *   uri_paths = {
 *     "canonical" = "/weather/weatherresource_01",
 *   }
 * )
 */
class WeatherResource extends ResourceBase {
/**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
*/
  public function get() {

    $appid = \Drupal::config('weather.settings.appid')->get('config_values.app_id');
    $response=[
      'message' => 'The Resource is from the get method',
      'appid' => $appid
    ];
    return new ResourceResponse($response);
  }
  public function post(){
    $appid=\Drupal::config('weather.settings.appid')->get('config_values.app_id');
    $response=[
      'message' => 'The Resource is from the post method',
      'appid' => $appid
    ];
    return new ResourceResponse ($response);
  }
}
