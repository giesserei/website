<?php
/**
 * Zeigt eine Liste der Häuser mit ihren BewohnerInnen an.
 * 
 * Changes:
 * - Nur Mitglieder berücksichtigen, denen eine Wohnung zugewiesen ist (SF, 2013-12-31)
 * - Auch bei der letzten Wohnung vom Haus 8 werden die Kinder angezeigt (SF, 2013-12-31)
 * - Wohnungen ohne Bewohner werden in der Bewohnerliste nicht angezeigt (SF, 2013-12-31)
 * - Tabellen-Zelle zu jeder Wohnung mit End-Tags abschliessen (SF, 2013-12-31)
 * 
 * @author Jürg Altwegg
 */

defined('_JEXEC') or die('Restricted access');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base.'/components/com_giesserei/template/giesserei_default.css');

require_once(JPATH_SITE.DS."components".DS."com_giesserei".DS."models".DS."mitgliederliste.php");

// Referenz auf Modell der Mitgliederliste
$listen_model = new GiessereiModelMitgliederliste; 

// Benutzer angemeldet?
$user =& JFactory::getUser();
if (!$user->id > 0) {
	echo "Die Registrierung ist abglaufen. Bitte neu anmelden.";
	exit();
}

// AJAX-Tools laden
JHTML::_('behavior.mootools');
JHTML::_('behavior.modal');

?>

<p style="border-style:solid; border-color:red; border-width:1px; padding:5px;">
  Diese Mitgliederliste darf nur für <strong>persönliche</strong> Zwecke verwendet werden. 
  Die Nutzung für <strong>Sammelversände, Umfragen, Newsletter und ähnliches ist explizit 
  dem Vorstand des Vereins Mehrgenerationenhaus vorbehalten</strong>. 
  Jeglicher Missbrauch wird zivilrechtlich geahndet.
</p>

<p><em>Um die Details eines Mitglieds anzuzeigen, auf den Namen klicken!</em></p>

<div class="links">

<?php

$haus = array(
    1 => '<h2>Haus 1</h2><table class="mitgliederliste">', 
    2 => '<h2>Haus 2</h2><table class="mitgliederliste">',
	  3 => '<h2>Haus 3</h2><table class="mitgliederliste">', 
    4 => '<h2>Haus 4</h2><table class="mitgliederliste">', 
    5 => '<h2>Haus 5</h2><table class="mitgliederliste">', 
	  6 => '<h2>Haus 6</h2><table class="mitgliederliste">',
    7 => '<h2>Haus 7</h2><table class="mitgliederliste">',
    8 => '<h2>Haus 8</h2><table class="mitgliederliste">');

/**
 * Sofern unter der übergebenen Objekt-Id Kinder registriert sind, wird 
 * ein HTML-Schnipsel mit den Namen der Kinder zurückgegeben.
 */
function getKinderHtml($objektid, $model) {
  $result = "";
  $kinder = $model->getKinder($objektid);
  
  // Anzahl der Kinder ermitteln, für eine Anzeige-Freigabe besteht
  $anzahlMitFreigabe = 0;
  if (count($kinder) > 0) {
    foreach ($kinder as $kind) {
      if ($kind->name_frei) {
        $anzahlMitFreigabe ++;
      }
    }
  }
  
  if ($anzahlMitFreigabe > 0) {
    $result .= ($anzahlMitFreigabe > 1) ? "Mit Kindern: " : "Mit Kind: ";

    $current = 0;
    foreach ($kinder as $kind) {
      if ($kind->name_frei) {
        $current ++;
        $result .= $kind->vorname;
        
        if ($kind->jahrgang_frei) {
          $result .= " (".$kind->jahrgang.")";
        }
        if ($kind->handy_frei) {
          $result .= " ".$kind->handy." ";
        }
      }
      
      // weitere Kinder vorhanden?
      if ($current < $anzahlMitFreigabe) {
        $result .= ", ";
      }
    }
    $result .= "<br />\n";
  }
  return $result;
}

/**
 * Liefert die Hausnummer zur übergebenen Wohnungsnummer.
 */
function getHausNr($objektid) {
  return substr($objektid,2,1);
}

$vorgaengerId = "";

foreach($this->objekte as $obj) {
  $hausNr = getHausNr($obj->objektid);
  
  // Wohnung wechselt und ist nicht die erste Wohnung der Liste 
  // -> Kinder ausgeben
  // -> Tabellenzeile abschliessen
  if($vorgaengerId != $obj->objektid && $vorgaengerId != "") {
    $hausNrVorgaenger = getHausNr($vorgaengerId);
    $haus[$hausNrVorgaenger] .= getKinderHtml($vorgaengerId, $listen_model);
    $haus[$hausNrVorgaenger] .= "</td></tr>";
  }
  
  // Wohnung wechselt oder erste Wohnung -> neue Tabellenzeile 
	if($vorgaengerId != $obj->objektid) {
		$haus[$hausNr] .= "<tr><td class=\"mitglied\">" . $obj->objektid . ": </td><td class=\"mitglied\">";
	}
	
	// Einen Bewohner mit Vornamen und Namen ausgeben
	$haus[$hausNr] .= "<a class=\"modal\"
	  href=\"index.php?option=com_giesserei&controller=giesserei&view=mitglied&tmpl=component&id=".$obj->userid."\"
	  rel=\"{handler: 'iframe', size: {x: 640, y: 480}}\">".$obj->vorname." ".$obj->nachname."</a><br />\n";
	
	$vorgaengerId = $obj->objektid;
}

// Für die letzte Wohnung die Kinder ausgeben und Tabellenzeile abschliessen
$hausNrVorgaenger = getHausNr($vorgaengerId);
$haus[$hausNrVorgaenger] .= getKinderHtml($obj->objektid, $listen_model);
$haus[$hausNrVorgaenger] .= "</td></tr>";

foreach ($haus as $key=>$hs) {
	echo $hs."</table><br />";
}

?>
</table>

</div>

<div class="default" id="adr_1" style="background:#eef; margin-bottom:5px; display:none">Daten nachladen...</div>
