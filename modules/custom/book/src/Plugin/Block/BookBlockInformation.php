<?php

namespace Drupal\book\Plugin\Block;

use Drupal\Core\block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Provides a 'Book Block' block.
 *
 * @Block(
 *   id = "book_block",
 *   admin_label = @Translation("Book block"),
 *   category = @Translation("Custom Book Information Block.")
 * )
 */
class BookBlockInformation extends BlockBase
{
  /**
   * {@inheritdoc}
   */
  protected $client_response;
  protected $data;

  public function build()
  {
    $config = $this->getConfiguration();
    try {
      $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
      $fetcher = new Fetcher($client);
      $book = $fetcher->forISBN($config['isbn']);
      $values = $book->title . '<br>' . $book->subtitle . '<br>' . $book->authors . '<br>' . $book->language . '<br>' . $book->categories . '<br>' . $book->averageRating;
      return [
        '#markup' => $values,
      ];
    } catch (RequestException $ex) {
      return [
        '#markup' => 'Something wents wrong ,Check internet connection :( ',
      ];
    }
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
    $form['isbn'] = array(
      '#type' => 'textfield',
      '#title' => t('ISBN Number'),
      '#default_value' => isset($config['isbn']) ? $config['isbn'] : '',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('isbn', $form_state->getValue('isbn'));
  }

}
