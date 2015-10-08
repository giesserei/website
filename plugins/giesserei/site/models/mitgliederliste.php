<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.archive');
jimport('joomla.environment.response');

/**
 * Modellklasse für die Mitgliederliste.
 */
class GiessereiModelMitgliederliste extends JModel {
	
	/**
	 * Liefert die Liste aller aktiven Mitglieder zurück (Bewohner, Gewerbe, Passivmitglieder).
	 */
	function getMitglieder() {
	    $db =& JFactory::getDBO();
	    $query = "SELECT *,usr.email as email, mgl.userid as userid FROM #__mgh_mitglied as mgl
	    	LEFT JOIN #__users AS usr ON mgl.userid = usr.id
	    	LEFT JOIN #__kunena_users AS kun ON mgl.userid = kun.userid
	    	WHERE (austritt>=NOW() OR austritt='0000-00-00') AND mgl.typ IN (1,2,3) ORDER BY nachname";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	} 

	/**
	 * Erzeugt Liste mit allen Mietobjekten eines bestimmten Mitglieds
	 */
	function getObjekte($userid) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__mgh_x_mitglied_mietobjekt WHERE userid=".$userid;
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);		
	} 
	
	/**
	 * Erzeugt Liste mit allen Kindern eines bestimmten Mietobjekts
	 */
	function getKinder( $objektid ) {
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__mgh_kind WHERE objektid=".$objektid." ORDER BY vorname";
	    $db->setQuery($query);
	    $rows = $db->loadObjectList();
	    return($rows);
	}

    /**
     * Erstellt eine CSV-Datei mit Name und Adresse der Bewohner und des Gewerbes
     * und schreibt diese in den Response.
     */
    public function exportAdresslisteToCSV() {
        $filename = 'mitgliederliste.csv';
        $random = rand(1, 99999);
        $filepath = JPATH_SITE.'/tmp/'.date('Y-m-d').'_'.strval($random).'_'.$filename;

        if ($this->createAdresslisteCSVFile($filepath)) {
            // deliver file
            $this->deliverFile($filepath, 'mitgliederliste');

            // clean up
            JFile::delete($filepath);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Erstellt eine CSV-Datei mit Name und Adresse der Passivmitglieder
     * und schreibt diese in den Response.
     */
    public function exportListePassivmitgliederToCSV() {
        $filename = 'passivmitglieder.csv';
        $random = rand(1, 99999);
        $filepath = JPATH_SITE.'/tmp/'.date('Y-m-d').'_'.strval($random).'_'.$filename;

        if ($this->createListePassivmitgliederCSVFile($filepath)) {
            // deliver file
            $this->deliverFile($filepath, 'passivmitglieder');

            // clean up
            JFile::delete($filepath);
            return true;
        }
        else {
            return false;
        }
    }

    // -------------------------------------------------------------------------
    // private section
    // -------------------------------------------------------------------------

    /**
     * Erstellt die CSV-Datei mit der Adressliste.
     */
    private function createAdresslisteCSVFile($filepath) {
        $db = $this->getDBO();
        $csv_output = 'Nachname;Vorname;Adresse;PLZ;Ort;E-Mail';
        $csv_output .= "\n";

        $query = "
              SELECT nachname, vorname, adresse, plz, ort, email
              FROM #__mgh_aktiv_mitglied
              WHERE typ IN (1,2)
              ORDER BY nachname
            ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();

        foreach($rows as $row) {
            foreach($row as $col_name => $value) {
                $csv_output .= $value.';';
            }
            $csv_output .= "\n";
        }

        if (!JFile::write($filepath, $csv_output)) {
            JFactory::getApplication()->enqueueMessage('Datei konnte nicht erstellt werden.');
            return false;
        }
        return true;
    }

    /**
     * Erstellt die CSV-Datei mit den Passivmitgliedern.
     */
    private function createListePassivmitgliederCSVFile($filepath) {
        $db = $this->getDBO();
        $csv_output = 'Nachname;Vorname;Adresse;PLZ;Ort;E-Mail;Eintritt;Austritt';
        $csv_output .= "\n";

        $query = "
              SELECT m.nachname, m.vorname, m.adresse, m.plz, m.ort, u.email, m.eintritt, m.austritt
              FROM #__mgh_mitglied m
              JOIN #__users u ON m.userid = u.id
              WHERE m.typ IN (3) AND (m.austritt = '0000-00-00' OR m.austritt > NOW())
              ORDER BY nachname
            ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();

        foreach($rows as $row) {
            foreach($row as $col_name => $value) {
                $csv_output .= $value.';';
            }
            $csv_output .= "\n";
        }

        if (!JFile::write($filepath, $csv_output)) {
            JFactory::getApplication()->enqueueMessage('Datei konnte nicht erstellt werden.');
            return false;
        }
        return true;
    }

    /**
     * Schreibt das ZIP-File in den Response-Output-Stream.
     * @param $filepath Pfad zur temporären Datei
     * @param $filename Name der temporären Datei
     */
    private function deliverFile($filepath, $filename) {
        $filesize = filesize($filepath);
        JResponse::setHeader('Content-Type', 'application/octet-stream');
        JResponse::setHeader('Content-Transfer-Encoding', 'Binary');
        JResponse::setHeader('Content-Disposition', 'attachment; filename='.$filename.'_'.date('Y-m-d').'.csv');
        JResponse::setHeader('Content-Length', $filesize);
        echo JFile::read($filepath);
    }

}
