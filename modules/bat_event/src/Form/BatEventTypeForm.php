<?php

namespace Drupal\bat_event\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BatEventTypeForm.
 *
 * @package Drupal\bat_event\Form
 */
class BatEventTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $bat_event_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $bat_event_type->label(),
      '#description' => $this->t("Label for the Events type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $bat_event_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\bat_event\Entity\BatEventType::load',
      ),
      '#disabled' => !$bat_event_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $bat_event_type = $this->entity;
    $status = $bat_event_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Events type.', [
          '%label' => $bat_event_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Events type.', [
          '%label' => $bat_event_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($bat_event_type->urlInfo('collection'));
  }

}
