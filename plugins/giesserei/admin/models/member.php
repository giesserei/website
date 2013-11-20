<?php
/*
 * Created on Oktober 2013, JAL
 * 
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class GiessereiModelMember extends JModelAdmin {

	public function getTable($type="Members",$prefix="GiessereiTable",$config=array()) {
		return JTable::getInstance($type,$prefix,$config);
	}
	
	public function getForm($data = array(), $loadData = true) {
		$options = array('control' => 'jform', 'load_data' => $loadData);
		$form = $this->loadForm('members','member',$options);
		
		if(empty($form)) {
			return(false);
		}
		return $form;
	}

    public function getItem($pk=null) {
		$app = JFactory::getApplication();  // für Fehlerausgabe mittels $app->close();	
    	
	    $db =& JFactory::getDBO();
    	$item = parent::getItem();
    	    	
    	// E-Mailadresse zuweisen
		$query = "SELECT * FROM #__users WHERE id=".$item->userid;
    	$db->setQuery($query);
	    $rows = $db->loadObjectList();
	    
	    if($db->getAffectedRows() > 0):
    		$item->email = $rows[0]->email;
		endif;
				
	    // Gruppenzugehörigkeit auslesen
	    $query = "SELECT * FROM #__mgh_bereich AS mbe 
    		LEFT JOIN #__usergroups AS ug ON mbe.grp_id = ug.id
    		LEFT JOIN #__user_usergroup_map AS xug ON ug.id = xug.group_id
    		WHERE xug.user_id=".$item->userid." ORDER BY ordering";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
		
	    $item->gruppen = "";	
	    if($db->getAffectedRows() > 0) foreach($rows as $gr):
	    	$item->gruppen .= $gr->title;
	    	if($gr != end($rows)) $item->gruppen .= ", ";
	    endforeach;
	    
	    
	
		// Gibt es für das Mitglied $userid einen oder mehrere Mietverträge?
		
    	$query = "SELECT * FROM #__mgh_x_mitglied_mietobjekt WHERE userid='".$item->userid."'";
    	$db->setQuery($query);
	    $rows = $db->loadObjectList();
	    
	    $item->wohnung = "";
	    if($db->getAffectedRows() > 0) foreach($rows as $whg):
	    	$item->wohnung .= $whg->objektid;
	    	if($whg != end($rows)) $item->wohnung .= ", ";
	
		    // Sind Kinder in dieser Wohnung?
		    $query = "SELECT * FROM #__mgh_kind WHERE objektid=".$whg->objektid;
	    	$db->setQuery($query);
		    $krows = $db->loadObjectList();
		    if($db->getAffectedRows() > 0) foreach($krows as $kind):
		    	$link = "/administrator/index.php?option=com_giesserei&task=kid.edit&id=".$kind->id;
		    	$item->kinder .= "<a href=\"".$link."\">".$kind->vorname."</a>";
		    	if($kind != end($krows)) $item->kinder .= ", ";
		    endforeach;
		    
	    endforeach;  
	     
	    
	    // Avatar, Geburi etc. von Kunena auslesen

    	$query = "SELECT * FROM #__kunena_users WHERE userid='".$item->userid."'";
    	$db->setQuery($query);
	    $rows = $db->loadObjectList();
	    
	    if($db->getAffectedRows() > 0):
	    	 $item->avatar = $rows[0]->avatar;
	    	 $item->birthdate = $rows[0]->birthdate;
	    	 $item->websitename = $rows[0]->websitename;
	    	 $item->websiteurl = $rows[0]->websiteurl;
	    	 $item->gender = $rows[0]->gender;
	 	else:
	    endif;
	    
	    
		return $item;
    }
	
	protected function loadFormData() {
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_giesserei.edit.Member.data',array());
		
		if(empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}

	public function getJournal() {
		$data=$this->loadFormData();
		$db =& JFactory::getDBO();

		$query = "SELECT *,mj.id as id FROM #__mgh_mitgliederjournal as mj,#__mgh_mjournalklasse as jk WHERE mj.klasseid=jk.id AND userid=".$data->userid." ORDER BY datum";
    	$db->setQuery($query);
	    $rows = $db->loadObjectList();
		return($rows);
				
	}
}
?>
