<?php
defined('_JEXEC') or die('Restricted access');

JLoader::register('JTableContent'  , JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'content.php');

// Lokales CSS laden
$doc = JFactory::getDocument();
$base = JURI::base(true);
$doc->addStyleSheet($base.'/components/com_giesserei/template/giesserei_default.css');

$whg = $this->wohnung[0];
$model =& $this->getModel();

JPluginHelper::importPlugin('content'); 
$dispatcher =& JDispatcher::getInstance();

// Berechnen der Verortungsansicht
// Gebäudeflügel und Treppenhaus
switch ((int) substr((string)$whg->nummer,2,1)):
	case 1:
		$th=0;
		$gb=1;
		break;
	case 2:
		$th=1;
		$gb=1;
		break;
	case 3:
		$th=2;
		$gb=1;
		break;
	case 4:
		$th=3;
		$gb=1;
		break;
	case 5:
		$th=3;
		$gb=7;
		break;
	case 6:
		$th=2;
		$gb=7;
		break;
	case 7:
		$th=1;
		$gb=7;
		break;
	case 8:
		$th=0;
		$gb=7;
		break;	
endswitch;

// Stockwerk
$st = (int) substr((string)$whg->nummer,1,1);

if($whg->maisonette):
	$st=0;
	if($th > 2) $th=5; else $th=4;
	$gb=13;
endif;

?>
<h2>Details zur Wohnung Nummer <strong><?php echo $whg->nummer; ?></strong></h2>
<br />
<table class="whgliste">
<tr><td width="400'"><?php 
	$text = "<img src=\"/media/grundrisse/".$whg->grundriss.".png\" alt=\"Grundriss\" width=\"350\" /><br /><br /><br /><strong>ACHTUNG</strong>: 
	Dies ist nur ein schematischer Grundrissplan ohne Anspruch auf Detailtreue! Vereinsmitglieder können genaue und vermasste 1:100-Pläne als PDF in der Dateiablage herunterladen.";
	// Lupensymbol automatisch hinzufügen via Joomla-HTM-Präpozessor
	echo JHtml::_('content.prepare',$text);
	echo "";
?></td>
<td valign="top">
<?php 
if($whg->userid > 0 && $whg->freiab == '0000-00-00') echo "<span class=\"resmark\">Wohnung ist bereits VERMIETET!</span><br /><br />";
?>
<ul>
<li><strong><?php echo $whg->bezeichnung ?></strong></li>
<li>Grösse: <strong><?php echo $whg->zimmerbezeichnung; if($whg->maisonette) echo " Maisonette"; ?></strong></li>
<li>Nettowohnfläche: <strong><?php echo $whg->flaeche ?> m<sup>2</sup></strong><br/>
(Netto = ohne die von den Zwischenwänden belegte Fläche)</li>
<?php 
if($whg->subventioniert > 0):
?>
<li><span style="color: red;">Subventionierte Nettomiete:</span> <strong>Fr. <?php echo number_format($whg->subventioniert,0,',','\'') ?>.-/Monat</strong>
<?php /* (statt Fr.  echo number_format($whg->preis,0,',','\'') .-) */?><br /> 
Miete durch Kanton und Stadt Winterthur unterstützt; Rahmenbedingungen beachten! Siehe dazu Website 
<a href="http://www.wbf.zh.ch" target="_blank">WBF Kanton</a> (Miete inkl. Anteil an Gemeinschaftsräumen)</li>
<?php 
else:
?>
<li>Nettomiete: <strong>Fr. <?php echo number_format($whg->miete,0,',','\'') ?>.-/Monat</strong></li>
<?php 
endif;
?>
<li>Voraussichtliches Pflichtdarlehen: <strong>Fr. <?php echo number_format($whg->pflichtdarlehen,0,',','\'') ?>.-</strong></li>
<li>Nebenkosten:
<ul>
<li>Allgemeine Nebenkosten (akonto): <strong>Fr. <?php echo number_format($whg->nk,0,',','\'') ?>.-/Monat</strong><br />
für Fernwärme, Wasser, Lüftung (Ventilatorstrom, Unterhalt), Serviceabos (Lifte, Waschmaschinen), Allgemeinstrom, 
Gemeinschaftsräume, etc.<br>
(<b>nicht</b> enthalten sind Strom und Abfall, welche direkt vom Stadtwerk in Rechnung gestellt werden)
<li>Solidaritätsfonds Gesewo: <strong>Fr. 10.-/Monat</strong>
</ul>
<li>Stockwerk: <strong><?php
	if($st == 0) echo "EG";
	elseif($st == 5) echo "DG";
	else echo $st.". OG"; 
?></strong></li>

<li>Gebäude: <strong><?php if($gb == 1) echo "Ostflügel"; elseif($gb == 7) echo "Westflügel"; else echo "Zwischenbau"; ?></strong></li>

<?php 
if(strlen($whg->anmerkung) > 1):
	echo "<li>".$whg->anmerkung."</li>";
endif;

// Reservationsinfos nur für Mitglieder
$user =& JFactory::getUser();
if($user->id > 0): 
	if(strlen($whg->oto) > 1):
		echo "<li>Glasfaser-OTO-ID: <strong>".$whg->oto."</strong>";
	endif;
	if($whg->userid > 0):
		echo "<li> Bewohnt von: <br />";
		foreach($this->wohnung as $mieter):
			echo $mieter->name;
			if($mieter != end($this->wohnung)) echo ", ";
		endforeach;
		echo "</li>";
	endif;
	
	$opt = $model->getOptions( $whg->nummer );
	if(count($opt) > 0):
		echo "<li>Eingebaute Optionen: <br />";
		foreach($opt as $name):
			echo $name->beschreibung;
			if($name != end($opt)) echo "<br /> ";
		endforeach;
		echo "</li>";
	endif;
	
endif;

?>

</ul></td></tr>
</table>

