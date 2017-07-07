<?php

namespace Drupal\weather\Form;

use Drupal\weather\WeatherServices;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormState;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class WeatherForm extends ConfigFormBase
{

  protected $customService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    // Instantiates this form class.
    return new static(
    // Load the service required to construct this class.
      $container->get('weather.http_client'));
  }

  public function __construct(WeatherServices $customService)
  {
    $this->customService = $customService;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'weather.settings.appid',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    $default_config = \Drupal::config('weather.settings.appid');
    return array(
      'app_id' => $default_config->get('config_values.app_id'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {

    return 'weather_form';

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $config = $this->config('weather.settings.appid');
    $form['app_id'] = array(
      '#type' => 'textfield',
      '#title' => t('App ID'),
      '#placeholder' => 'App ID',
      '#default_value' => $config->get('config_values.app_id'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save configuration'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $values = $form_state->getValues();
    $this->config('weather.settings.appid')
      ->set('config_values', $values)
      ->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // Check the App Id filed is valid
  }
}
