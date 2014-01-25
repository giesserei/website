<?php
defined('_JEXEC') or die('Restricted access');

/**
 * Enthält die Profildaten eines Mitglieds, die im Profil angezeigt und bearbeitet werden können.
 * 
 * @author Steffen Förster
 */
class ProfilData extends JObject {
  
  /**
   * Basisdaten des Mitglieds.
   * 
   * @var JObject
   */
  public $basisDaten = null;
  
  /**
   * Array mit den Kindern, die in der gleichen Wohnung wohnen, wie das Mitglied.
   * 
   * @var array
   */
  public $kindListe = array();
  
  /**
   * Konstruktor
   */
  public function __construct() {
  }
  
}