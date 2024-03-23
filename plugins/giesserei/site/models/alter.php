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
                                    data: genSwissStatsData()
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


                        function genSwissStatsData() {
                           // Resultat Stand 2014 (bis 2022-03-28 verwendet):
                           //  const oldData2014 = [5.1, 4.9, 4.9, 5.3, 6.0, 6.7, 7.1, 6.9, 7.3, 8.0, 7.8, 6.6, 5.6, 5.2, 4.3, 3.3, 2.5, 1.6, 0.7];
                           // Quelle: https://www.bfs.admin.ch/bfs/de/home/statistiken/bevoelkerung.html
                           //         https://www.bfs.admin.ch/bfs/de/home/statistiken/bevoelkerung.assetdetail.18424668.html
                           //          Link "STAT-TAB", Jahr waehlen, Alter alle, Bestand am 31. Dez., JSON-Export, Werte aus JSON extrahieren
                           // Struktur: Gesamt-Anzahl, Alter 0, Alter 1, ... Alter 98, Alter >= 99, Alter unbekannt (immer 0)
                           // Stand 31.12.2014
                           //    const statData= [8237666,83730,83494,83897,82976,84198,82637,82082,80602,79807,79631,79626,78370,79465,79805,84661,84237,85664,87128,90369,91373,93302,95596,100536,103338,105541,106422,110123,109260,112188,113451,115063,114796,117620,117166,117803,114646,113408,113520,112829,112317,114969,115627,119165,123116,124883,128140,131074,132348,135157,135381,137385,133323,128126,123612,120169,116355,111835,108928,105395,100950,97474,93958,92790,88729,90535,88082,88411,86626,85862,81575,79860,76403,72359,67018,61086,58771,56078,52924,51759,50050,47388,44048,41857,38737,36471,32630,29283,25534,22974,19733,16766,13772,10983,8982,6533,4184,2901,2016,1430,2479,0]
                           // Stand 31.12.2020
                           const statData = [8670300,84374,86267,88408,88343,89726,89089,88843,87050,87817,86886,88123,86771,86290,84505,83779,83528,83495,82275,84863,85869,91781,91899,94606,98165,101730,103391,106951,111364,117703,120544,123399,123312,125806,123335,124607,124565,124621,123553,125613,124419,124293,120596,119017,118364,117348,116590,118719,118960,122118,125472,126614,129574,131663,132408,134350,134009,135357,130537,124810,119787,115194,110830,105694,102294,98367,93072,89445,86013,84991,81393,82979,80954,81087,79224,77971,73785,71402,67781,63347,57937,51610,48820,45494,41832,39330,36479,33042,29164,26047,22442,19518,15747,12752,9962,7797,5857,4322,3010,1994,3070,0];
                           //
                           const totalCount = statData[0];
                           const clusterPercents = new Array(19);
                           for (let i = 0; i < 19; i++) {
                              const clusterLen = (i < 18) ? 5 : 10;
                              let sum = 0;
                              for (let j = 0; j < clusterLen; j++) {
                                 sum += statData[1 + i * 5 + j]; }
                              clusterPercents[i] = Math.round(sum / totalCount * 1000) / 10; }
                           return clusterPercents; }

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
                        <li>Rot - Prozentwerte der Schweiz <small>(Quelle: <a href="https://www.bfs.admin.ch/bfs/de/home/statistiken/bevoelkerung.assetdetail.18424668.html">Bundesamt f&uuml;r Statistik</a>, Stand 31.12.2020)</small></li>
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
            WHERE typ in (" . $typen . ") AND (austritt is null OR austritt > NOW())";

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
