<?php

namespace Drupal\bat_event\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Events entities.
 */
class BatEventViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['bat_event']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Events'),
      'help' => $this->t('The Events ID.'),
    );

    return $data;
  }

}
