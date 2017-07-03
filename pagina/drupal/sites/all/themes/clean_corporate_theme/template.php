<?php
/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 *
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "adaptivetheme_subtheme" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "adaptivetheme_subtheme".
 * 2. Uncomment the required function to use.
 */

/**
 * Override or insert variables for the html templates.
 */
function clean_corporate_theme_preprocess_html(&$vars) {
  $meta_ie_render_engine = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'content' => 'IE=edge,chrome=1',
      'http-equiv' => 'X-UA-Compatible',
    ),
  );
  // Add header meta tag for IE to head.
  drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');

  // Check if adaptive theme installed.
  $themes_list = list_themes();
  $adaptivetheme_installed = FALSE;
  global $theme_key;
  foreach ($themes_list as $theme) {
    if ($theme->name == 'adaptivetheme') {
      $adaptivetheme_installed = TRUE;
    }
    elseif ($theme->name == $theme_key) {
      $current_theme_name = $theme->info['name'];
    }
  }

  if (!$adaptivetheme_installed) {
    $substitution_array = array(
      '@current_theme' => $current_theme_name,
      '!link' => l('Adaptive Theme', 'https://www.drupal.org/project/adaptivetheme'),
    );
    $adaptivetheme_not_installed_message = t('If you see this message, most probably you did not install !link which is the requirement for @current_theme. You\'ll need to install it in order to get properly working theme.', $substitution_array);
    drupal_set_message($adaptivetheme_not_installed_message, 'warning');
  }
}
