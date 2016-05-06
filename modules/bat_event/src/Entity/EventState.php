<?php

namespace Drupal\bat_event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\bat_event\EventStateInterface;

/**
 * Defines the Event state entity.
 *
 * @ConfigEntityType(
 *   id = "event_state",
 *   label = @Translation("Event state"),
 *   handlers = {
 *     "list_builder" = "Drupal\bat_event\EventStateListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bat_event\Form\EventStateForm",
 *       "edit" = "Drupal\bat_event\Form\EventStateForm",
 *       "delete" = "Drupal\bat_event\Form\EventStateDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bat_event\EventStateHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "event_state",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/bat/config/event_state/{event_state}",
 *     "add-form" = "/admin/bat/config/event_state/add",
 *     "edit-form" = "/admin/bat/config/event_state/{event_state}/edit",
 *     "delete-form" = "/admin/bat/config/event_state/{event_state}/delete",
 *     "collection" = "/admin/bat/config/event_state"
 *   }
 * )
 */
class EventState extends ConfigEntityBase implements EventStateInterface {

  /**
   * The Event state ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Event state label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Event type Id.
   *
   * @var string
   */
  protected $eventTypeId;


  /**
   * The Event state color.
   *
   * @var string
   */
  protected $color;

  /**
   * The Event state Calendar label.
   *
   * @var string
   */
  protected $calendarLabel;

  /**
   * Event state blocking status.
   *
   * @var bool
   */
  protected $blocking;

}
