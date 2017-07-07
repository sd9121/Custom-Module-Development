<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\RulesAction\SystemMailToUsersOfRole.
 */

namespace Drupal\rules\Plugin\RulesAction;

use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesActionBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\UserStorage;

/**
 * Provides a 'Mail to users of a role' action.
 *
 * @RulesAction(
 *   id = "rules_mail_to_users_of_role",
 *   label = @Translation("Mail to users of a role"),
 *   category = @Translation("System"),
 *   context = {
 *     "roles" = @ContextDefinition("entity:user_role",
 *       label = @Translation("Roles"),
 *       description = @Translation("The roles to which to send the e-mail."),
 *       multiple = TRUE
 *     ),
 *     "subject" = @ContextDefinition("string",
 *       label = @Translation("Subject"),
 *       description = @Translation("The email's subject."),
 *     ),
 *     "message" = @ContextDefinition("textarea",
 *       label = @Translation("Message"),
 *       description = @Translation("The email's message body."),
 *     ),
 *     "reply" = @ContextDefinition("email",
 *       label = @Translation("Reply to"),
 *       description = @Translation("The mail's reply-to address. Leave it empty to use the site-wide configured address."),
 *       default_value = NULL,
 *       required = FALSE,
 *     ),
 *     "language" = @ContextDefinition("language",
 *       label = @Translation("Language"),
 *       description = @Translation("If specified, the language used for getting the mail message and subject."),
 *       default_value = NULL,
 *       required = FALSE,
 *     ),
 *   }
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 */
class SystemMailToUsersOfRole extends RulesActionBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * @var \Drupal\user\UserStorage
   */
  protected $userStorage;

  /**
   * Constructs a SendMailToUsersOfRole object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The storage service.
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The mail manager service.
   * @param \Drupal\user\UserStorage $userStorage
   *   The user storage service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerInterface $logger, MailManagerInterface $mail_manager, UserStorage $userStorage) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->logger = $logger;
    $this->mailManager = $mail_manager;
    $this->userStorage = $userStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory')->get('rules'),
      $container->get('plugin.manager.mail'),
      $container->get('entity.manager')->getStorage('user')
    );
  }

   /**
   * Send a system email.
   *
   * @param \Drupal\user\RoleInterface[] $roles
   *   Array of user $roles.
   * @param string $subject
   *   Subject of the email.
   * @param string $message
   *   Email message text.
   * @param string|null $reply
   *   (optional) Reply to email address.
   * @param \Drupal\Core\Language\LanguageInterface|null $language
   *   (optional) Language code.
   */
  public function doExecute($roles, $subject, $message, $reply, $language) {
    $langcode = isset($language) ? $language->getId() : LanguageInterface::LANGCODE_SITE_DEFAULT;
    if (empty($roles)) {
      return;
    }
    $roles_arr = array();
    foreach($roles as $role => $value) {
       if(!empty($value)) {
         $roles_arr[] = trim($value);
       }
    }
    $key = $this->getPluginId();
    $accounts = $this->userStorage->loadByProperties(['roles' => $roles_arr]);
    $recipients = '';
    foreach ($accounts as $account) {
        if($recipients == '') {
            $recipients = '' . $account->getEmail();
        } else {
            $recipients = $recipients . ', ' . $account->getEmail();
        }
    }
    $params = array(
      'subject' => $subject,
      'message' => $message,
    );
   $message = $this->mailManager->mail('rules', $key, $recipients, $langcode, $params,NULL);
  }
}