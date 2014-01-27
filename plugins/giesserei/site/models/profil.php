<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiFrontendHelper', JPATH_COMPONENT . '/helpers/giesserei_frontend.php');
JLoader::register('ProfilData', JPATH_COMPONENT . '/models/data/profil_data.php');

jimport('joomla.application.component.model');

/**
 * Modellklasse für die Bearbeitung des Benutzerprofils.
 *
 * @author Steffen Förster
 */
class GiessereiModelProfil extends JModel {
  
  private $db;
  
  private $user;
  
  private $hasObjekt;
  
  public function __construct() {
    parent::__construct();
    $this->db = JFactory::getDBO();
    $this->user = JFactory::getUser();
  }
  
  /**
   * Liefert die Profildaten des aktuellen Mitglieds.
   * 
   * @return ProfilData 
   */
  public function getProfilData() {
    $profilData = new ProfilData();
    
    $query = 'SELECT mgl.*, usr.email as email FROM #__mgh_mitglied as mgl
		    	LEFT JOIN #__users AS usr ON mgl.userid = usr.id
		    	WHERE mgl.userid=' . $this->user->id;
    $this->db->setQuery($query);
    $profilData->basisDaten = $this->db->loadObject();
        
    $this->addKunenaProperties($profilData);
    $this->hasObjekt = $this->hasObjekt();
    $this->addWohnung($profilData);
    $this->addKinder($profilData);
    
    return $profilData;
  }
  
  // -------------------------------------------------------------------------
  // private section
  // -------------------------------------------------------------------------
  
  /**
   * Fügt dem übergebenen Profil die Kunena-Daten hinzu.
   */
  private function addKunenaProperties(&$profilData) {
    // Default setzen, falls kein Kunena-Eintrag für den User vorhanden ist
    $profilData->basisDaten->birthdate = '0001-01-01';
    $profilData->basisDaten->avatar = 'nophoto.jpg';
    
    $query = 'SELECT k.birthdate, k.avatar FROM #__kunena_users AS k WHERE k.userid=' . $this->user->id;
    $this->db->setQuery($query);
    $row = $this->db->loadObject();
    
    if (!empty($row)) {
      if (!empty($row->birthdate)) {
        $profilData->basisDaten->birthdate = $row->birthdate;
      }
      if (!empty($row->avatar)) {
        $profilData->basisDaten->avatar = $row->avatar;
      }
    }
    
  }
  
  /**
   * Fügt dem übergebenen Profil die gemietete Wohnung hinzu.
   */
  private function addWohnung(&$profilData) {
    if ($this->hasObjekt) {
      $query = 'SELECT GROUP_CONCAT(DISTINCT o.objektid ORDER BY o.objektid DESC SEPARATOR \',\') AS wohnung
                FROM #__mgh_x_mitglied_mietobjekt o
                WHERE o.userid = ' . $this->user->id;
      $this->db->setQuery($query);
      $row = $this->db->loadObject();
      $profilData->basisDaten->wohnung = $row->wohnung;
    }
    else {
      $profilData->basisDaten->wohnung = '';
    }
  }
  
  /**
   * Liefert true, wenn dem Benutzer eine Wohnung zugewiesen wurde.
   */
  private function hasObjekt() {
    $query = 'SELECT count(*) AS anzahl FROM #__mgh_x_mitglied_mietobjekt o
              WHERE o.userid = ' . $this->user->id;
    $this->db->setQuery($query);
    $row = $this->db->loadObject();
    return !empty($row);
  }
  
  /**
   * Fügt alle vorhandenen Kinder dem Profil hinzu.
   */
  private function addKinder(&$profilData) {
    if ($this->hasObjekt) {
      $query = 'SELECT k.* FROM #__mgh_x_mitglied_mietobjekt o JOIN #__mgh_kind k ON o.objektid = k.objektid
                WHERE o.userid = ' . $this->user->id;
      $this->db->setQuery($query);
      $rows = $this->db->loadObjectList();
      if (!empty($rows)) {
        $profilData->kindListe = $rows;
      }
    }
  }
  
}
?>