<?php
/**
 * @file
 * Contains \Drupal\agos\Service\AgosApiGetSiteInfo.
 */
namespace Drupal\agos\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

class AgosApiGetSiteInfo extends AbstractAgosApiGetData implements AgosApiGetSiteInfoInterface {
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  public function __construct(EntityTypeManagerInterface $entityTypeManager, ConfigFactoryInterface $configFactory) {
    parent::__construct($entityTypeManager);
    $this->configFactory = $configFactory;
  }
  
  /**
   * Fetches site info data.
   *
   * @return array
   *   An array of site info data.
   */
  public function getSiteInfo() {
    $siteInfoNodeId = $this->configFactory->get('agos.settings')->get('siteInfoNodeId');
    
    if (!$siteInfoNodeId) {
      return [];
    }
    
    $siteInfoNode = \Drupal::entityTypeManager()->getStorage('node')->load($siteInfoNodeId);
    if (!$siteInfoNode) {
      return [];
    }

    if($siteInfoNode instanceof Node) {
      $data = [
        'title' => $siteInfoNode->getTitle(),
        'body' => $siteInfoNode->get('body')->value,
        'logo' => $this->getImageStyleUrl($siteInfoNode->field_image->target_id, 'large') ?? '',
      ];
    }
    return $data;
  }

}