<?php
/*
 * Oktober 2013, JAL
 *

 */
defined('_JEXEC') or die('Restricted access');

class GiessereiTableMembers extends JTable {
	public $id;
	public $userid = null;
	var $vorname = null;
	var $nachname = null;
	var $adresse = null;
	var $plz = null;
	var $ort = null;
	public $telefon = null;
	public $telefon_frei;
	public $handy = null;
	public $handy_frei;
	public $jahrgang;
	public $zur_person;
	public $funktion;
	public $eintritt;
	public $austritt;
	protected $email;
	protected $wohnung;
	protected $kinder;
	protected $avatar;
	protected $birthdate;
    protected $websitename;
    protected $websiteurl;
    protected $gender;	 	
	
	
	public function __construct( &$db ) {
		parent::__construct('#__mgh_mitglied', 'id', $db);
	}


	// Beim Speichern noch Anpassungen vornehmen
	public function store($updateNulls = false)
	{
		$app = JFactory::getApplication();  // für Fehlerausgabe mittels $app->close();	
		$db =& JFactory::getDBO();
		
		// Initialiase variables.
		$date = JFactory::getDate()->toMySQL();
		$userId = JFactory::getUser()->get('id');
		 
		// Wohnungen in Kreuztabelle einspeisen
		// Aufsplitten in einzelne Einträge, falls durch Komma getrennt
		$wohnungen = explode(",",$this->wohnung);
		
		if(count($wohnungen)>0):
			// Zuerst alle Einträge des Mitgliedes löschen
			$query = "DELETE FROM #__mgh_x_mitglied_mietobjekt WHERE userid=".$this->userid;
			$db->setQuery($query);
			if(!$db->query()):
				$this->setError($db->getErrorMsg());
				return false;
			endif;
			
			// dann alle neuen Mietobjekte schreiben
			foreach($wohnungen as $whg):
				if(strval($whg) > 2000 AND strval($whg) < 3000):
					$query="INSERT INTO #__mgh_x_mitglied_mietobjekt (userid,objektid) VALUES ('".$this->userid."','".$whg."')";
					$db->setQuery($query);
					if(!$db->query()):
						$this->setError($db->getErrorMsg());
						return false;

					endif;
				endif;			
			endforeach;
		endif;
				 
		// Attempt to store the data.
		return parent::store($updateNulls);
	}

}
?>
