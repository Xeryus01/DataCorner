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
      color: #10b981;
      margin: 0;
    }

    .content {
      margin-bottom: 30px;
    }

    .highlight {
      background-color: #dcfce7;
      padding: 15px;
      border-radius: 5px;
      border-left: 4px solid #10b981;
      margin: 20px 0;
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
      <h1>🎉 Selamat!</h1>
    </div>

    <div class="content">
      <p>Halo <strong>{{ $pendaftaran->nama }}</strong>,</p>

      <div class="highlight">
        <p><strong>Pendaftaran magang Anda telah DITERIMA!</strong></p>
      </div>

      <p>Kami dengan senang hati mengumumkan bahwa aplikasi magang Anda telah disetujui. Selamat atas pencapaian ini!
      </p>

      <p><strong>Detail Pendaftaran:</strong></p>
      <ul>
        <li>Nama : {{ $pendaftaran->nama }}</li>
        <li>Email : {{ $pendaftaran->email }}</li>
        <li>No. HP : {{ $pendaftaran->no_hp }}</li>
        <li>Status : <span style="color: #10b981; font-weight: bold;">DITERIMA</span></li>
      </ul>

      <p>Tim kami akan segera menghubungi Anda melalui email atau telepon untuk memberikan informasi lebih lanjut
        mengenai:</p>
      <ul>
        <li>Jadwal orientasi</li>
        <li>Dokumen yang perlu disiapkan</li>
        <li>Lokasi dan waktu mulai magang</li>
        <li>Informasi penting lainnya</li>
      </ul>

      <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>

      <p>Sekali lagi, selamat dan kami menantikan kehadiran Anda!</p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Sistem Pendaftaran Magang - Pojok Literasi Statistik</p>
    </div>
  </div>
</body>

</html>
