<?php

use Drupal\Core\Template\Attribute;

/**
 * @file
 * Functions to support theming in this theme.
 */

function cniska_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  switch($element['#theme']) {
    // Set rel="nofollow" for the "follow me" menu items.
    case 'menu_link__menu_follow':
      $element['#attributes']['rel'] = 'nofollow';
      break;
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . new Attribute($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}