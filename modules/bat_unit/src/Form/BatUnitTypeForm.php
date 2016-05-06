<?php

namespace Drupal\bat_unit\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BatUnitTypeForm.
 *
 * @package Drupal\bat_unit\Form
 */
class BatUnitTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $bat_unit_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $bat_unit_type->label(),
      '#description' => $this->t("Label for the Unit type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $bat_unit_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\bat_unit\Entity\BatUnitType::load',
      ),
      '#disabled' => !$bat_unit_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $bat_unit_type = $this->entity;
    $status = $bat_unit_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Unit type.', [
          '%label' => $bat_unit_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Unit type.', [
          '%label' => $bat_unit_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($bat_unit_type->urlInfo('collection'));
  }

}
