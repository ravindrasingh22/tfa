<?php
/**
 * @file
 * Contains Drupal\tfa\TfaValidationPluginManager.
 */

namespace Drupal\tfa;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;


class TfaValidationPluginManager extends DefaultPluginManager {


  protected $tfaSettings;

  /**
   * Constructs a new TfaValidation plugin manager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, ConfigFactoryInterface $config_factory) {
    parent::__construct('Plugin/TfaValidation', $namespaces, $module_handler, 'Drupal\tfa\Plugin\TfaValidationInterface', 'Drupal\tfa\Annotation\TfaValidation');
    $this->alterInfo('tfa_validation');
    $this->setCacheBackend($cache_backend, 'tfa_validation');
    $this->tfaSettings = $config_factory->get('tfa.settings');
  }

  /**
   * Create an instance of a plugin.
   * @param string $plugin_id
   * @param array $configuration
   * @return object
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    return parent::createInstance($plugin_id, $configuration); // TODO: Change the autogenerated stub
  }

  /**
   *
   * Options here should be what we need to send in - ie. Account.
   * The plugin manager should handle determining what plugin is required.
   *
   * @param array $options
   * @return false|object
   */
  public function getInstance(array $options) {
    $validate_plugin = 'broken';
    // Add validate.
    //@TODO Fix this to allow for a single validation to be selected.
    $validate = $this->tfaSettings->get('validate_plugins');
    foreach ($validate as $key => $value) {
        $validate_plugin = $key;
      }

    return $this->createInstance($validate_plugin, $options);



  }


}
