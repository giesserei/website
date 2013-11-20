<?php
/*
 * com_mitglied:View Hausliste
 * Zeigt eine Liste der Häuser mit ihren BewohnerInnen an
 * 
 * Jürg Altwegg, Hausverein Giesserei
 * 
 */

defined('_JEXEC') or die('Restricted access');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base.'/components/com_giesserei/template/giesserei_default.css');

require_once(JPATH_SITE.DS."components".DS."com_giesserei".DS."models".DS."mitgliederliste.php");
$listen_model = new GiessereiModelMitgliederliste; // Referenz auf Modell für Methoden des Objekts


// Benutzer angemeldet?
$user =& JFactory::getUser();
if(!$user->id > 0):
	echo "Die Registrierung ist abglaufen. Bitte neu anmelden.";
	exit();
endif;

// AJAX-Tools laden
JHTML::_('behavior.mootools');
JHTML::_('behavior.modal');

?>

<p style="border-style:solid; border-color:red; border-width:1px; padding:5px;">Diese Mitgliederliste darf nur für <strong>persönliche</strong> Zwecke verwendet werden. Die Nutzung für <strong>Sammelversände, Umfragen, Newsletter und ähnliches ist explizit dem Vorstand des Vereins Mehrgenerationenhaus vorbehalten</strong>. Jeglicher Missbrauch wird zivilrechtlich geahndet.</p>

<p><em>Um die Details eines Mitglieds anzuzeigen, auf den Namen klicken!</em></p>

<div class="links">

<?php

$vorgaenger = "";
$haus = array(1 => '<h2>Haus 1</h4><table class="mitgliederliste">', 2 => '<h2>Haus 2</h4><table class="mitgliederliste">',
	3 => '<h2>Haus 3</h4><table class="mitgliederliste">', 4 => '<h2>Haus 4</h4><table class="mitgliederliste">', 5 => '<h2>Haus 5</h4><table class="mitgliederliste">', 
	6 => '<h2>Haus 6</h4><table class="mitgliederliste">',7 => '<h2>Haus 7</h4><table class="mitgliederliste">',8 => '<h2>Haus 8</h4><table class="mitgliederliste">');

foreach($this->objekte as $obj):

	
	if($vorgaenger != $obj->objektid):
		// Kinder auflisten
		$kinder = $listen_model->getKinder($vorgaenger);
	
		// Ist eines der Kinder zur Anzeige freigegeben?
		$freigabe = false;
		if(count($kinder) > 0) foreach($kinder as $kind):
			if($kind->name_frei) $freigabe = true;
		endforeach;
		
		if(count($kinder) > 0 AND $freigabe):
			if(count($kinder) > 1):
				$haus[substr($vorgaenger,2,1)] .= "Mit Kindern: ";
			else:
				$haus[substr($vorgaenger,2,1)] .= "Mit Kind: ";
			endif;
			foreach ($kinder as $kind):
				if($kind->name_frei) $haus[substr($vorgaenger,2,1)] .= $kind->vorname;
				if($kind->jahrgang_frei) $haus[substr($vorgaenger,2,1)] .= " (".$kind->jahrgang.")";
				if($kind->handy_frei) $haus[substr($vorgaenger,2,1)] .= " ".$kind->handy." ";
				if($kind != end($kinder)) $haus[substr($vorgaenger,2,1)] .= ", ";
			endforeach;
			$haus[substr($vorgaenger,2,1)] .= "<br />\n";
		endif;
	
		$haus[substr($obj->objektid,2,1)] .= "<tr><td class=\"mitglied\">".$obj->objektid.": </td><td class=\"mitglied\">";
	endif;
	
	$haus[substr($obj->objektid,2,1)] .= "<a class=\"modal\"
	href=\"index.php?option=com_giesserei&controller=giesserei&view=mitglied&tmpl=component&id=".$obj->userid."\"
	rel=\"{handler: 'iframe', size: {x: 640, y: 480}}\">".$obj->vorname." ".$obj->nachname."</a><br />\n";
	
	$vorgaenger = $obj->objektid;
	
endforeach;

foreach ($haus as $hs):
	echo $hs."</table><br />";
endforeach;


?>
</table>

</div>

<div class="default" id="adr_1" style="background:#eef; margin-bottom:5px; display:none">Daten nachladen...</div>
