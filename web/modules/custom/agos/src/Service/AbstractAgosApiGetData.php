<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AbstractAgosApiGetData.
 */
namespace Drupal\agos\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;

abstract class AbstractAgosApiGetData {

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
   * The image style storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $imageStyleStorage;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $entityTypeManager = $entityTypeManager;
    $this->fileStorage = $entityTypeManager->getStorage('file');
    $this->nodeStorage = $entityTypeManager->getStorage('node');
    $this->imageStyleStorage = $entityTypeManager->getStorage('image_style');
    
  }
    
  protected function getImageStyleUrl($fid, $style_name) {
    if (!$this->fileStorage || !$this->imageStyleStorage) {
        return NULL;
    }
    
    if (!$fid || !$style_name) {
        return NULL;
    }

    $file = $this->fileStorage->load($fid);
    if ($file && $file instanceof \Drupal\file\FileInterface) {
        $uri = $file->getFileUri();
        $style = $this->imageStyleStorage->load($style_name);
        if ($style && $style instanceof \Drupal\image\Entity\ImageStyle) {
            return $style->buildUrl($uri);
        }
    }
    return NULL;
  }
}