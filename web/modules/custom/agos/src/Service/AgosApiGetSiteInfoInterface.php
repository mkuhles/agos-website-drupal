<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AgosApiGetSiteInfoInterface.
 */
namespace Drupal\agos\Service;

interface AgosApiGetSiteInfoInterface {

  /**
   * Fetches site information.
   *
   * @return array
   *   An array of site information.
   */
  public function getSiteInfo();

}
