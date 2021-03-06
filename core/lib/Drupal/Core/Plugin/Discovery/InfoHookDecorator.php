<?php

/**
 * @file
 * Contains Drupal\Core\Plugin\Discovery\InfoHookDecorator.
 */

namespace Drupal\Core\Plugin\Discovery;

use Drupal\Component\Plugin\Discovery\DiscoveryInterface;

/**
 * Allows info hook implementations to enhance discovered plugin definitions.
 */
class InfoHookDecorator implements DiscoveryInterface {

  /**
   * The Discovery object being decorated.
   *
   * @var Drupal\Component\Plugin\Discovery\DiscoveryInterface
   */
  protected $decorated;

  /**
   * The name of the info hook that will be implemented by this discovery instance.
   *
   * @var string
   */
  protected $hook;

  /**
   * Constructs a InfoHookDecorator object.
   *
   * @param Drupal\Component\Plugin\Discovery\DiscoveryInterface $decorated
   *   The object implementing DiscoveryInterface that is being decorated.
   * @param string $hook
   *   The name of the info hook to be invoked by this discovery instance.
   */
  public function __construct(DiscoveryInterface $decorated, $hook) {
    $this->decorated = $decorated;
    $this->hook = $hook;
  }

  /**
   * Implements Drupal\Component\Plugin\Discovery\DiscoveryInterface::getDefinition().
   */
  public function getDefinition($plugin_id) {
    $definitions = $this->getDefinitions();
    return isset($definitions[$plugin_id]) ? $definitions[$plugin_id] : NULL;
  }

  /**
   * Implements Drupal\Component\Plugin\Discovery\DiscoveryInterface::getDefinitions().
   */
  public function getDefinitions() {
    $definitions = $this->decorated->getDefinitions();
    foreach (module_implements($this->hook) as $module) {
      $function = $module . '_' . $this->hook;
      $function($definitions);
    }
    return $definitions;
  }

  /**
   * Passes through all unknown calls onto the decorated object.
   */
  public function __call($method, $args) {
    return call_user_func_array(array($this->decorated, $method), $args);
  }

}
