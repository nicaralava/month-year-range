<?php

namespace Drupal\month_year_range\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\datetime_range\Plugin\Field\FieldWidget\DateRangeDatelistWidget;

/**
 * Plugin implementation of the 'month_year_range' widget.
 *
 * @FieldWidget(
 *   id = "month_year_range",
 *   label = @Translation("Month Year range"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class MonthYearRangeWidget extends DateRangeDatelistWidget implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $date_order = $this->getSetting('date_order');
    // Set up the date part order array.
    switch ($date_order) {
      default:
      case 'YM':
        $date_part_order = ['year', 'month'];
        break;
      case 'MY':
        $date_part_order = ['month', 'year'];
        break;
      case 'Y':
        $date_part_order = ['year'];
        break;
    }
    $element['value'] = [
        '#type' => 'datelist',
        '#date_part_order' => $date_part_order,
      ] + $element['value'];
    $element['end_value'] = [
        '#type' => 'datelist',
        '#date_part_order' => $date_part_order,
        '#required' => false,
      ] + $element['end_value'];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::settingsForm($form, $form_state);
    $element['date_order'] = [
      '#type' => 'select',
      '#title' => $this->t('Date part order'),
      '#default_value' => $this->getSetting('date_order'),
      '#options' => [
        'YM' => $this->t('Year/Month'),
        'MY' => $this->t('Month/Year'),
        'Y' => $this->t('Year'),
      ],
    ];
    return $element;
  }
}
