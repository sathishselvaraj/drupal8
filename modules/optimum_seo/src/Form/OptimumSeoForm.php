<?php

namespace Drupal\optimum_seo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
class OptimumSeoForm extends ConfigFormBase {

public function getEditableConfigNames() {
return 'optimum_seo_editable_config_names';
}

public function getFormId() {

return 'optimum_seo_form';
}

  public function buildForm(array $form, FormStateInterface $form_state) {
// content types
  $form['seo_content_types_list'] = array(
    '#type' => 'details',
    '#title' => t('Optimum SEO enable/disable per content type'),
    '#open' => TRUE,
    '#description' => t('Enable the Optimum SEO for at least one content type. Otherwise you will not see any effect.'),
  );
    // Get the config object.
    $config = \Drupal::configFactory()->getEditable('optimum_seo.settings');

    // Get the list of content types
    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();

    $node_type_titles = array();
    foreach ($node_types as $machine_name => $val) {
      $node_type_titles[$machine_name] = $val->label();
    }

    $form['seo_content_types_list']['seo_content_types'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Node Types'),
      '#options' => $node_type_titles,
      '#default_value' => $config->get('optimum_seo.seo_content_types'),
    );

return parent::buildForm($form, $form_state);

}

/**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the config object.
	$config = \Drupal::configFactory()->getEditable('optimum_seo.settings');

  $config->set('optimum_seo.seo_content_types', $form_state->getValue('seo_content_types'));
  $config->save();
   parent::submitForm($form, $form_state);
  }

}
