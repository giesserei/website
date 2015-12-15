<?php
/*
 * Created on 05.01.2011
 *

 */
defined('_JEXEC') or die('Restricted access');

class GiessereiTableOJournalClasses extends JTable {
	public $id;
	public $code;
	public $text;
	public $farbe;
	
	public function __construct( &$db ) {
		parent::__construct('#__mgh_ojournalklasse', 'id', $db);
	}

	// Beim Speichern noch Anpassungen vornehmen
	public function store($updateNulls = false)
	{
		$db =& JFactory::getDBO();
		
		// Führender Hash abschneiden
		if(substr($this->farbe,0,1) == '#') $this->farbe = substr($this->farbe,1);
		
		// Attempt to store the data.
		return parent::store($updateNulls);
	}

}
