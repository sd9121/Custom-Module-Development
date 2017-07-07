<?php

namespace Drupal\custom_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Plugin implementation of the '<field_widget_id>' widget.
 *
 * @FieldWidget(
 *   id = "<custom_field_access>",
 *   label = @Translation("<Custom Field"),
 *   field_types = {
 *     "<custom_field_widget>"
 *   }
 * )
 */
class ImageWidget extends WidgetBase
{
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {

    $element['forename'] = array(
      '#title' => t('Forename'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->forename) ? $items[$delta]->forename : NULL,
    );
    $element['surname'] = array(
      '#title' => t('Surname'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->surname) ? $items[$delta]->surname : NULL,
    );
    $element['age'] = array(
      '#title' => t('Age'),
      '#type' => 'number',
      '#default_value' => isset($items[$delta]->age) ? $items[$delta]->age : NULL,
    );
    return $element;
  }
}

///**
// * Plugin implementation of the 'entity_user_access_w' widget.
// *
// * @FieldWidget(
// *   id = "custom_field_w",
// *   label = @Translation("Custom field - Widget"),
// *   description = @Translation("Entity User Access - Widget"),
// * )
// */
//
//class ImageWidget extends WidgetBase {
//
//  /**
//   * @inheritDoc
//   */
//  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
//  {
//    $element['userlist'] = array(
//            '#type' => 'select',
//            '#title' => t('User'),
//            '#description' => t('Select group members from the list.'),
//            '#options' => array(
//                    0 => t('Anonymous'),
//                    1 => t('Admin'),
//                    2 => t('foobar'),
//              // This should be implemented in a better way!
//            ),
//    );
//
//    // Build the element render array.
//    return $element;
//  }
//}