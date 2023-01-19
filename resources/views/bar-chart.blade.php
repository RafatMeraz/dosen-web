<html>

<head>
</head>
<style>
    /* Center tables for demo */
    table {
        margin: 0 auto;
    }

    /* Default Table Style */
    table {
        color: #333;
        background: white;
        border: 1px solid grey;
        font-size: 12pt;
        border-collapse: collapse;
        width: 100%;
    }

    table thead th,
    table tfoot th {
        color: #777;
        background: rgba(0, 0, 0, .1);
    }

    table caption {
        padding: .5em;
    }

    table th,
    table td {
        padding: .5em;
        border: 1px solid lightgrey;
    }

    /* Zebra Table Style */
    [data-table-theme*=zebra] tbody tr:nth-of-type(odd) {
        background: rgba(0, 0, 0, .05);
    }

    [data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {
        background: rgba(255, 255, 255, .05);
    }

    /* Dark Style */
    [data-table-theme*=dark] {
        color: #ddd;
        background: #333;
        font-size: 12pt;
        border-collapse: collapse;
    }

    [data-table-theme*=dark] thead th,
    [data-table-theme*=dark] tfoot th {
        color: #aaa;
        background: rgba(0255, 255, 255, .15);
    }

    [data-table-theme*=dark] caption {
        padding: .5em;
    }

    [data-table-theme*=dark] th,
    [data-table-theme*=dark] td {
        padding: .5em;
        border: 1px solid grey;
    }
</style>

<body>
    <div style="width: 100%; text-align: center;">
        <h3 style="margin-bottom: 7px;">Shop Visits Report</h3>
        <p style="margin-top: 0px;">{{ $date }}</p>
    </div>
    <br>

    @foreach ($allData as $data)
        <table>
            <thead>
                <tr>
                    <td colspan="2"><b>User: </b> {{ $data['user']->name }},@if(isset($data['user']->division_id))  <b>Division:</b> {{ \DB::table('divisions')->find($data['user']->division_id)->name }} @endif </td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 30%;">Shop</th>
                    <th style="width: 10%;">Total Visits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['dataSet'] as $sData)
                    <tr>
                        <th style="text-align: left; width: 30%; font-weight: normal;">{{ $sData[0] }}</th>
                        <th style="width: 10%; font-weight: normal;">{{ $sData[1] }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    @endforeach
</body>

</html>












{{-- <html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        var dataSets = {!! json_encode($dataSet) !!};
        dataSets[0].push({
            role: 'annotation'
        });
        // console.log(dataSets);

        google.charts.load("current", {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(dataSets);

            var options = {
                title: "Shop Counter Data Chart",
                legend: 'none',
                isStacked: true,
            };

            var chart_div = document.getElementById('chart_div');
            var chart = new google.visualization.ColumnChart(chart_div);

            // Wait for the chart to finish drawing before calling the getImageURI() method.
            google.visualization.events.addListener(chart, 'ready', function() {
                chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';

                Convert_HTML_To_PDF();

            });

            chart.draw(data, options);

        }
    </script>

    <div id='chart_div' style="height: 840px; width: 875px;"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        window.jsPDF = window.jspdf.jsPDF;

        // Convert HTML content to PDF
        function Convert_HTML_To_PDF() {
            var doc = new jsPDF();

            // Source HTMLElement or a string containing HTML.
            var elementHTML = document.querySelector("#chart_div");

            doc.html(elementHTML, {
                callback: function(doc) {
                    // Save the PDF
                    doc.save('document-html.pdf');
                },
                margin: [10, 10, 10, 10],
                autoPaging: 'text',
                x: 0,
                y: 0,
                width: 150, //target width in the PDF document
                windowWidth: 675 //window width in CSS pixels
            });
        }
    </script> --}}
