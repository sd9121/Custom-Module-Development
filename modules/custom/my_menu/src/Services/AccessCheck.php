<?php

namespace Drupal\my_menu\Services;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatch;

Class AccessCheck implements AccessInterface
{

  protected $currentUser;
  protected $nodeId;
  protected $nodeOwnerId;

  public function __construct(AccountProxy $current_user)
  {
    $this->currentUser = $current_user;
  }

  public function access(Route $route, RouteMatch $routeMatch)
  {
    $nodeId = $routeMatch->getParameter('node')->id();
    $nodeOwnerId = $routeMatch->getParameter('node')->getOwner()->id();
    /**
     * Compare login user with node author.
     */
    if ($route->getRequirement('_access_my_node') === 'TRUE') {
      if ($this->currentUser->id() == $nodeOwnerId)
        return AccessResult::allowed();
      else
        return AccessResult::forbidden();
    } elseif ($route->getRequirement('_access_my_node') === 'FALSE') {
      return AccessResult::forbidden();
    } else {
      return AccessResult::neutral();
    }
  }
}
