<?php
defined('_JEXEC') or die('Restricted access');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base . '/components/com_giesserei/template/giesserei_default.css');

// Pfad zu den Wohnungsdetails
define('DETAIL_PFAD', "/index.php?option=com_giesserei&view=whgdetail&Itemid=193&view=whgdetail&whgnr=");

// Funktion zur Anzeige der einzelnen Wohnungsnummern
function whg_nummer($whg)
{
    global $detail_pfad;
    echo "<a href=\"" . DETAIL_PFAD . $whg->nummer . "\"";
    $res = $whg->anzahl_mitglieder > 0 && $whg->freiab == '0000-00-00';
    if ($res) echo " class=\"res\"";
    echo ">" . $whg->nummer . "</a> ";
    if ($whg->subventioniert > 0) echo "<img src=\"images/blue_triangle.png\" alt=\"subventioniert\" title=\"subventioniert\" /> ";
    if ($res) echo "<span class=\"res\">";
    echo " (" . $whg->bezeichnung . ", " . $whg->zimmerbezeichnung . ")</span><br />";
}

?>
<h2>Wohnungsspiegel nach Position</h2>

<h3>Ostflügel (an Ida-Sträuli-Strasse)</h3>
<table width="100%" class="whgliste">
    <tr>
        <th width="25%"> Treppenhaus 1</th>
        <th width="25%"> Treppenhaus 2</th>
        <th width="25%"> Treppenhaus 3</th>
        <th width="25%"> Treppenhaus 4</th>
    </tr>
    <tr>
        <?php
        for ($th = 1; $th <= 4; $th++) {
            echo "<td valign=\"top\">";
            foreach ($this->wohnungen as $whg) {
                if (substr((string)$whg->id, 2, 1) == $th) whg_nummer($whg);
            }
            echo "</td>";
        }
        ?>
    </tr>
</table>
<br/><br/>
<h3>Westflügel (Innenhof)</h3>
<table width="100%" class="whgliste">
    <tr>
        <th width="25%"> Treppenhaus 5</th>
        <th width="25%"> Treppenhaus 6</th>
        <th width="25%"> Treppenhaus 7</th>
        <th width="25%"> Treppenhaus 8</th>
    </tr>
    <tr>
        <?php
        for ($th = 5; $th <= 8; $th++) {
            echo "<td valign=\"top\">";
            foreach ($this->wohnungen as $whg) {
                if (substr((string)$whg->id, 2, 1) == $th) whg_nummer($whg);
            }
            echo "</td>";
        }
        ?>
    </tr>
</table>
<p><img src="images/blue_triangle.png" alt="subventioniert" title="subventioniert"/> = subventionierte Wohnungen</p>

