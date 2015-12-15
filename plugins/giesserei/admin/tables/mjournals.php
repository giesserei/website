<?php
/*
 * Created on 05.01.2011
 *

 */
defined('_JEXEC') or die('Restricted access');

class GiessereiTableMJournals extends JTable {
	public $id;
	public $userid;
	public $datum;
	public $beschreibung;
	public $klasseid;
	
	public function __construct( &$db ) {
		parent::__construct('#__mgh_mitgliederjournal', 'id', $db);
	}
	
}
