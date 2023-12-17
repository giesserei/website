<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('JTableContent', JPATH_LIBRARIES . '/joomla/database/table/content.php');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base . '/components/com_giesserei/template/giesserei_default.css');

// CSS laden für Magnific Popup (http://dimsemenov.com/plugins/magnific-popup/)
$doc->addStyleSheet($base . '/components/com_giesserei/template/magnific_popup.css');

$whg = $this->wohnung[0];
$model = $this->getModel();

// Berechnen der Verortungsansicht
// Gebäudeflügel und Treppenhaus
switch ((int)substr((string)$whg->nummer, 2, 1)):
    case 1:
        $th = 0;
        $gb = 1;
        break;
    case 2:
        $th = 1;
        $gb = 1;
        break;
    case 3:
        $th = 2;
        $gb = 1;
        break;
    case 4:
        $th = 3;
        $gb = 1;
        break;
    case 5:
        $th = 3;
        $gb = 7;
        break;
    case 6:
        $th = 2;
        $gb = 7;
        break;
    case 7:
        $th = 1;
        $gb = 7;
        break;
    case 8:
        $th = 0;
        $gb = 7;
        break;
endswitch;

// Stockwerk
$st = (int)substr((string)$whg->nummer, 1, 1);

if ($whg->maisonette):
    $st = 0;
    if ($th > 2) $th = 5; else $th = 4;
    $gb = 13;
endif;

$istWohnung = $whg->flaeche > 0 && $whg->gewerbe_flaeche == 0;

?>
<h2>
   Details
   <?php if (!$istWohnung) { ?>
      zum Mietobjekt
   <?php } else { ?>
      zur Wohnung
   <?php } ?>
   Nummer <strong><?php echo $whg->nummer; ?></strong>
