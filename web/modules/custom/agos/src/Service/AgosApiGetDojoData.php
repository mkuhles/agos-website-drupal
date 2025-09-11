<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AgosApiGetDojoData.
 */
namespace Drupal\agos\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\image\Entity\ImageStyle;

class AgosApiGetDojoData extends AbstractAgosApiGetData implements AgosApiGetDojoDataInterface {

  /**
   * The file storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $fileStorage;

  /**
   * The node storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeStorage;

  /**
   * Fetches dojo data.
   *
   * @return array
   *   An array of dojo data.
   */
  public function getDojos() {
    if (!$this->nodeStorage || !$this->fileStorage) {
      return [];
    }
    $nids = $this->nodeStorage->getQuery()
      ->condition('type', 'dojo')
      ->accessCheck(FALSE)
      ->execute();

    $dojos = $this->nodeStorage->loadMultiple($nids);
    $data = [];


    /** @var \Drupal\node\NodeInterface $dojo */
    foreach ($dojos as $dojo) {
      if (!$dojo) {
        continue;
      }
      
      $styleImgUri = $this->getImageStyleUrl($dojo->field_image->target_id, 'dojologo');
      
      $data[] = [
        'id' => "dojo_" . $dojo->id(),
        'name' => $dojo->getTitle(),
        'location' => $dojo->field_location->value,
        'description' => $dojo->field_description->value,
        'facebook' => $dojo->field_facebook->uri ?? '',
        'gmaps' => $dojo->field_gmaps->uri ?? '',
        'logo' => $styleImgUri,
      ];
    }

    return $data;
  }

}