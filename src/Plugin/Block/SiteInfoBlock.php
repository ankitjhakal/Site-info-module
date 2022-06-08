<?php

namespace Drupal\site_location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides 'Site Info' block.
 *
 * @Block(
 *   id = "site_info",
 *   admin_label = @Translation("Site Info")
 * )
 */
class SiteInfoBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Config Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * SiteInfoBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config Factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $site_info_config = $this->configFactory->get('site_location_time.settings');
    return [
      '#theme' => 'site_info',
      '#country' => $site_info_config->get('country') ?? NULL,
      '#city' => $site_info_config->get('city') ?? NULL,
      '#attached' => [
        'library' => [
          'site_location_time/site-info',
        ],
      ],
      '#cache' => [
        'tags' => $site_info_config->getCacheTags(),
      ],
    ];
  }

}
