<?php

namespace Drupal\site_location_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Site Location configuration form class.
 */
class SiteInfoConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_location_time_config';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['site_location_time.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('site_location_time.settings');
    $form['site_info'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Site Info'),
    ];

    $form['site_info']['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country Name'),
      '#description' => $this->t('Please enter the country name here.'),
      '#default_value' => $config->get('country') ?? '',
      '#required' => TRUE,
    ];

    $form['site_info']['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Please enter the city name here.'),
      '#default_value' => $config->get('city') ?? '',
      '#required' => TRUE,
    ];

    $form['site_info']['timezone'] = [
      '#type' => 'select',
      '#options' => [
        '' => $this->t('Select'),
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London'),
      ],
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Please select the timezone'),
      '#default_value' => $config->get('timezone') ?? '',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('site_location_time.settings');
    // Fetch and store the form values.
    $config->set('country', $form_state->getValue('country'));
    $config->set('city', $form_state->getValue('city'));
    $config->set('timezone', $form_state->getValue('timezone'));
    $config->save();

    return parent::submitForm($form, $form_state);
  }

}
