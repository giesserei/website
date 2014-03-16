<?php

defined('_JEXEC') or die;

/**
 * Helperklasse für Mitglieder-Verwaltung
 * 
 * Oktober 2013, JAL
 */
class GiessereiHelper {
  
  public static function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
  }
  
}
