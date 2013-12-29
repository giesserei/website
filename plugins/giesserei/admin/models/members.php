<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

/**
 * Modell stellt eine Liste von Mitglieder-Datensätzen zur Verfügung.
 *
 * Changes:
 * - Refactoring + Format + Comments (SF, 2013-12-29)
 * - Filter eingebaut (SF, 2013-12-29)
 * - Wohnung und Art der Mitgliedschaft in Liste anzeigen (SF, 2013-12-29)
 *
 * @author JAL, created on 27.12.2010
 */
class GiessereiModelMembers extends JModelList {

  /**
   * Liefert die SQL-Query zum Laden der Mitglieder.
   * Es werden die Filter berücksichtigt.
   */
  protected function getListQuery() {
    $db = $this->getDBO();
    $query = $db->getQuery(true);
    
    $query->select('mgl.*');
    
    // Mitgliederstatus
    $query->select('IF ((mgl.austritt >= NOW() OR mgl.austritt = "0000-00-00"), 1, 0) AS status');
    
    // Wohnung
    $query->select('(SELECT GROUP_CONCAT(DISTINCT o.objektid ORDER BY o.objektid DESC SEPARATOR \',\')
                     FROM #__mgh_mitglied m, #__mgh_x_mitglied_mietobjekt o
                     WHERE o.userid = mgl.userid) AS wohnung');
    
    // Art der Mitgliedschaft
    // TODO Tabelle #__mgh_mitglied um Art der Mitgliedschaft erweitern -> als Workaround über die Gruppenzuordnung gelöst
    $query->select('CASE 
        WHEN (SELECT GROUP_CONCAT(DISTINCT ug.title ORDER BY ug.title DESC SEPARATOR \',\') 
          FROM #__usergroups AS ug
    		  LEFT JOIN #__user_usergroup_map AS ugm ON ug.id = ugm.group_id
    		  WHERE ugm.user_id = mgl.userid) LIKE \'%Passivmitglied deaktiviert%\' THEN \'Passiv deaktiviert\' 
        WHEN (SELECT GROUP_CONCAT(DISTINCT ug.title ORDER BY ug.title DESC SEPARATOR \',\') 
          FROM #__usergroups AS ug
    		  LEFT JOIN #__user_usergroup_map AS ugm ON ug.id = ugm.group_id
    		  WHERE ugm.user_id = mgl.userid) LIKE \'%Passivmitglied%\' THEN \'Passiv\' 
        WHEN (SELECT GROUP_CONCAT(DISTINCT ug.title ORDER BY ug.title DESC SEPARATOR \',\') 
          FROM #__usergroups AS ug
    		  LEFT JOIN #__user_usergroup_map AS ugm ON ug.id = ugm.group_id
    		  WHERE ugm.user_id = mgl.userid) LIKE \'%Siedlungsassistenz%\' THEN \'Siedlungsassistenz\' 
        ELSE
          \'Aktiv\'
        END AS art');
    
    $query->from('#__mgh_mitglied as mgl');
    
    // Join der User-Tabelle
    $query->select('usr.email as email');
    $query->join('LEFT', '#__users AS usr ON usr.id = mgl.userid');
    
    // Join der Forum-Tabelle
    $query->select('kun.avatar as avatar');
    $query->join('LEFT', '#__kunena_users AS kun ON mgl.userid = kun.userid');
    
    // Sortierung
    $query->order('mgl.nachname ASC');
    
    // Filtern nach dem Nachnamen oder Vornamen
    $search = $this->getState('filter.search');
    if (! empty($search)) {
      $search = $db->Quote('%' . $db->getEscaped($search, true) . '%');
      $query->where('(mgl.nachname LIKE ' . $search . ' OR mgl.vorname LIKE ' . $search . ')');
    }
    
    // Filtern nach Status der Mitgliedschaft
    $status = $this->getState('filter.status');
    if (! empty($status)) {
      switch (strval($status)) {
        case 2 : // ausgetreten
          $query->where('(mgl.austritt < NOW() AND mgl.austritt != "0000-00-00")');
          break;
        case 3 : // alle
          break;
        default : // nur aktive Mitglieder
          $query->where('(mgl.austritt >= NOW() OR mgl.austritt = "0000-00-00")');
      }
    }
    else {
      // Default beim ersten Laden der Seite: Nur aktive Mitglieder
      $query->where('(mgl.austritt >= NOW() OR mgl.austritt = "0000-00-00")');
    }
    
    return $query;
  }

  /**
   * Request-Parameter in den Model-State schreiben.
   */
  protected function populateState($ordering = null, $direction = null) {
    // Initialise variables
    $app = JFactory::getApplication('administrator');
    
    // Such-Filter setzen
    $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
    $this->setState('filter.search', $search);
    
    // Status-Filter setzen
    $status = $this->getUserStateFromRequest($this->context . '.filter.status', 'filter_status');
    $this->setState('filter.status', $status);
    
    // Parameter laden
    // TODO Aus Buch kopiert -> Zweck noch nicht klar
    $params = JComponentHelper::getParams('com_giesserei');
    $this->setState('params', $params);
    // Restliche State-Parameter setzen (z.B. Page-Limit)
    parent::populateState('mgl.nachname', 'asc');
  }
}
?>
