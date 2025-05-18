<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Antrian Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .clinic-name {
            font-weight: bold;
            font-size: 14pt;
        }

        .clinic-address {
            font-size: 10pt;
            margin-top: 5px;
        }

        .clinic-contact {
            font-size: 10pt;
            margin-top: 5px;
        }

        .divider {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        .patient-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            width: 120px;
            font-weight: normal;
        }

        .info-value {
            flex: 1;
        }

        .queue-number {
            text-align: center;
            margin: 20px 0;
        }

        .queue-number-label {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 10px;
        }

        .queue-number-value {
            font-size: 48pt;
            font-weight: bold;
        }

        .footer {
            font-size: 10pt;
            text-align: center;
            margin-top: 15px;
        }

        .note {
            font-style: italic;
            font-size: 10pt;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <div class="clinic-name">Praktek Umum dr. Purwito Adisunu</div>
            </div>
            <div class="clinic-address">Gandrungmanis Lor, Gandrungmanis, Kec.Gandrungmangu, Kab. Cilacap, Jawa Tengah
                53254</div>
            <div class="clinic-contact">Telepon : 0813-9014-82226<br>Website : https://simpratja.co.id/</div>
        </div>

        <div class="patient-info">
            <div class="info-row">
                <div class="info-label">Nomor Reg</div>
                <div class="info-value">= {{ $regNumber }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value">= {{ $patientName }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Dokter</div>
                <div class="info-value">= {{ $docterName }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Alamat</div>
                <div class="info-value">= {{ $address }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tgl Daftar</div>
                <div class="info-value">= {{ $registerDate }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tgl Periksa</div>
                <div class="info-value">= {{ $examDate }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="queue-number">
            <div class="queue-number-label">NOMOR ANTRIAN ANDA</div>
            <div class="queue-number-value">{{ $queueNumber }}</div>
        </div>

        <div class="divider"></div>

        <div class="note">
            Mohon diperhatikan demi kenyamanan pasien ANTRIAN tidak berlaku (dilewat), jika pasien datang TIDAK SESUAI
            jadwal rencana kunjungan.
        </div>

        <div class="footer">
            Untuk PASIEN BARU diharapkan membawa kartu identitas berupa KTP atau KK.
        </div>
    </div>
</body>

</html>