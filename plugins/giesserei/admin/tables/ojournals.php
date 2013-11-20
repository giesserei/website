<?php
/*
 * Created on 05.01.2011
 *

 */
defined('_JEXEC') or die('Restricted access');

class GiessereiTableOJournals extends JTable {
	public $id;
	public $objektid;
	public $datum;
	public $titel;
	public $beschreibung;
	public $klasseid;
	
	public function __construct( &$db ) {
		parent::__construct('#__mgh_objektjournal', 'id', $db);
	}
	
}
?>
