<?php

/**
 * @file
 * Contains Drupal\example_ajax\ExampleAjaxForm
 */

namespace Drupal\example_ajax\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ExampleAjaxForm extends FormBase {

  public function getFormId() {
    return 'example_form_ajax';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => 'Name',
      '#description' => 'Please enter a name',
    );

    $form['hello'] = array(
      '#type' => 'button',
      '#title' => 'Say Hello!',
      '#description' => 'Say Hello!',
      '#ajax' => array(
        // Function to call when event on form element triggered.
        'callback' => 'Drupal\example_ajax\Form\ExampleAjaxForm::myAjaxCallback',
        // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
        'effect' => 'fade',
        // Javascript event to trigger Ajax. Currently for: 'onchange'.
        'event' => 'click',
        'progress' => array(
          // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
          'type' => 'throbber',
          // Message to show along progress graphic. Default: 'Please wait...'.
          'message' => NULL,
        ),
      ),
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('Nothing Submitted. Just an Example.');
  }

  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    // Instantiate an AjaxResponse Object to return.
    $ajax_response = new AjaxResponse();

    $text = "Hello " . $form_state->getValue('name') . '!';

    // Add a command to execute on form, jQuery .html() replaces content between tags.
    // In this case, we replace the desription with wheter the username was found or not.
    $ajax_response->addCommand(new ReplaceCommand('#example-form-ajax', $text));


    return $ajax_response;
  }

}