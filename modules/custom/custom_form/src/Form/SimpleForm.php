<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

class SimpleForm extends FormBase
{
  public function getFormId()
  {
    // TODO: Implement getFormId() method.
    return 'custom_simple_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // TODO: Implement buildForm() method.
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
    drupal_set_message(t('You entered name is ' . $form_state->getValue('name')), 'status', TRUE);
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (!preg_match("/^[a-zA-Z ]*$/", $form_state->getValue('name')) == 1) {
      // string only contain the a to z , A to Z
      $form_state->setErrorByName('name', $this->t('Name cannot be numeric or alphanumeric .'));
    }
  }
}
