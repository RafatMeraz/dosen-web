<html>

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
    </script>
