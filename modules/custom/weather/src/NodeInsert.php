<?php

namespace Drupal\weather;

use Symfony\Component\EventDispatcher\Event;

/**
 * Contains all events thrown in the NodeInsert component.
 *
 * @author Sagar Singh <sagar.deora@qed42.com>
 */
class NodeInsert extends Event
{

  /**
   * The INSERT event occurs at when new content type insert.
   * receives a Symfony\Component\HttpKernel\Event\GetResponseEvent
   * instance.
   *
   * @Event
   *
   * @var string
   */
  const INSERT = 'node.insert';
  protected $referenceNode;

  /**
   * Constructs a new Node Instance.
   *
   * @param $node
   * Node object.
   */
  public function __construct($node)
  {
    $this->referenceNode = $node;
  }

  /**
   * Getter for the getReferenceNode.
   *
   * @return Instance
   *  Node object.
   */
  public function getReferenceNode()
  {
    return $this->referenceNode;
  }
}
