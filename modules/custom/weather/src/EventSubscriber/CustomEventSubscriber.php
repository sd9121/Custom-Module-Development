<?php
/**
 * @file
 * Contains \Drupal\weather\EventSubscriber\CustomEventSubscriber.
 */

namespace Drupal\weather\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Component\Utility\Unicode;
use Drupal\weather\NodeInsert;

/**
 * Event Subscriber CustomEventSubscriber.
 */
class CustomEventSubscriber implements EventSubscriberInterface
{

  /**
   * Code that should be triggered on event specified
   */
  public function addAccessAllowOriginHeaders(FilterResponseEvent $event)
  {
    // The RESPONSE event occurs once a response was created for replying to a request.
    preg_match('/node/', \Drupal::service('path.current')->getPath(), $matches, PREG_OFFSET_CAPTURE);
    if ($matches[0][0]) {
      $response = $event->getResponse();
      $response->headers->set('Access-Control-Allow-Origin', '*');
    }
  }

  public function nodeInsert(NodeInsert $events)
  {
    $message = 'Node title ' . $events->getReferenceNode()->getTitle() . ' being created.';
    // Logs a notice
    \Drupal::logger('weather')->notice($message);
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents()
  {
    // I am using KernelEvents constants
    // The RESPONSE event occurs once a response was created for replying to a request.
    $events[KernelEvents::RESPONSE][] = array('addAccessAllowOriginHeaders');
    $events[NodeInsert::INSERT][] = array('nodeInsert');
    return $events;
  }
}
