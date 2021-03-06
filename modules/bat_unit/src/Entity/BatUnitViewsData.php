<?php

namespace Drupal\bat_unit\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Unit entities.
 */
class BatUnitViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['bat_unit']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Unit'),
      'help' => $this->t('The Unit ID.'),
    );

    return $data;
  }

}
