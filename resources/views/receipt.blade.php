<!DOCTYPE html>
<html lang="id">

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

        header {
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

        .clinic-address,
        .clinic-contact {
            font-size: 10pt;
            margin-top: 5px;
        }

        .divider {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        section.patient-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: normal;
            width: 40%;
        }

        .info-value {
            flex: 1;
            text-align: left;
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

        footer {
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
        <header>
            <div class="logo-container">
                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
                <h1 class="clinic-name">SIMPRATJA</h1>
            </div>
            <address class="clinic-address">Gandrungmanis Lor, Gandrungmanis, Kec.Gandrungmangu, Kab. Cilacap, Jawa
                Tengah
                53254</address>
            <div class="clinic-contact">Telepon : 0813-9014-82226<br>Website : https://simpratja.co.id/</div>
        </header>

        <section class="patient-info">
            <article class="info-row">
                <span class="info-label">Nomor Reg</span>
                <span class="info-value">= {{ $regNumber }}</span>
            </article>
            <article class="info-row">
                <span class="info-label">Nama Pasien</span>
                <span class="info-value">= {{ $patientName }}</span>
            </article>
            <article class="info-row">
                <span class="info-label">Nama Dokter</span>
                <span class="info-value">= {{ $docterName }}</span>
            </article>
            <article class="info-row">
                <span class="info-label">Alamat</span>
                <span class="info-value">= {{ $address }}</span>
            </article>
            <article class="info-row">
                <span class="info-label">Tgl Daftar</span>
                <span class="info-value">= {{ $registerDate }}</span>
            </article>
            <article class="info-row">
                <span class="info-label">Tgl Periksa</span>
                <span class="info-value">= {{ $examDate }}</span>
            </article>
        </section>

        <div class="divider"></div>

        <section class="queue-number">
            <h2 class="queue-number-label">NOMOR ANTRIAN ANDA</h2>
            <p class="queue-number-value">{{ $queueNumber }}</p>
        </section>

        <div class="divider"></div>

        <section class="note">
            <p>
                Mohon diperhatikan demi kenyamanan pasien ANTRIAN tidak berlaku (dilewat), jika pasien datang TIDAK
                SESUAI
                jadwal rencana kunjungan.
            </p>
        </section>

        <footer>
            <p>Untuk PASIEN BARU diharapkan membawa kartu identitas berupa KTP atau KK.</p>
        </footer>
    </div>
</body>

</html>
