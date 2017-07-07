<?php

namespace Drupal\custom_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;


/**
 * Plugin implementation of the 'custom_field' field type.
 *
 * @FieldType(
 *   id = "custom_field_access",
 *   label = @Translation("Custom Field"),
 *   description = @Translation("Allow user to access"),
 *   default_widget = "<custom_field_widget>",
 *   default_formatter = "<custom_field_formatter>"
 * )
 */
class ImageItem extends FieldItemBase implements FieldItemInterface
{
  /**
   * {@inheritdoc}
   */
  static $propertyDefinitions;

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition)
  {
    return array(
      'columns' => array(
        'forename' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => TRUE,
        ),
        'surname' => array(
          'type' => 'varchar',
          'length' => 256,
          'not null' => TRUE,
        ),
        'age' => array(
          'type' => 'int',
          'not null' => TRUE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty()
  {
    $value = $this->get('forename')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
  {
    if (!isset(static::$propertyDefinitions)) {
      static::$propertyDefinitions['forename'] = array(
        'type' => 'string',
        'label' => t('Forename'),
      );
      static::$propertyDefinitions['surname'] = array(
        'type' => 'string',
        'label' => t('Surname'),
      );
      static::$propertyDefinitions['age'] = array(
        'type' => 'integer',
        'label' => t('Age'),
      );
    }
    return static::$propertyDefinitions;
  }
}

///**
// * Provides a field type of baz.
// *
// * @FieldType(
// *   id = "custom_field",
// *   label = @Translation("Custom field"),
// *   default_formatter = "custom_formatter",
// *   default_widget = "custom_widget",
// * )
// */
//
//class ImageItem extends FieldItemBase implements FieldItemInterface{
//  /**
//   * @inheritDoc
//   */
//  public static function schema(FieldStorageDefinitionInterface $field_definition)
//  {
//    return array(
//      // columns contains the values that the field will store
//            'columns' => array(
//              // List the values that the field will save. This
//              // field will only save a single value, 'value'
//                    'value' => array(
//                            'type' => 'text',
//                            'size' => 'tiny',
//                            'not null' => FALSE,
//                    ),
//            ),
//    );
//  }
//
//
//  /**
//   * @inheritDoc
//   */
//  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
//  {
//    $properties = [];
//    $properties['value'] = DataDefinition::create('string');
//
//    return $properties;
//  }
//
//  /**
//   * @inheritDoc
//   */
//  public function isEmpty()
//  {
//    $value = $this->get('value')->getValue();
//    return $value === NULL || $value === '';
//  }
//
//  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
//    // Some fields above.
//
//    $fields['custom_field'] = BaseFieldDefinition::create('custom_field'); // Ensures that you can have more than just one member
//
//    // Even more fields below.
//
//    return $fields;
//  }
//
//  /**
//   * @inheritDoc
//   */
// public function fieldSettingsForm(array $form, FormStateInterface $form_state)
//{
//  $element = [];
//  // The key of the element should be the setting name
//  $element['size'] = [
//          '#title' => $this->t('Size'),
//          '#type' => 'select',
//          '#options' => [
//                  'small' => $this->t('Small'),
//                  'medium' => $this->t('Medium'),
//                  'large' => $this->t('Large'),
//          ],
//          '#default_value' => $this->getSetting('size'),
//  ];
//
//  return $element;
//}
//
//}