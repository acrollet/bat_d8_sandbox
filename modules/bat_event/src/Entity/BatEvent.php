<?php

namespace Drupal\bat_event\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\bat_event\BatEventInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Events entity.
 *
 * @ingroup bat_event
 *
 * @ContentEntityType(
 *   id = "bat_event",
 *   label = @Translation("Events"),
 *   bundle_label = @Translation("Events type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bat_event\BatEventListBuilder",
 *     "views_data" = "Drupal\bat_event\Entity\BatEventViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\bat_event\Form\BatEventForm",
 *       "add" = "Drupal\bat_event\Form\BatEventForm",
 *       "edit" = "Drupal\bat_event\Form\BatEventForm",
 *       "delete" = "Drupal\bat_event\Form\BatEventDeleteForm",
 *     },
 *     "access" = "Drupal\bat_event\BatEventAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\bat_event\BatEventHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "bat_event",
 *   admin_permission = "administer events entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/bat/bat_event/{bat_event}",
 *     "add-form" = "/admin/bat/bat_event/add/{bat_event_type}",
 *     "edit-form" = "/admin/bat/bat_event/{bat_event}/edit",
 *     "delete-form" = "/admin/bat/bat_event/{bat_event}/delete",
 *     "collection" = "/admin/bat/bat_event",
 *   },
 *   bundle_entity_type = "bat_event_type",
 *   field_ui_base_route = "entity.bat_event_type.edit_form"
 * )
 */
class BatEvent extends ContentEntityBase implements BatEventInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Events entity.'))
      ->setReadOnly(TRUE);
    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type'))
      ->setDescription(t('The Events type/bundle.'))
      ->setSetting('target_type', 'bat_event_type')
      ->setRequired(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Events entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Events entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Event.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Event is published.'))
      ->setDefaultValue(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Event entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['start_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start Date'))
      ->setDescription(t('The start date for the event.'))
      ->setRequired(true)
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'date',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['end_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End Date'))
      ->setDescription(t('The end date for the event.'))
      ->setRequired(true)
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'date',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['unit_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Unit'))
      ->setDescription(t('The BAT unit ID for this event.'))
      ->setRequired(true)
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'bat_unit')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 0,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}