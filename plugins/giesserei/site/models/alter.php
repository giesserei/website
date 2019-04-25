<?php
defined('_JEXEC') or die('Restricted access');

class GiessereiModelAlter extends JModelLegacy
{

    var $totalKinder;
    var $totalJugendmitglieder;
    var $totalErwachsene;
    var $totalAlle;

    /**
     * Liefert das gesamte HTML für Darstellung der Altersstruktur als HTML5.
     *
     * @return string
     */
    public function getAlterKlassenHtml5()
    {
        JResponse::setHeader('Content-Type', 'text/html');

        $this->totalKinder           = $this->getAnzahlKinder();
        $this->totalJugendmitglieder = $this->getAnzahlJugendmitglieder();
        $this->totalErwachsene       = $this->getAnzahlErwachsene();
        $this->totalAlle             = $this->totalKinder + $this->totalJugendmitglieder + $this->totalErwachsene;

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
                                     "80-84 J.", "85-89 J.", "ab 90 J."],
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
                                     "80-84 J.", "85-89 J.", "ab 90 J."],
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
                        <li>Grün - Prozentwerte der Giesserei
                            <small>
                               (Anzahl Kinder: <strong>' . $this->totalKinder . '</strong>,
                               Anzahl Jugendmitglieder: <strong>' . $this->totalJugendmitglieder . '</strong>,
                               Anzahl Erwachsene: <strong>' . $this->totalErwachsene . '</strong>)
                            </small>
                        </li>
                        <li>Rot - Prozentwerte der Schweiz <small>(Quelle: Bundesverwaltung admin.ch, 2014)</small></li>
                    </ul>

                    <canvas id="alterHistogramm" width="700" height="250"></canvas>

                    <h2>BewohnerInnenstruktur / Altersdurchmischung absolut</h2>

                    <canvas id="alterHistogrammAbs" width="700" height="250"></canvas>

                    <p />

                    <h3>Zahlenwerk für interne Zwecke</h3>

                    <table style="border: 0; font-weight: normal; color: #444; text-align: center;">
                        <tr>
                            <th>Gruppe</th>
                            <th>Absolut</th>
                            <th>Prozent</th>
                            <th>Kinder</th>
                            <th>Jugendmitglieder</th>
                            <th>Erwachsene</th>
                        </tr>
                        <tr>
                            <td>0-19</td>
                            <td>' . $this->getAnzahlAlle(0, 19) . '</td>
                            <td>' . $this->getProzentAlle(0, 19) . '</td>
                            <td>' . $this->getAnzahlKinder(0, 19) . '</td>
                            <td>' . $this->getAnzahlJugendmitglieder(0, 19) . '</td>
                            <td>' . $this->getAnzahlErwachsene(0, 19) . '</td>
                        </tr>
                        <tr>
                            <td>20-64</td>
                            <td>' . $this->getAnzahlAlle(20, 64) . '</td>
                            <td>' . $this->getProzentAlle(20, 64) . '</td>
                            <td>' . $this->getAnzahlKinder(20, 64) . '</td>
                            <td>' . $this->getAnzahlJugendmitglieder(20, 64) . '</td>
                            <td>' . $this->getAnzahlErwachsene(20, 64) . '</td>
                        </tr>
                        <tr>
                            <td>65+</td>
                            <td>' . $this->getAnzahlAlle(65, 999) . '</td>
                            <td>' . $this->getProzentAlle(65, 999) . '</td>
                            <td>' . $this->getAnzahlKinder(65, 999) . '</td>
                            <td>' . $this->getAnzahlJugendmitglieder(65, 999) . '</td>
                            <td>' . $this->getAnzahlErwachsene(65, 999) . '</td>
                        </tr>
                        <tr>
                            <td>fehlt</td>
                            <td>-</td>
                            <td>-</td>
                            <td>' . $this->getAnzahlKinder(null, null, true) . '</td>
                            <td>' . $this->getAnzahlMitglieder(null, null, "11", true) . '</td>
                            <td>' . $this->getAnzahlMitglieder(null, null, "1", true) . '</td>
                        </tr>
                    </table>

                    <br>
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
        $alterKlassen =         $this->getProzentAlle(0, 4);
        $alterKlassen .= ", " . $this->getProzentAlle(5, 9);
        $alterKlassen .= ", " . $this->getProzentAlle(10, 14);
        $alterKlassen .= ", " . $this->getProzentAlle(15, 19);
        $alterKlassen .= ", " . $this->getProzentAlle(20, 24);
        $alterKlassen .= ", " . $this->getProzentAlle(25, 29);
        $alterKlassen .= ", " . $this->getProzentAlle(30, 34);
        $alterKlassen .= ", " . $this->getProzentAlle(35, 39);
        $alterKlassen .= ", " . $this->getProzentAlle(40, 44);
        $alterKlassen .= ", " . $this->getProzentAlle(45, 49);
        $alterKlassen .= ", " . $this->getProzentAlle(50, 54);
        $alterKlassen .= ", " . $this->getProzentAlle(55, 59);
        $alterKlassen .= ", " . $this->getProzentAlle(60, 64);
        $alterKlassen .= ", " . $this->getProzentAlle(65, 69);
        $alterKlassen .= ", " . $this->getProzentAlle(70, 74);
        $alterKlassen .= ", " . $this->getProzentAlle(75, 79);
        $alterKlassen .= ", " . $this->getProzentAlle(80, 84);
        $alterKlassen .= ", " . $this->getProzentAlle(85, 89);
        $alterKlassen .= ", " . $this->getProzentAlle(90, 999);

        return $alterKlassen;
    }

    /**
     * Liefert die Prozentwerte zu den Altersklassen.
     *
     * @return string
     */
    private function getAlterKlassenWerteAbs()
    {
        $alterKlassen =         $this->getAnzahlAlle(0, 4);
        $alterKlassen .= ", " . $this->getAnzahlAlle(5, 9);
        $alterKlassen .= ", " . $this->getAnzahlAlle(10, 14);
        $alterKlassen .= ", " . $this->getAnzahlAlle(15, 19);
        $alterKlassen .= ", " . $this->getAnzahlAlle(20, 24);
        $alterKlassen .= ", " . $this->getAnzahlAlle(25, 29);
        $alterKlassen .= ", " . $this->getAnzahlAlle(30, 34);
        $alterKlassen .= ", " . $this->getAnzahlAlle(35, 39);
        $alterKlassen .= ", " . $this->getAnzahlAlle(40, 44);
        $alterKlassen .= ", " . $this->getAnzahlAlle(45, 49);
        $alterKlassen .= ", " . $this->getAnzahlAlle(50, 54);
        $alterKlassen .= ", " . $this->getAnzahlAlle(55, 59);
        $alterKlassen .= ", " . $this->getAnzahlAlle(60, 64);
        $alterKlassen .= ", " . $this->getAnzahlAlle(65, 69);
        $alterKlassen .= ", " . $this->getAnzahlAlle(70, 74);
        $alterKlassen .= ", " . $this->getAnzahlAlle(75, 79);
        $alterKlassen .= ", " . $this->getAnzahlAlle(80, 84);
        $alterKlassen .= ", " . $this->getAnzahlAlle(85, 89);
        $alterKlassen .= ", " . $this->getAnzahlAlle(90, 999);

        return $alterKlassen;
    }

    private function getAnzahlMitglieder($alterVon = null, $alterBis = null, $typen = "1, 11", $ohneJahrgang = false)
    {
        $query = "
            SELECT count(*) FROM #__mgh_mitglied
            WHERE typ in (" . $typen . ") AND (austritt = '0000-00-00' OR austritt > NOW())";

        if ($ohneJahrgang) {
            $query .= " AND (jahrgang is null or jahrgang <= 0)";
        } else {
            $query .= " AND jahrgang > 0";
        }

        if (!is_null($alterVon))
        {
            $query .= " AND (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                        AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
        }

        $db = JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlJugendmitglieder($alterVon = null, $alterBis = null)
    {
        return $this->getAnzahlMitglieder($alterVon, $alterBis, "11");
    }

    private function getAnzahlErwachsene($alterVon = null, $alterBis = null)
    {
        return $this->getAnzahlMitglieder($alterVon, $alterBis, "1");
    }

    private function getAnzahlKinder($alterVon = null, $alterBis = null, $ohneJahrgang = false)
    {
        $query = "SELECT count(*) FROM #__mgh_kind WHERE ";

        if ($ohneJahrgang) {
            $query .= " (jahrgang is null or jahrgang <= 0)";
        } else {
            $query .= " jahrgang > 0";
        }

        if (!is_null($alterVon))
        {
            $query .= " AND (YEAR(NOW()) - jahrgang) >= " . $alterVon . "
                        AND (YEAR(NOW()) - jahrgang) <= " . $alterBis;
        }

        $db = JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function getAnzahlAlle($alterVon = null, $alterBis = null)
    {
       return $this->getAnzahlKinder($alterVon, $alterBis) + $this->getAnzahlMitglieder($alterVon, $alterBis);
    }

    private function getProzentAlle($alterVon, $alterBis)
    {
        return round(100 * $this->getAnzahlAlle($alterVon, $alterBis) / $this->totalAlle, 1);
    }

}
