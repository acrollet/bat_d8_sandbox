<?php

namespace Drupal\bat_event;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Events entities.
 *
 * @ingroup bat_event
 */
interface BatEventInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Events type.
   *
   * @return string
   *   The Events type.
   */
  public function getType();

  /**
   * Gets the Events name.
   *
   * @return string
   *   Name of the Events.
   */
  public function getName();

  /**
   * Sets the Events name.
   *
   * @param string $name
   *   The Events name.
   *
   * @return \Drupal\bat_event\BatEventInterface
   *   The called Events entity.
   */
  public function setName($name);

  /**
   * Gets the Events creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Events.
   */
  public function getCreatedTime();

  /**
   * Sets the Events creation timestamp.
   *
   * @param int $timestamp
   *   The Events creation timestamp.
   *
   * @return \Drupal\bat_event\BatEventInterface
   *   The called Events entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Events published status indicator.
   *
   * Unpublished Events are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Events is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Events.
   *
   * @param bool $published
   *   TRUE to set this Events to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bat_event\BatEventInterface
   *   The called Events entity.
   */
  public function setPublished($published);

}
