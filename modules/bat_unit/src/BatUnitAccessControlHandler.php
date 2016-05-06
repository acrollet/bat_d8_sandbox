<?php

namespace Drupal\bat_unit;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Unit entity.
 *
 * @see \Drupal\bat_unit\Entity\BatUnit.
 */
class BatUnitAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bat_unit\BatUnitInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished unit entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published unit entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit unit entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete unit entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add unit entities');
  }

}
