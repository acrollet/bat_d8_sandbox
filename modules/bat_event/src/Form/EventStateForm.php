<?php

namespace Drupal\bat_event\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EventStateForm.
 *
 * @package Drupal\bat_event\Form
 */
class EventStateForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $event_state = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $event_state->label(),
      '#description' => $this->t("Label for the Event state."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $event_state->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\bat_event\Entity\EventState::load',
      ),
      '#disabled' => !$event_state->isNew(),
    );

    $form['eventTypeId'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Event Type"),
      '#default_value' => $event_state->get('eventTypeId'),
      '#description' => $this->t("Event Type Id"),
      '#disabled' => !$event_state->isNew(),
      '#required' => TRUE,
    );

    $form['color'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Color"),
      '#default_value' => $event_state->get('color'),
      '#maxlength' => 7,
      '#description' => $this->t("Hex color"),
      '#element_validate' => array(array($this, 'validate_hex_color')),
      '#required' => TRUE,
    );

    $form['calendarLabel'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Calendar Label"),
      '#default_value' => $event_state->get('calendarLabel'),
      '#required' => TRUE,
    );

    $form['blocking'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t("Blocking"),
      '#default_value' => $event_state->get('blocking'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $event_state = $this->entity;

    // Create the bat identifier.
    if ($event_state->isNew()) {
      // Get next available serial number.
      $query = \Drupal::entityQuery('event_state');
      $result = $query->execute();
      $serials = array();
      foreach ($result as $key => $record) {
        $state = entity_load('event_state', $key);
        $serials[] = $state->get('serial');
      }
      $event_state->serial = max($serials) + 1;
    }

    $status = $event_state->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Event state.', [
          '%label' => $event_state->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Event state.', [
          '%label' => $event_state->label(),
        ]));
    }
    $form_state->setRedirectUrl($event_state->urlInfo('collection'));
  }

  /**
   * Utility method to validate hex color numbers.
   */
  public function validate_hex_color($element, &$form_state) {
    if (!preg_match('/^#[a-f0-9]{6}$/i', $element['#value'])) {
      $form_state->setErrorByName($element['#name'], t('This is not a valid hexadecimal color!'));
    }
  }

}
