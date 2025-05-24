<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->report_type }} - {{ $report->period }}</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Base Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        /* Content Styles */
        .content {
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .section-content {
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        /* Footer Styles */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $report->report_type }}</h1>
        <p>Periode: {{ $report->period }}</p>
        <p>Tanggal Dibuat: {{ Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Informasi Laporan</div>
            <div class="section-content">
                <table>
                    <tr>
                        <th>Jenis Laporan</th>
                        <td>{{ $report->report_type }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $report->period }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diperbarui</th>
                        <td>{{ Carbon\Carbon::parse($report->updated_at)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Isi Laporan</div>
            <div class="section-content">
                {!! $report->report_content !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}</p>
        <p>Simpratja - Sistem Informasi Manajemen Praktek Kerja</p>
    </div>
</body>

</html>
