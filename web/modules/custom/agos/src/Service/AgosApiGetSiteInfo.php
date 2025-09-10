<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AgosApiGetSiteInfo.
 */
namespace Drupal\agos\Service;

class AgosApiGetSiteInfo implements AgosApiGetSiteInfoInterface {

  /**
   * Fetches site information.
   *
   * @return array
   *   An array of site information.
   */
  public function getSiteInfo() {
    // Example static data; replace with dynamic data retrieval as needed.
    $data = [
      'title' => \Drupal::config('system.site')->get('name'),
    //   'site_slogan' => \Drupal::config('system.site')->get('slogan'),
    //   'site_email' => \Drupal::config('system.site')->get('mail'),
    //   'front_page' => \Drupal::url('<front>', [], ['absolute' => TRUE]),
    ];

    return $data;
  }

}