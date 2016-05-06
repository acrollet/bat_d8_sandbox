<?php

namespace Drupal\bat_unit\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\bat_unit\BatUnitTypeInterface;

/**
 * Defines the Unit type entity.
 *
 * @ConfigEntityType(
 *   id = "bat_unit_type",
 *   label = @Translation("Unit type"),
 *   handlers = {
 *     "list_builder" = "Drupal\bat_unit\BatUnitTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bat_unit\Form\BatUnitTypeForm",
 *       "edit" = "Drupal\bat_unit\Form\BatUnitTypeForm",
 *       "delete" = "Drupal\bat_unit\Form\BatUnitTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bat_unit\BatUnitTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "bat_unit_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "bat_unit",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/bat/config/bat_unit_type/{bat_unit_type}",
 *     "add-form" = "/admin/bat/config/bat_unit_type/add",
 *     "edit-form" = "/admin/bat/config/bat_unit_type/{bat_unit_type}/edit",
 *     "delete-form" = "/admin/bat/config/bat_unit_type/{bat_unit_type}/delete",
 *     "collection" = "/admin/bat/config/bat_unit_type"
 *   }
 * )
 */
class BatUnitType extends ConfigEntityBundleBase implements BatUnitTypeInterface {

  /**
   * The Unit type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Unit type label.
   *
   * @var string
   */
  protected $label;

}
