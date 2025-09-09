<?php
/**
 * @file
 * Contains \Drupal\agos\Controller\AgosApiController.
 */
namespace Drupal\agos\Controller;

use Drupal\agos_api\Service\AgosApiGetDojoData;
use Symfony\Component\HttpFoundation\Response;

class AgosApiController extends \Drupal\Core\Controller\ControllerBase {
  public function dojos() {
    $data = \Drupal::getContainer()
      ->get("agos.get_dojo_data")
      ->getDojos();

    return new Response(
      json_encode($data, JSON_UNESCAPED_UNICODE),
      Response::HTTP_OK,
      [
        'Content-Type' => 'application/json',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
        'Access-Control-Allow-Headers' => 'x-csrf-token, authorization, content-type, accept, origin, x-requested-with, access-control-allow-origin'
      ],
    );
  }
}