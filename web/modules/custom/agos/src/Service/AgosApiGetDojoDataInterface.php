<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AgosApiGetDojoDataInterface.
 */
namespace Drupal\agos\Service;

use Drupal\Core\Entity\EntityTypeManager;

interface AgosApiGetDojoDataInterface {

  /**
   * Fetches dojo data.
   *
   * @return array
   *   An array of dojo data.
   */
  public function getDojos();

}