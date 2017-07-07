<?php

namespace Drupal\weather\Controller;


class ParameterUpcaster{

public function upcastConfig($config_name) {
if($config_name)
{
   return $render =
      [
        '#title' => 'Configuration Value is ' . $config_name
      ];
}
else
{
   return $render =
      [
        '#title' => 'Config does not exist yet'
      ];
    }
  }
}
