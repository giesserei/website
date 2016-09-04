<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelAlter extends JModelLegacy
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

                        var options1 = {
                            // Boolean - If we want to override with a hard coded scale
                            scaleOverride: true,

                            // ** Required if scaleOverride is true **
                            // Number - The number of steps in a hard coded scale
                            scaleSteps: 6,
                            // Number - The value jump in the hard coded scale
                            scaleStepWidth: 2,
                            // Number - The scale starting value
                            scaleStartValue: 0,

                            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                            scaleBeginAtZero : true,

                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : true,

                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(0,0,0,.4)",

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

                        var data1 = {
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

                        var options2 = {
                            // Boolean - If we want to override with a hard coded scale
                            scaleOverride: true,

                            // ** Required if scaleOverride is true **
                            // Number - The number of steps in a hard coded scale
                            scaleSteps: 7,
                            // Number - The value jump in the hard coded scale
                            scaleStepWidth: 5,
                            // Number - The scale starting value
                            scaleStartValue: 0,

                            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                            scaleBeginAtZero : true,

                            //Boolean - Whether grid lines are shown across the chart
                            scaleShowGridLines : true,

                            //String - Colour of the grid lines
                            scaleGridLineColor : "rgba(0,0,0,.4)",

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

                        var data2 = {
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
                                    data: [' . $this->getAlterKlassenWerteAbs() . ']
                                }
                            ]
                        };

                        function load() {
                            var ctx1 = document.getElementById("alterHistogramm").getContext("2d");
                            var alterChart1 = new Chart(ctx1).Bar(data1, options1);

                            var ctx2 = document.getElementById("alterHistogrammAbs").getContext("2d");
                            var alterChart2 = new Chart(ctx2).Bar(data2, options2);
                        }
                        window.onload = load;

                    </script>

                </head>
                <body style="margin:2em">
                    <h2>BewohnerInnenstruktur / Altersdurchmischung prozentual</h2>

                    <ul>
                        <li>Grün - Prozentwerte der Giesserei <small>(Anzahl Kinder: <strong>' . $this->getAnzahlKinder() . '</strong>, Anzahl Erwachsene: <strong>' . $this->getAnzahlErwachsene() . '</strong>)</small></li>
                        <li>Rot - Prozentwerte der Schweiz <small>(Quelle: Bundesverwaltung admin.ch, 2014)</small></li>
                    </ul>

                    <canvas id="alterHistogramm" width="700" height="250"></canvas>

                    <h2>BewohnerInnenstruktur / Altersdurchmischung absolut</h2>

                    <canvas id="alterHistogrammAbs" width="700" height="250"></canvas>

                    <p />

                    <h3>Zahlenwerk für interne Zwecke</h3>

                    <table style="border:0; font-weight:normal; color:rgba(0,0,0,0.5);">
                        <tr>
                            <th>Gruppe</th>
                            <th>Absolut</th>
                            <th>Prozent</th>
                        </tr>
                        <tr>
                            <th>0-19</th>
                            <th>' . ($this->getAnzahlKinder(0, 19) + $this->getAnzahlErwachsene(0, 19)) . '</th>
                            <th>' . ($this->getProzentKinder(0, 19) + $this->getProzentErwachsene(0, 19)) . '</th>
                        </tr>
                        <tr>
                            <th>20-64</th>
                            <th>' . ($this->getAnzahlKinder(20, 64) + $this->getAnzahlErwachsene(20, 64)) . '</th>
                            <th>' . ($this->getProzentKinder(20, 64) + $this->getProzentErwachsene(20, 64)) . '</th>
                        </tr>
                        <tr>
                            <th>65+</th>
                            <th>' . $this->getAnzahlErwachsene(65, 100) . '</th>
                            <th>' . $this->getProzentErwachsene(65, 100) . '</th>
                        </tr>
                    </table>
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
    private function getAlterKlassenWerte()
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

    /**
     * Liefert die Prozentwerte zu den Altersklassen.
     *
     * @return string
     */
    private function getAlterKlassenWerteAbs()
    {
        $alterKlassen = $this->getAnzahlKinder(0, 4);
        $alterKlassen .= ", " . $this->getAnzahlKinder(5, 9);
        $alterKlassen .= ", " . $this->getAnzahlKinder(10, 14);
        // Überschneidung der Altersklassen
        $alterKlassen .= ", " . ($this->getAnzahlKinder(15, 19) + $this->getAnzahlErwachsene(15, 19));
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(20, 24);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(25, 29);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(30, 34);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(35, 39);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(40, 44);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(45, 49);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(50, 54);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(55, 59);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(60, 64);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(65, 69);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(70, 74);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(75, 79);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(80, 84);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(85, 89);
        $alterKlassen .= ", " . $this->getAnzahlErwachsene(90, 94);

        return $alterKlassen;
    }

    private function getProzentErwachsene($alterVon, $alterBis)
    {
        $db = JFactory::getDBO();
        $query = "
            SELECT ROUND(count(*) * 100 / ((
                SELECT count(*) FROM #__mgh_mitglied
                WHERE typ = 1 AND (austritt = '0000-00-00' OR austritt > NOW())
                  AND jahrgang IS NOT NULL AND jahrgang > 0
            ) + (
                SELECT count(*) FROM #__mgh_kind
            )), 1) prozent
            FROM #__mgh_mitglied
            WHERE typ = 1
                AND (austritt = '0000-00-00' OR austritt > NOW())
                AND (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
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
                  AND jahrgang IS NOT NULL AND jahrgang > 0
            ) + (
                SELECT count(*) FROM #__mgh_kind
            )), 1) prozent
            FROM #__mgh_kind
            WHERE (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlErwachsene($alterVon = null, $alterBis = null)
    {
        $db = JFactory::getDBO();
        $query = "
            SELECT count(*) FROM #__mgh_mitglied
            WHERE typ = 1 AND (austritt = '0000-00-00' OR austritt > NOW())
              AND jahrgang IS NOT NULL AND jahrgang > 0"; // Jahrgang ist nicht immer erfasst

        if (!is_null($alterVon))
        {
            $query .= " AND (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                        AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
        }

        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlKinder($alterVon = null, $alterBis = null)
    {
        $db = JFactory::getDBO();
        $query = "SELECT count(*) FROM #__mgh_kind";

        if (!is_null($alterVon))
        {
            $query .= " WHERE (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                        AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
        }

        $db->setQuery($query);
        return $db->loadResult();
    }

}
