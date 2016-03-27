<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class GiessereiModelAlter extends JModel
{
    /**
     * Liefert das gesamte HTML für Darstellung der Altersstruktur als HTML5.
     *
     * @return string
     */
    public function getAlterKlassenHtml5()
    {
        JResponse::setHeader('Content-Type', 'text/html');

        $html = '
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <script src="media/system/js/Chart.js"></script>
                    <title>BewohnerInnenstruktur / Altersdurchmischung</title>

                    <script type="text/javascript">

                        var options = {
                            // Boolean - If we want to override with a hard coded scale
                            scaleOverride: true,

                            // ** Required if scaleOverride is true **
                            // Number - The number of steps in a hard coded scale
                            scaleSteps: 11,
                            // Number - The value jump in the hard coded scale
                            scaleStepWidth: 1,
                            // Number - The scale starting value
                            scaleStartValue: 0,

                            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                            scaleBeginAtZero : true,

                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : true,

                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(0,0,0,.05)",

                            //Number - Width of the grid lines
                            scaleGridLineWidth : 1,

                            //Boolean - Whether to show horizontal lines (except X axis)
                            scaleShowHorizontalLines: true,

                            //Boolean - Whether to show vertical lines (except Y axis)
                            scaleShowVerticalLines: true,

                            //Boolean - If there is a stroke on each bar
                            barShowStroke : true,

                            //Number - Pixel width of the bar stroke
                            barStrokeWidth : 2,

                            //Number - Spacing between each of the X value sets
                            barValueSpacing : 5,

                            //Number - Spacing between data sets within X values
                            barDatasetSpacing : 1,

                            //String - A legend template
                            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

                        }

                        var data = {
                            labels: ["0-4 J.", "5-9 J.", "10-14 J.", "15-19 J.",
                                     "20-24 J.", "25-29 J.", "30-34 J.", "35-39 J.",
                                     "40-44 J.", "45-49 J.", "50-54 J.", "54-59 J.",
                                     "60-64 J.", "65-69 J.", "70-74 J.", "75-79 J.",
                                     "80-84 J.", "85-89 J.", "90-94 J."],
                            datasets: [
                                {
                                    label: "Giesserei",
                                    fillColor: "rgba(123,164,40,0.8)",
                                    strokeColor: "rgba(123,164,40,1)",
                                    highlightFill: "rgba(123,164,40,0.5)",
                                    highlightStroke: "rgba(123,164,40,1)",
                                    data: [' . $this->getAlterKlassenWerte() . ']
                                },
                                {
                                    label: "Schweiz",
                                    fillColor: "rgba(255,0,0,0.8)",
                                    strokeColor: "rgba(255,0,0,1)",
                                    highlightFill: "rgba(255,0,0,0.5)",
                                    highlightStroke: "rgba(255,0,0,1)",
                                    data: [5.1, 4.9, 4.9, 5.3, 6.0, 6.7, 7.1, 6.9, 7.3, 8.0, 7.8, 6.6, 5.6, 5.2, 4.3, 3.3, 2.5, 1.6, 0.7]

                                }
                            ]
                        };

                        function load() {
                            var ctx = document.getElementById("alterHistogramm").getContext("2d");
                            var alterChart = new Chart(ctx).Bar(data, options);
                        }
                        window.onload = load;

                    </script>

                </head>
                <body style="margin:2em">
                    <h2>BewohnerInnenstruktur / Altersdurchmischung</h2>

                    <ul>
                        <li>Grün - Prozentwerte der Giesserei (Anzahl Kinder: <strong>' . $this->getAnzahlKinder() . '</strong>, Anzahl Erwachsene: <strong>' . $this->getAnzahlErwachsene() . '</strong>)</li>
                        <li>Rot - Prozentwerte der Schweiz</li>
                    </ul>

                    <canvas id="alterHistogramm" width="700" height="400"></canvas>

                    <br/>
                    (Quelle: Bundesverwaltung admin.ch, 2014)
                </body>
            </html>
        ';
        echo $html;

        return true;
    }

    /**
     * Liefert die Prozentwerte zu den Altersklassen.
     *
     * @return string
     */
	public function getAlterKlassenWerte()
    {
	    $alterKlassen = $this->getProzentKinder(0, 4);
        $alterKlassen .= ", " . $this->getProzentKinder(5, 9);
        $alterKlassen .= ", " . $this->getProzentKinder(10, 14);
        // Überschneidung der Altersklassen
        $alterKlassen .= ", " . ($this->getProzentKinder(15, 19) + $this->getProzentErwachsene(15, 19));
        $alterKlassen .= ", " . $this->getProzentErwachsene(20, 24);
        $alterKlassen .= ", " . $this->getProzentErwachsene(25, 29);
        $alterKlassen .= ", " . $this->getProzentErwachsene(30, 34);
        $alterKlassen .= ", " . $this->getProzentErwachsene(35, 39);
        $alterKlassen .= ", " . $this->getProzentErwachsene(40, 44);
        $alterKlassen .= ", " . $this->getProzentErwachsene(45, 49);
        $alterKlassen .= ", " . $this->getProzentErwachsene(50, 54);
        $alterKlassen .= ", " . $this->getProzentErwachsene(55, 59);
        $alterKlassen .= ", " . $this->getProzentErwachsene(60, 64);
        $alterKlassen .= ", " . $this->getProzentErwachsene(65, 69);
        $alterKlassen .= ", " . $this->getProzentErwachsene(70, 74);
        $alterKlassen .= ", " . $this->getProzentErwachsene(75, 79);
        $alterKlassen .= ", " . $this->getProzentErwachsene(80, 84);
        $alterKlassen .= ", " . $this->getProzentErwachsene(85, 89);
        $alterKlassen .= ", " . $this->getProzentErwachsene(90, 94);

        return $alterKlassen;
    }

    private function getProzentErwachsene($alterVon, $alterBis)
    {
        $db = JFactory::getDBO();
        $query = "
            SELECT ROUND(count(*) * 100 / ((
                SELECT count(*) FROM #__mgh_mitglied
                WHERE typ = 1 AND (austritt = '0000-00-00' OR austritt > NOW())
            ) + (
                SELECT count(*) FROM #__mgh_kind
            )), 1) prozent
            FROM #__mgh_mitglied
            WHERE typ = 1
                AND (austritt = '0000-00-00' OR austritt > NOW())
                AND (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                AND (YEAR(NOW()) - jahrgang) <= " . $alterBis . "
        ";
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getProzentKinder($alterVon, $alterBis)
    {
        $db = JFactory::getDBO();
        $query = "
            SELECT ROUND(count(*) * 100 / ((
                SELECT count(*) FROM #__mgh_mitglied
                WHERE typ = 1 AND (austritt = '0000-00-00' OR austritt > NOW())
            ) + (
                SELECT count(*) FROM #__mgh_kind
            )), 1) prozent
            FROM #__mgh_kind
            WHERE (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                AND (YEAR(NOW()) - jahrgang) <= " . $alterBis . "
        ";
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlErwachsene()
    {
        $db = JFactory::getDBO();
        $query = "
            SELECT count(*) FROM #__mgh_mitglied
            WHERE typ = 1 AND (austritt = '0000-00-00' OR austritt > NOW())";
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlKinder()
    {
        $db = JFactory::getDBO();
        $query = "SELECT count(*) FROM #__mgh_kind";
        $db->setQuery($query);
        return $db->loadResult();
    }
}
