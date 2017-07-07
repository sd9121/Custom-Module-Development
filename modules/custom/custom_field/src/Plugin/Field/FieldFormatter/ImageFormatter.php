<?php

namespace Drupal\custom_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Plugin implementation of the '<field_formatter_id>' formatter.
 *
 * @FieldFormatter(
 *   id = "<custom_field_access>",
 *   label = @Translation("<Custom Field>"),
 *   field_types = {
 *     "<custom_field_formatter>"
 *   }
 * )
 */
Class ImageFormatter extends FormatterBase
{
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode)
  {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'person_default',
        '#forename' => check_plain($item->forename),
        '#surname' => check_plain($item->surname),
        '#age' => check_plain($item->age),
      );
    }
    return $elements;
  }
}

//Class ImageFormatter extends FormatterBase {
//
// public function settingsSummary()
// {
//   $summary = array();
//   $settings = $this->getSettings();
//
//   $summary[] = t('Displays the random string.');
//
//   return $summary;
// }
//
//  /**
//   * @inheritDoc
//   */
//  public function viewElements(FieldItemListInterface $items, $langcode)
//  {
//    $element = array();
//  kint($items);
//  exit();
//    foreach ($items as $delta => $item) {
//      // Render each element as markup.
//      $element[$delta] = array(
//              '#type' => 'markup',
//              '#markup' => $item->value,
//      );
//    }
//
//    return $element;
//  }
//
//  /**
//   * @inheritDoc
//   * Override PluginSettingsBase::defaultSettings() in order to set the defaults
//   */
//  public static function defaultSettings()
//  {
//    return [
//              // Declare a setting named 'text_length', with
//              // a default value of 'short'
//                    'text_length' => 'short',
//            ] + parent::defaultSettings();
//  }
//
//  /**
//   * @inheritDoc
//   */
//  public function settingsForm(array $form, FormStateInterface $form_state)
//  {
//    $element['text_length'] = [
//            '#title' => t('Text length'),
//            '#type' => 'select',
//            '#options' => [
//                    'short' => $this->t('Short'),
//                    'long' => $this->t('Long'),
//            ],
//            '#default_value' => $this->getSetting('text_length'),
//    ];
//
//    return $element;
//  }
//  /**
//   *The form to allow for users to change the values for the settings is created by overriding FormatterBase::settingsForm()
//  */
//
//
//}