</h2>
<br/>
<table class="whgliste">
    <tr>
        <td width="400'">
            <a id="wohnung-image" href="/media/grundrisse/<?php echo $whg->grundriss; ?>.png">
                <img src="/media/grundrisse/<?php echo $whg->grundriss; ?>.png" alt="Grundriss"
                     title="Mietobjekt <?php echo $whg->nummer; ?>" width="350" />
            </a>
            <br /><br /><br />
            <strong>ACHTUNG</strong>:
                 Dies ist nur ein schematischer Grundrissplan ohne Anspruch auf Detailtreue!
            Vereinsmitglieder können genaue und vermasste 1:100-Pläne als PDF in der Dateiablage herunterladen.
        </td>
        <td valign="top">
            <?php
            if ($whg->kz_frei == "1")
                echo "<span class='notice_whg_frei'>Wohnung ist frei!</span><br /><br />";
            ?>
            <ul>

                <?php if ($istWohnung) { ?>
                   <li><strong><?php echo $whg->bezeichnung ?></strong>
                   <li>Grösse: <strong><?php echo $whg->zimmerbezeichnung;
                           if ($whg->maisonette) echo " Maisonette"; ?></strong>
                <?php } else { ?>
                   <li><strong><?php echo $whg->bezeichnung ?>, <?php echo $whg->zimmerbezeichnung ?></strong>
                <?php } ?>

                <?php if ($whg->flaeche > 1) { ?>
                   <li>Nettowohnfläche: <strong><?php echo $whg->flaeche ?> m<sup>2</sup></strong><br/>
                       (Netto = ohne die von den Zwischenwänden belegte Fläche)
                <?php } ?>
                <?php if ($whg->gewerbe_flaeche > 1) { ?>
                   <li>Fläche: <strong><?php echo $whg->gewerbe_flaeche ?> m<sup>2</sup></strong>
                <?php } ?>
                <?php if ($whg->subventioniert > 0) { ?>
                   <li><span style="color: red;">Subventionierte Nettomiete:</span>
                      <strong>CHF <?php echo number_format($whg->subventioniert, 0, ',', '\'') ?> / Monat</strong><br/>
                      Miete durch Kanton und Stadt Winterthur unterstützt; Rahmenbedingungen beachten! Siehe dazu
                      Website
                      <a href="http://www.wbf.zh.ch" target="_blank">WBF Kanton</a> (Miete inkl. Anteil an
                      Gemeinschaftsräumen)
                <?php } else { ?>
                   <?php /* alt: if ($whg->nummer == 2015) { ... <li>Nettomiete: <strong>Umsatzmiete</strong></li> */ ?>
                   <li>Nettomiete: <strong>CHF <?php echo number_format($whg->miete, 0, ',', '\'') ?> / Monat</strong>
                <?php } ?>
                <?php if ($whg->pflichtdarlehen) { ?>
                   <li>Pflichtdarlehen: <strong>CHF <?php echo number_format($whg->pflichtdarlehen, 0, ',', '\'') ?></strong>
                <?php } ?>

                <?php if ($whg->subventioniert > 0) { ?>
                    <li>Nebenkosten + genossenschaftliche Beiträge (akonto) von
                        <strong>CHF <?php echo number_format($whg->nk, 0, ',', '\'') ?> / Monat</strong> für Heizkosten,
                        Wasser, Gemeinschaftsräume, Mietzinsausfall, Leerstände und Solidaritätsfond
                <?php } else if (!$istWohnung) { ?>
                    <li>Nebenkosten (akonto): <strong>CHF <?php echo number_format($whg->nk, 0, ',', '\'') ?> / Monat</strong>
                <?php } else { ?>
                    <li>Nebenkosten:
                        <ul>
                            <li>Allgemeine Nebenkosten (akonto):
                                <strong>CHF <?php echo number_format($whg->nk, 0, ',', '\'') ?> / Monat</strong><br/>
                                für Fernwärme, Wasser, Lüftung (Ventilatorstrom, Unterhalt), Serviceabos (Lifte,
                                Waschmaschinen), Allgemeinstrom,
                                Gemeinschaftsräume, etc.<br>
                                (<b>nicht</b> enthalten sind Strom und Abfall, welche direkt vom Stadtwerk in Rechnung
                                gestellt werden)
                            <li>Solidaritäts- und Innovationsfonds Gesewo: <strong>CHF 10 / Monat</strong>
                        </ul>
                <?php } ?>

                <li>Stockwerk: <strong><?php
                        if ($st == 0) echo "EG";
                        elseif ($st == 5) echo "DG";
                        else echo $st . ". OG";
                        ?></strong></li>

                <li>Gebäude: <strong><?php if ($gb == 1) echo "Ostflügel"; elseif ($gb == 7) echo "Westflügel";
                        else echo "Zwischenbau"; ?></strong></li>

                <?php
                if (strlen($whg->anmerkung) > 1) {
                    echo "<li>" . $whg->anmerkung . "</li>";
                }

                // Reservationsinfos nur für Mitglieder
                $user = JFactory::getUser();
                if ($user->id > 0) {
                    if (strlen($whg->oto) > 1) {
                        echo "<li>Glasfaser-OTO-ID: <strong>" . $whg->oto . "</strong>";
                    }
                    if ($whg->userid > 0) {
                        if ($istWohnung) {
                           echo "<li>Bewohnt von: <br/>";
                        } else {
                           echo "<li>Gemietet von: <br/>";
                        }
                        foreach ($this->wohnung as $mieter) {
                            echo $mieter->name;
                            if ($mieter != end($this->wohnung)) echo ", ";
                        }
                        echo "</li>";
                    }

                    $opt = $model->getOptions($whg->nummer);
                    if (count($opt) > 0) {
                        echo "<li>Eingebaute Optionen: <br />";
                        foreach ($opt as $name) {
                            echo $name->beschreibung;
                            if ($name != end($opt)) echo "<br /> ";
                        }
                        echo "</li>";
                    }

                }
                ?>

            </ul>
        </td>
    </tr>
</table>

<?php
  // JS laden für Magnific Popup (http://dimsemenov.com/plugins/magnific-popup/)
  // JQuery ist eine Dependency vom Magnific Popup
?>
<script src="/media/jui/js/jquery.min.js"></script>
<script src="<?php echo $base . '/components/com_giesserei/template/magnific_popup.js'; ?>"></script>
<script>
    $('#wohnung-image').magnificPopup({
        type:'image',
        image: {
            titleSrc: 'title', // Attribute of the target element that contains caption for the slide
            verticalFit: false // Fits image in area vertically
        }
    });
</script>
