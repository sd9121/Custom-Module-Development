<?php

namespace Drupal\custom_form\Form;

use Drupal\custom_form\CustomFormServices;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormState;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Database\Database;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax;

class UserForm extends FormBase
{
  protected $customService;

  public static function create(ContainerInterface $container)
  {
    // Instantiates this form class.
    return new static(
    // Load the service required to construct this class.
      $container->get('custom_form.fetchservice'));
  }

  public function __construct(CustomFormServices $customService)
  {
    $this->customService = $customService;
  }

  public function getFormId()
  {

    return 'custom_user_form';

  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['firstname'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#placeholder' => 'First Name',
      '#required' => TRUE,
    );
    $form['lastname'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#placeholder' => 'Last Name',
      '#required' => TRUE,
    );
    $form['qualification'] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => $this->t('Qualification'),
      '#options' => [
        '1' => $this->t('U.G'),
        '2' => $this->t('P.G'),
        '3' => $this->t('Other')
      ],
      '#ajax' => array(
        'callback' => array($this, qualificationValidateCallback),
        // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
        'effect' => 'fade',
        // Javascript event to trigger Ajax. Currently for: 'onchange'.
        'event' => 'change',
        'progress' => array(
          // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
          'type' => 'throbber',
          // Message to show along progress graphic. Default: 'Please wait...'.
          'message' => t('Loading...'),
        ),
      ),
      '#prefix' => '<div id="qualification">',
      '#suffix' => '</div>'
    ];
    // This filed visible when other option select from qualifiaction.
    $form['specify'] = array(
      '#type' => 'textfield',
      '#title' => t('Please specify'),
      '#states' => array(
        'visible' => array(
          ':input[name="qualification"]' => array('value' => '3')
        ),
      ),
    );

    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#options' => [
        '1' => $this->t('India'),
        '2' => $this->t('U.K')
      ],
      '#ajax' => array(
        // Function to call when event on form element triggered.
        'callback' => array($this, countryValidateCallback),
        // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
        'wrapper' => "state-display-dropdown",
        'effect' => 'fade',
        // Javascript event to trigger Ajax. Currently for: 'onchange'.
        'event' => 'change',
        'progress' => array(
          // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
          'type' => 'throbber',
          // Message to show along progress graphic. Default: 'Please wait...'.
          'message' => t('Loading...'),
        ),
      ),
    ];

    $form['states'] = [
      '#type' => 'select',
      '#title' => $this->t('States'),
      '#required' => TRUE,
      '#options' => $this->_ajax_state_list($form_state->getValue('country')),
      '#prefix' => '<div id="state-display-dropdown">',
      '#suffix' => '</div>',
    ];

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function countryValidateCallback(array &$form, FormStateInterface $form_state)
  {
    return $form['states'];
  }

  public function qualificationValidateCallback(array &$form, FormStateInterface $form_state)
  {
    $form['specify']['#required'] = TRUE;
    return $form['specify'];
  }

  public function _ajax_state_list($options)
  {

    if ($options == 1)
      return array_combine(array(
        1,
        2,
        3,
        4,
      ), array(
        $this->t('RAJASTHAN'),
        $this->t('MAHARASTHRA'),
        $this->t('GUJRAT'),
        $this->t('PUNJAB'),
      ));
    if ($options == 2)
      return array_combine(array(
        1,
        2,
        3,
        4,), array(
          $this->t('ABERDEEN'),
          $this->t('ARMAGH'),
          $this->t('BANGOR'),
          $this->t('BATH'),)
      );

    return [];

  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $data = array(
      'firstname' => $form_state->getValue('firstname'),
      'lastname' => $form_state->getValue('lastname')
    );
    if ($this->customService->insertFormValue($data)) {
      drupal_set_message($this->t('Thank you very much @firstname @lastname for your Registeration. You will receive a confirmation email shortly.', [
        '@firstname' => $form_state->getValue('firstname'),
        '@lastname' => $form_state->getValue('lastname'),
      ]));
    } else
      drupal_set_message(t('A server error occurred and processing did not complete.'), 'error');
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // Check the firstname filed is valid
    if (!preg_match("/^[a-zA-Z ]*$/", $form_state->getValue('firstname')) == 1 || strlen($form_state->getValue('firstname')) < 5) {
      $form_state->setErrorByName('firstname', $this->t('First Name is Invalid.'));
    }

    // Check the lastname filed is valid
    if (!preg_match("/^[a-zA-Z ]*$/", $form_state->getValue('lastname')) == 1 || strlen($form_state->getValue('lastname')) < 5) {
      $form_state->setErrorByName('lastname', $this->t('Last Name is Invalid.'));
    }

    // Check the qualification specify is not empty
    if (!$form_state->getValue('specify') && $form_state->getValue('qualification') == 3) {
      $form_state->setErrorByName('specify', $this->t('Specify filed can not be empty.'));
    }
    // Check the specify filed is valid
    if (!preg_match("/^[a-zA-Z ]*$/", $form_state->getValue('specify')) == 1) {
      $form_state->setErrorByName('specify', $this->t('Specify is Invalid.'));
    }
  }
}
