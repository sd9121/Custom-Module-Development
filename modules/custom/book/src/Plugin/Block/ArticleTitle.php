<?php

namespace Drupal\book\Plugin\Block;

use Drupal\Core\block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Article Title Block' block.
 *
 * @Block(
 *   id = "article_title_block",
 *   admin_label = @Translation("Article Title block"),
 *   category = @Translation("Custom Article Title Information Block.")
 * )
 */
class ArticleTitle extends BlockBase
{
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $connection = Database::getConnection();
    $query = $connection->select('node_field_data', 'n')
      ->fields('n', ['nid', 'title'])
      ->condition('type', 'article', '=')
      ->orderBy('created', 'DESC')
      ->range(0, 3)
      ->execute();
    $values[] = '';
    foreach ($query as $key => $value) {
      $values[$key]['nid'] = $value->nid;
      $values[$key]['title'] = $value->title;
    }
    return [
      '#markup' =>
        '1 ' . $values[0]['title'] . '<br>' .
        '2 ' . $values[1]['title'] . '<br>' .
        '3 ' . $values[2]['title'] . '<br>' .
        'email : ' . \Drupal::currentUser()->getEmail(),

      '#cache' => [
        'keys' => ['article_title_block'],
        'contexts' => ['url.path', 'user'],
        'tags' => ['node:' . $values[0]['nid'], 'node:' . $values[1]['nid'] . 'node:' . $values[2]['nid']],
        'max-age' => 3600,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {

  }

}
