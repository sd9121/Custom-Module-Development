<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Weather Block' block.
 *
 * @Block(
 *   id = "weather_city_block",
 *   admin_label = @Translation("Weather block"),
 *   category = @Translation("Custom City Weather Block Example")
 * )
 */
class WeatherBlockInformation extends BlockBase
{
  /**
   * {@inheritdoc}
   */
  protected $client_response;
  protected $data;

  public function build()
  {

    $appid = \Drupal::config('weather.settings.appid')->get('config_values.app_id');
    $config = $this->getConfiguration();
    $this->client_response = \Drupal::service('weather.http_client');
    $this->data = $this->client_response->getResponse($appid, $config);
    if ($this->data) {
      return [
        '#theme' => 'weather_template',
        '#city' => $config['city_name'],
        '#data' => [
          'min_temp' => $this->data->main->temp_min,
          'max_temp' => $this->data->main->temp_max,
          'pressure' => $this->data->main->pressure,
          'humidity' => $this->data->main->humidity,
          'wind_speed' => $this->data->wind->speed,
        ],
        '#attached' => [
          'library' => [
            'weather/weather.theme',
          ],
        ],
      ];
    }
    return [
      '#markup' => 'Something wents wrong ,Check internet connection :( ',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);
    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();

    // Add a form field to the existing block configuration form.
    $form['city_name'] = array(
      '#type' => 'textfield',
      '#title' => t('City Name'),
      '#default_value' => isset($config['city_name']) ? $config['city_name'] : '',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('city_name', $form_state->getValue('city_name'));
  }

}
