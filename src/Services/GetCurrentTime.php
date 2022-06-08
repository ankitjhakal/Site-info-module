<?php

namespace Drupal\site_location_time\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Helper class to get current time.
 *
 * @package Drupal\site_location_time\Services
 */
class GetCurrentTime {

  /**
   * Config Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * SiteLocationHelper constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config Factory service object.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Returns the current time that is stored in config.
   *
   * @return string|null
   *   Returns time if timezone if available else NULL.
   */
  public function getTimeBasedOnTimeZone() {
    $time_zone = $this->configFactory->get('site_location_time.settings')->get('timezone');
    $data = NULL;
    // Proceed only if timezone is available.
    if ($time_zone) {
      $date_time = new \DateTime();
      $date_time->setTimezone(new \DateTimeZone($time_zone));
      $data = [
        'time' => $date_time->format('jS M Y - g:i A'),
      ];
    }

    return new JsonResponse($data);
  }

}
