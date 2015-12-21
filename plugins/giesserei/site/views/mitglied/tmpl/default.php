<?php
/*
 * com_mitglied:View Mitglied
 * Zeigt die Details eines Mitglieds an
 * 
 * Jürg Altwegg, Hausverein Giesserei
 * 
 */

defined('_JEXEC') or die('Restricted access');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base . '/components/com_giesserei/template/giesserei_default.css');

require_once(JPATH_SITE . "/components/com_giesserei/models/mitgliederliste.php");
$listen_model = new GiessereiModelMitgliederliste; // Referenz auf Modell für Methoden des Objekts

$user = JFactory::getUser();
if (!$user->id > 0):
    echo "Die Registrierung ist abglaufen. Bitte neu anmelden.";
    exit();
endif;

echo "<html><head><title>Personeninfo</title></head>";
echo '<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="/templates/giesserei/css/giesserei.css" type="text/css" />';
echo '<body style="min-width: 600px; max-width: 600px;">';

$person = $this->mitglied[0];

echo "<table width=\"100%\" style=\"border-style:none;\">";
echo "<tr class=\"mitglied\"><td width=\"30%\" rowspan=\"6\" class=\"mdetail\">";

if (strlen($person->avatar) > 5):
    echo "<img src=\"/media/kunena/avatars/" . $person->avatar . "\" alt=\"Portraitfoto\" border=\"0\" />";
else:
    echo "<img src=\"/media/kunena/avatars/resized/size200/nophoto.jpg\" alt=\"leider kein Portraitfoto\" border=\"0\" />";
endif;

echo "</td>";

echo "<td width=\"70%\" class=\"mdetail\"><strong class=\"mitglied\">" . $person->vorname . " " . $person->nachname . "</strong></td></tr>";
echo "<tr  class=\"mitglied\"><td class=\"mdetail\">" . $person->adresse . " &nbsp; ";

// Gemietete Wohnung(en) ausgeben
$objekte = $listen_model->getObjekte($person->userid);
$obj_counter = 0;

echo(empty($objekte) ? '' : '(');

foreach ($objekte as $obj):
    echo $obj->objektid;
    if ($obj != end($objekte)) echo ", ";
endforeach;

echo(empty($objekte) ? '' : ')');

echo "<br />" . $person->plz . " " . $person->ort . "<br /><br /></td></tr>";

echo "<tr class=\"mitglied\"><td class=\"mdetail\"><strong class=\"mitglied\">E-Mail:</strong> ";
if (substr($person->email, 0, 11) != "kein.email." && substr($person->email, 0, 12) != "keine.email.") {
    echo "<a href=\"mailto:" . $person->email . '?body=Liebe/Lieber ' . $person->vorname . "\">" . $person->email . "</a>";
} else {
    echo "(keine E-Mail-Adresse)";
}
echo "</td></tr>";

echo "<tr class=\"mitglied\"><td class=\"mdetail\"><strong class=\"mitglied\">Telefon 1: </strong> ";
if (empty($person->telefon)) {
    echo "<em>(nicht erfasst)</em>";
} else {
    if ($person->telefon_frei) {
        echo $person->telefon;
    } else {
        echo "<em>(von Benutzer gesperrt)</em>";
    }
}

echo "</td></tr><tr class=\"mitglied\"><td class=\"mdetail\"><strong>Telefon 2: </strong>";
if (empty($person->handy)) {
    echo "<em>(nicht erfasst)</em>";
} else {
    if ($person->handy_frei) {
        echo $person->handy;
    } else {
        echo "<em>(von Benutzer gesperrt)</em>";
    }
}

echo "</td></tr>";

// Geburtsdatum
echo "<tr class=\"mitglied\"><td class=\"mdetail\"><strong class=\"mitglied\">Geburtstag: </strong>";
if (substr($person->birthdate, 0, 4) > 1900):
    echo JHTML::_('date', $person->birthdate, 'd. F Y');
else:
    echo "<em>(nicht erfasst)</em>";
endif;
echo "</td></tr>";

// Profil
echo "<tr class=\"mitglied\"><td colspan=\"2\" class=\"mdetail\">" . $person->zur_person . "</td></tr>";

// TODO:
// Website
// Kinder

echo "</table>";

echo "</body></html>";
?>
