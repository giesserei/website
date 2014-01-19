<?php
defined('_JEXEC') or die('Restricted access');

/**
 * Tabellenklasse für die Tabelle #__mgh_kind.
 * 
 * @author JAL
 * @author Steffen Förster
 */
class GiessereiTableKids extends JTable {
  
	public $id;
	public $vorname;
	public $nachname;
	public $name_frei;
	public $jahrgang;
	public $jahrgang_frei;
	public $handy;
	public $handy_frei;
	public $objektid;
	
	public function __construct(&$db) {
		parent::__construct('#__mgh_kind', 'id', $db);
	}
}
?>
