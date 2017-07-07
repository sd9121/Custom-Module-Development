<?php
/**
 * Contains \Drupal\my_menu\Controller\MyMenuController.
 */

namespace Drupal\my_menu\Controller;

use Symfony\Component\HttpFoundation\Response;

class MyMenuController
{

  public function d8_node_detail_callback($argument)
  {
    return $render =
      [
        '#title' => 'Hello! I am your ' . $argument . ' node listing page.'
      ];
  }

  public function d8_listing_callback($node)
  {
    // $userId=\Drupal::currentUser();
    // kint($userId);

    return node_view($node);
  }

  public function d8_dynamic_listing_callback($arg)
  {
    return $render =
      [
        '#title' => 'Hello! I am your ' . $arg . ' listing page.'
      ];
    // return node_view($node);
  }

}
