<?php
/**
 * @file
 * Contains \Drupal\agos\Controller\AgosApiController.
 */
namespace Drupal\agos\Controller;

use Symfony\Component\HttpFoundation\Response;

class AgosApiController extends \Drupal\Core\Controller\ControllerBase {
  
  
  public function dojos() {
    $data = \Drupal::getContainer()
      ->get("agos.get_dojo_data")
      ->getDojos();

    return new Response(
      json_encode($data, JSON_UNESCAPED_UNICODE),
      Response::HTTP_OK,
      $this->getResponseHeaders(),
    );
  }

  public function site() {
    $data = \Drupal::getContainer()
      ->get("agos.get_site_info")
      ->getSiteInfo();

    return new Response(
      json_encode($data, JSON_UNESCAPED_UNICODE),
      Response::HTTP_OK,
      $this->getResponseHeaders(),
    );
  }

  
  /**
   * Helper method to return response headers.
   */
  private function getResponseHeaders(): array {
    return [
      'Content-Type' => 'application/json',
      'Access-Control-Allow-Origin' => '*',
      'Access-Control-Allow-Methods' => 'GET',
      // 'Access-Control-Allow-Headers' => 'x-csrf-token, authorization, content-type, accept, origin, x-requested-with, access-control-allow-origin'
    ];
  }
}