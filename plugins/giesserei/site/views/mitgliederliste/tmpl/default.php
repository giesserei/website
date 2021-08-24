<?php
/*
 * com_mitglied:View Mitgliederliste
 * Zeigt eine alphabetische Liste aller Mitglieder an
 *
 * Jürg Altwegg, Hausverein Giesserei
 *
 */

defined('_JEXEC') or die('Restricted access');

JLoader::register('GiessereiAuth', JPATH_COMPONENT . '/helpers/giesserei_auth.php');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base . '/components/com_giesserei/template/giesserei_default.css');

// Benutzer angemeldet?
$user = JFactory::getUser();
if (!$user->id > 0):
    echo "Die Registrierung ist abglaufen. Bitte neu anmelden.";
    exit();
endif;


// AJAX-Tools laden
JHTML::_('behavior.framework');
JHTML::_('behavior.modal');

$model = $this->getModel();    // Referenz auf Modell für andere Methoden des Objekts

// Downloads
echo '<div style="margin-top:10px">';
echo '<ul>';
if (GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_ADDRESS_LIST)) {
    echo '<li><a href="/index.php?option=com_giesserei&task=mitgliederliste.adressliste&format=raw">Download: Adressliste</a></li>';
}
if (GiessereiAuth::hasAccess(GiessereiAuth::ACTION_DOWNLOAD_PASSIVE_LIST)) {
    echo '<li><a href="/index.php?option=com_giesserei&task=mitgliederliste.listePassivmitglieder&format=raw">Download: Liste Passivmitglieder</a></li>';
}
echo '</ul>';
echo '</div>';
?>

    <p style="border-style:solid; border-color:red; border-width:1px; padding:5px;">Diese Mitgliederliste darf nur für
    <strong>persönliche</strong> Zwecke verwendet werden. Die Nutzung für <strong>Sammelversände, Umfragen, Newsletter
        und ähnliches ist explizit dem Vorstand des Vereins Mehrgenerationenhaus vorbehalten</strong>. Jeglicher
    Missbrauch wird zivilrechtlich geahndet.</p>

    <p style="border-style:solid; border-color:red; border-width:1px; padding:5px;">
        Um bestimmte Personen zu suchen, verwendet man am besten die Suchfunktion des Browsers
        (in der Regel &lt;ctrl&gt;+F oder &lt;cmd&gt;+F).
    </p>

<p><em>Um die Details eines Mitglieds anzuzeigen, auf den Namen klicken!</em></p>

<div class="links">

    <?php

    echo "<h2 style='margin-bottom: 20px;'>Aktivmitglieder (" . $this->getAnzahlBewohner() . ")</h2>";

    writeListe($this->getBewohner(), $model);

    echo "<h2 style='margin-bottom: 20px;'>Jugendmitglieder (" . $this->getAnzahlJugendmitglieder() . ")</h2>";

    writeListe($this->getJugendmitglieder(), $model);

    echo "<h2 style='margin-bottom: 20px; margin-top: 20px'>Gewerbe (" . $this->getAnzahlGewerbe() . ")</h2>";

    writeListe($this->getGewerbe(), $model);

    echo "<h2 style='margin-bottom: 20px; margin-top: 20px'>Passivmitglieder (" . $this->getAnzahlPassivmitglieder() . ")</h2>";

    writeListe($this->getPassivmitglieder(), $model);

    // Feld für die Anzeige der Mitglied-Details vorbereiten (AJAX-Rahmen)
    echo "<div class=\"default\" id=\"adr_1\" style=\"background:#eef; margin-bottom:5px; display:none\">Daten nachladen...</div>\n";
    ?>

</div>

<?php

function writeListe($mitglieder, $model)
{
    echo '<table class="mitgliederliste">';

    foreach ($mitglieder as $person):

        echo '<tr>';
        echo '<td class="mitglied">';
        echo '<a class="modal" href="/index.php?option=com_giesserei&controller=giesserei&view=mitglied&tmpl=component&id=' . $person->userid . '"
rel="{handler: \'iframe\', size: {x: 640, y: 480}}"><strong>' . $person->nachname . '</strong> ' . $person->vorname . '</a>';
        echo '</td>';
        echo '<td class="mitglied">';

        if (substr($person->email, 0, 11) != "kein.email." && substr($person->email, 0, 12) != "keine.email.") {
            echo '<a href="mailto:' . $person->email . '?body=Liebe/Lieber ' . $person->vorname . '">E-Mail an ' . $person->vorname . '</a>';
        }

        echo '</td><td class="mitglied">';

        if ($person->telefon_frei):
            echo $person->telefon;
        else:
            echo "&nbsp;";
        endif;

        echo "</td>";

        $objekte = $model->getObjekte($person->userid);
        if (empty($objekte)) {
            echo "<td class=\"mitglied\" colspan=\"2\"></td>";
        } else {
            echo "<td class=\"mitglied\">";

            // Hausnummer(n) ausgeben
            if (count($objekte) > 0) foreach ($objekte as $obj):
                echo "Haus " . substr($obj->objektid, 2, 1);
                if ($obj != end($objekte)) echo "<br />";
            endforeach;

            echo "</td><td class=\"mitglied\">";

            // Gemietete Wohnung(en) ausgeben
            if (count($objekte) > 0) foreach ($objekte as $obj):
                echo $obj->objektid;
                if ($obj != end($objekte)) echo "<br />";
            endforeach;

            echo "</td>";
        }
        echo "</tr>";


    endforeach;

    echo '</table>';
}
