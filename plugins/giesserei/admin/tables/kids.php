<?php
/*
 * Created on 05.01.2011
 *

 */
defined('_JEXEC') or die('Restricted access');

class GiessereiTableKids extends JTable {
	public $id;
	public $vorname;
	public $nachname;
	public $jahrgang;
	public $handy;
	public $objektid;
	
	public function __construct( &$db ) {
		parent::__construct('#__mgh_kind', 'id', $db);
	}
}
?>
