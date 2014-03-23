<?php
/**
 * Utility functions
 */
function add_filters($tags, $function) {
  foreach($tags as $tag) {
    add_filter($tag, $function);
  }
}

function is_element_empty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}

/**
 * Compare url against relative url. Returns boolean.
 */
function roots_url_compare($url, $rel) {
  $url = trailingslashit($url);
  $rel = trailingslashit($rel);

  if ((strcasecmp($url, $rel) === 0) || roots_root_relative_url($url) == $rel) { 
    return true; 
  } else {
    return false;
  }
}
