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
  public $basisDaten;
  
  /**
   * Array mit den Kindern, die in der gleichen Wohnung wohnen, wie das Mitglied.
   * 
   * @var array
   */
  public $kindListe;
  
  /**
   * Konstruktor
   */
  public function __construct() {
    $this->$kindListe = array();
  }
  
}