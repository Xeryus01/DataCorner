<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Magang Diterima</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      color: #333;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f4f4f4;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: white;
      margin: 0;
    }

    .content {
      margin-bottom: 30px;
    }

    .footer {
      text-align: center;
      color: #666;
      font-size: 14px;
      border-top: 1px solid #ddd;
      padding-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Sertifikat Kolaborasi Riset Tersedia!</h1>
    </div>

    <div class="content">
      <h2>Halo, {{ $pendaftaran->nama }}</h2>

      <p>Sertifikat kolaborasi riset Anda sudah tersedia. Silahkan diunduh di halaman Kolaborasi Riset Mandiri pada
        website atau unduh melalui link berikut:</p>

      <p><a href="{{ url('storage/' . $pendaftaran->sertifikat_riset) }}" target="_blank">Unduh Sertifikat</a></p>

      <p>Terima kasih.</p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Sistem Pendaftaran Magang - Pojok Literasi Statistik</p>
    </div>
  </div>
</body>

</html>
