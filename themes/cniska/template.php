<?php

/**
 * @file
 * Functions to support theming in this theme.
 */

function cniska_preprocess_html() {
	drupal_add_html_head_link(array(
		'href' => 'http://fonts.googleapis.com/css?family=Open+Sans',
		'rel' => 'stylesheet',
		'type' => 'text/css',
	));
}