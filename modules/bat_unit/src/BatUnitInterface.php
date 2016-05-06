<?php

namespace Drupal\bat_unit;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Unit entities.
 *
 * @ingroup bat_unit
 */
interface BatUnitInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Unit type.
   *
   * @return string
   *   The Unit type.
   */
  public function getType();

  /**
   * Gets the Unit name.
   *
   * @return string
   *   Name of the Unit.
   */
  public function getName();

  /**
   * Sets the Unit name.
   *
   * @param string $name
   *   The Unit name.
   *
   * @return \Drupal\bat_unit\BatUnitInterface
   *   The called Unit entity.
   */
  public function setName($name);

  /**
   * Gets the Unit creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Unit.
   */
  public function getCreatedTime();

  /**
   * Sets the Unit creation timestamp.
   *
   * @param int $timestamp
   *   The Unit creation timestamp.
   *
   * @return \Drupal\bat_unit\BatUnitInterface
   *   The called Unit entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Unit published status indicator.
   *
   * Unpublished Unit are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Unit is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Unit.
   *
   * @param bool $published
   *   TRUE to set this Unit to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bat_unit\BatUnitInterface
   *   The called Unit entity.
   */
  public function setPublished($published);

}
