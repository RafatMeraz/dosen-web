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
    <table>
        <thead>
            <tr>
                <th style="text-align: left; width: 30%;">Shop</th>
                <th style="width: 10%;">Total Visits</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataSet as $data)
                <tr>
                    <th style="text-align: left; width: 30%; font-weight: normal;">{{ $data[0] }}</th>
                    <th style="width: 10%; font-weight: normal;">{{ $data[1] }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
