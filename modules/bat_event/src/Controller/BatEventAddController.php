<?php

namespace Drupal\bat_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class BatEventAddController.
 *
 * @package Drupal\bat_event\Controller
 */
class BatEventAddController extends ControllerBase {

    public function __construct(EntityStorageInterface $storage, EntityStorageInterface $type_storage) {
      $this->storage = $storage;
      $this->typeStorage = $type_storage;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
      /** @var EntityTypeManagerInterface $entity_type_manager */
      $entity_type_manager = $container->get('entity_type.manager');
      return new static(
        $entity_type_manager->getStorage('bat_event'),
        $entity_type_manager->getStorage('bat_event_type')
      );
    }
    /**
     * Displays add links for available bundles/types for entity bat_event .
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A render array for a list of the bat_event bundles/types that can be added or
     *   if there is only one type/bunlde defined for the site, the function returns the add page for that bundle/type.
     */
    public function add(Request $request) {
      $types = $this->typeStorage->loadMultiple();
      if ($types && count($types) == 1) {
        $type = reset($types);
        return $this->addForm($type, $request);
      }
      if (count($types) === 0) {
        return array(
          '#markup' => $this->t('You have not created any %bundle types yet. @link to add a new type.', [
            '%bundle' => 'Events',
            '@link' => $this->l($this->t('Go to the type creation page'), Url::fromRoute('entity.bat_event_type.add_form')),
          ]),
        );
      }
      return array('#theme' => 'bat_event_content_add_list', '#content' => $types);
    }

    /**
     * Presents the creation form for bat_event entities of given bundle/type.
     *
     * @param EntityInterface $bat_event_type
     *   The custom bundle to add.
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A form array as expected by drupal_render().
     */
    public function addForm(EntityInterface $bat_event_type, Request $request) {
      $entity = $this->storage->create(array(
        'type' => $bat_event_type->id()
      ));
      return $this->entityFormBuilder()->getForm($entity);
    }

    /**
     * Provides the page title for this controller.
     *
     * @param EntityInterface $bat_event_type
     *   The custom bundle/type being added.
     *
     * @return string
     *   The page title.
     */
    public function getAddFormTitle(EntityInterface $bat_event_type) {
      return t('Create of bundle @label',
        array('@label' => $bat_event_type->label())
      );
    }

}
