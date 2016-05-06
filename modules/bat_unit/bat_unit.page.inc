<?php

/**
 * @file
 * Contains bat_unit.page.inc.
 *
 * Page callback for Unit entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Unit templates.
 *
 * Default template: bat_unit.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_bat_unit(array &$variables) {
  // Fetch BatUnit Entity Object.
  $bat_unit = $variables['elements']['#bat_unit'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

/**
* Prepares variables for a custom entity type creation list templates.
*
* Default template: bat_unit-content-add-list.html.twig.
*
* @param array $variables
*   An associative array containing:
*   - content: An array of bat_unit-types.
*
* @see block_content_add_page()
*/
function template_preprocess_bat_unit_content_add_list(&$variables) {
  $variables['types'] = array();
  $query = \Drupal::request()->query->all();
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => Link::fromTextAndUrl($type->label(), new Url('entity.bat_unit.add_form', array(
        'bat_unit_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
}
