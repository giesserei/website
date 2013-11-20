<?php
defined('_JEXEC') or die('Restricted access');

/*
 * com_mitglied:View Arbeitsgruppenliste
 * Zeigt eine Liste der Arbeitsgruppen, Gremien und Bereich an
 * Hilfstabelle: Welche Joomla-Gruppen sollen angezeigt werden? -> mgh_bereich 
 * 
 * Jürg Altwegg, Hausverein Giesserei
 * 
 */

// Benutzer angemeldet?
$user =& JFactory::getUser();
if(!$user->id > 0):
	echo "Die Registrierung ist abglaufen. Bitte neu anmelden.";
	exit();
endif;

echo "<h2>Gremienverzeichnis</h2>";

echo "<p>Im Verein gibt es verschiedene Gremien, Arbeitsgruppen und Kommissionen, in denen sich die Mitglieder engagieren. <br />
Unten sind diese und die Verantwortlichen (<strong>fett</strong> gedruckt) aufgeführt.</p>";

foreach($this->gruppen as $gruppe):
	echo "<h3>".$gruppe->title."</h3>";
	foreach ($this->mitglieder[$gruppe->id] as $mitglied):
		if($mitglied->userid == $gruppe->leitung_userid) echo "<strong>";
		echo $mitglied->vorname." ".$mitglied->nachname;
		if($mitglied->userid == $gruppe->leitung_userid) echo "</strong>";
		if(strlen($mitglied->funktion)>1) echo " (".$mitglied->funktion.")";

		// Kontaktinfos nur für Mitglieder
		$user =& JFactory::getUser();
		if($user->id > 0):
			echo ", ".$mitglied->telefon.", <a href=\"mailto:".$mitglied->email."\">".$mitglied->email."</a>";
		endif;
		
		echo "<br />";
	endforeach;
endforeach;
?>
