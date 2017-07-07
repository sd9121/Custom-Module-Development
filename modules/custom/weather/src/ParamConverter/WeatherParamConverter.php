<?php

/**
 * @file
 * Contains \Drupal\weather\ParamConverter\WeatherParamConverter.
 */

namespace Drupal\weather\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\Routing\Route;

class WeatherParamConverter implements ParamConverterInterface {
  public function convert($value, $definition, $name, array $defaults) {
    return \Drupal::config($value)->get('config_values.app_id');
  }

  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'config_name');
  }
}
