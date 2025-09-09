<?php
/**
 * @file
 * Contains \Drupal\agos\Controller\AgosApiController.
 */
namespace Drupal\agos\Service;

use Drupal\ckeditor5\Plugin\CKEditor5Plugin\Media;
use Drupal\Component\Utility\Image;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

class AgosApiGetDojoData implements AgosApiGetDojoDataInterface {

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

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $entityTypeManager = $entityTypeManager;
    $this->fileStorage = $entityTypeManager->getStorage('file');
    $this->nodeStorage = $entityTypeManager->getStorage('node');
  }

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
      
      /** @var \Drupal\file\FileInterface $image */
      $image = $this->fileStorage->load($dojo->field_image->target_id);
      
      if ($image) {
        $imageUri = $image->getFileUri();
        $styleImgUri = ImageStyle::load('dojologo')->buildUrl($imageUri);
      }
      else {
        $styleImgUri = '';
      }
      $data[] = [
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