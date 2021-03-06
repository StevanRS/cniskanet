<?php

/**
 * @file
 * Definition of Drupal\views_test_data\Plugin\views\argument_default\ArgumentDefaultTest.
 */

namespace Drupal\views_test_data\Plugin\views\argument_default;

use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use Drupal\Core\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;

/**
 * Defines a argument default test plugin.
 *
 * @Plugin(
 *   id = "argument_default_test",
 *   title = @Translation("Argument default test")
 * )
 */
class ArgumentDefaultTest extends ArgumentDefaultPluginBase {

  /**
   * Overrides Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase::defineOptions().
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['value'] = array('default' => '');

    return $options;
  }

  /**
   * Overrides Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase::get_argument().
   */
  public function get_argument() {
    return $this->options['value'];
  }

}
