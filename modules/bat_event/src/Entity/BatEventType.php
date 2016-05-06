<?php

namespace Drupal\bat_event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\bat_event\BatEventTypeInterface;

/**
 * Defines the Events type entity.
 *
 * @ConfigEntityType(
 *   id = "bat_event_type",
 *   label = @Translation("Events type"),
 *   handlers = {
 *     "list_builder" = "Drupal\bat_event\BatEventTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bat_event\Form\BatEventTypeForm",
 *       "edit" = "Drupal\bat_event\Form\BatEventTypeForm",
 *       "delete" = "Drupal\bat_event\Form\BatEventTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bat_event\BatEventTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "bat_event_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "bat_event",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/bat/config/bat_event_type/{bat_event_type}",
 *     "add-form" = "/admin/bat/config/bat_event_type/add",
 *     "edit-form" = "/admin/bat/config/bat_event_type/{bat_event_type}/edit",
 *     "delete-form" = "/admin/bat/config/bat_event_type/{bat_event_type}/delete",
 *     "collection" = "/admin/bat/config/bat_event_type"
 *   }
 * )
 */
class BatEventType extends ConfigEntityBundleBase implements BatEventTypeInterface {

  /**
   * The Events type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Events type label.
   *
   * @var string
   */
  protected $label;

}
