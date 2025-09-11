<?php
 
 namespace Drupal\agos\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\ConfigFormBase;
 use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;

 /**
  * Configure Agos settings for this site.
  */
class AgosSettingsForm extends ConfigFormBase {
  const CONFIG_NAME = 'agos.settings';

  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface */
  protected $entityTypeManager;

  public static function create(ContainerInterface $container) {
    /** @var static $instance */
    $instance = parent::create($container);
    $instance->entityTypeManager = $container->get('entity_type.manager');
    return $instance;
  }

   /**
    * {@inheritdoc}
    */
   protected function getEditableConfigNames() {
     return [self::CONFIG_NAME];
   }
 
   /**
    * {@inheritdoc}
    */
   public function getFormId() {
     return 'agos_settings_form';
   }
 
   /**
    * {@inheritdoc}
    */
   public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(self::CONFIG_NAME);
    $default_nid = $config->get('siteInfoNodeId');

    $default_node = NULL;
    if ($default_nid) {
      $default_node = $this->entityTypeManager->getStorage('node')->load($default_nid);
    }

    $form['siteInfoNodeId'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Site info node'),
      '#description' => $this->t('Select the node that provides the site info content.'),
      '#target_type' => 'node',
      // Optional: auf einen Bundle einschränken, z.B. "article"
      '#selection_settings' => [
        'target_bundles' => ['article'],
      ],
      '#default_value' => $default_node instanceof NodeInterface ? $default_node : NULL,
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
   }
 
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $nid = (int) $form_state->getValue('siteInfoNodeId');
    if ($nid <= 0) {
      $form_state->setErrorByName('siteInfoNodeId', $this->t('Please select a valid node.'));
      return;
    }
    /** @var \Drupal\node\NodeInterface|null $node */
    $node = $this->entityTypeManager->getStorage('node')->load($nid);
    if (!$node instanceof NodeInterface) {
      $form_state->setErrorByName('siteInfoNodeId', $this->t('The selected node does not exist.'));
    }
    // Optional: Bundle absichern
    elseif ($node->bundle() !== 'article') {
      $form_state->setErrorByName('siteInfoNodeId', $this->t('Please choose a node of type "article".'));
    }
  }

   /**
    * {@inheritdoc}
    */
   public function submitForm(array &$form, FormStateInterface $form_state) {
     $this->config('agos.settings')
       ->set('siteInfoNodeId', $form_state->getValue('site_info_node_id'))
       ->save();
 
     parent::submitForm($form, $form_state);
   }
 
 }