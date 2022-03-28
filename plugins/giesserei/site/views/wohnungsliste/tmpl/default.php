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
    $res = $whg->kz_frei == '0';
    echo ">" . $whg->nummer . "</a> ";
    if ($whg->subventioniert > 0) echo "<img src=\"images/blue_triangle.png\" alt=\"subventioniert\" title=\"subventioniert\" /> ";
    if ($res) echo "<span class='whg_res'>"; else echo "<span class='whg_frei'>";
    echo " (" . $whg->bezeichnung . ", " . $whg->zimmerbezeichnung . ")</span><br />";
}

?>
<h2>Wohnungsspiegel</h2>

<h3>Ostflügel (an Ida-Sträuli-Strasse)</h3>
<table width="100%" class="whgliste">
    <tr>
        <th width="25%" align="left">Treppenhaus 1 - Nr. 71</th>
        <th width="25%" align="left">Treppenhaus 2 - Nr. 69</th>
        <th width="25%" align="left">Treppenhaus 3 - Nr. 67</th>
        <th width="25%" align="left">Treppenhaus 4 - Nr. 65</th>
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
        <th width="25%" align="left">Treppenhaus 5 - Nr. 79</th>
        <th width="25%" align="left">Treppenhaus 6 - Nr. 77</th>
        <th width="25%" align="left">Treppenhaus 7 - Nr. 75</th>
        <th width="25%" align="left">Treppenhaus 8 - Nr. 73</th>
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
<p><span class='whg_frei'>grün</span> = Freie Wohnungen</p>

