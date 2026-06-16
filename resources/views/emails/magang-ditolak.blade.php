<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemberitahuan Status Pendaftaran Magang</title>
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
      color: #ef4444;
      margin: 0;
    }

    .content {
      margin-bottom: 30px;
    }

    .highlight {
      background-color: #fef2f2;
      padding: 15px;
      border-radius: 5px;
      border-left: 4px solid #ef4444;
      margin: 20px 0;
    }

    .encouragement {
      background-color: #f0f9ff;
      padding: 15px;
      border-radius: 5px;
      border-left: 4px solid #3b82f6;
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
      <h1>Pemberitahuan Status Pendaftaran</h1>
    </div>

    <div class="content">
      <p>Halo <strong>{{ $pendaftaran->nama }}</strong>,</p>

      <p>Terima kasih atas minat Anda untuk bergabung dengan program magang kami.</p>

      <div class="highlight">
        <p>Setelah melalui proses seleksi yang ketat, kami dengan berat hati harus menginformasikan bahwa aplikasi
          magang Anda <strong>belum dapat kami terima</strong> pada periode ini.</p>
      </div>

      <p><strong>Detail Pendaftaran:</strong></p>
      <ul>
        <li>Nama: {{ $pendaftaran->nama }}</li>
        <li>Email: {{ $pendaftaran->email }}</li>
        <li>No. HP: {{ $pendaftaran->no_hp }}</li>
        <li>Status: <span style="color: #ef4444; font-weight: bold;">TIDAK DITERIMA</span></li>
      </ul>

      <div class="encouragement">
        <p><strong>Jangan berkecil hati!</strong></p>
        <p>Keputusan ini tidak mengurangi potensi dan kemampuan Anda. Kami mendorong Anda untuk:</p>
        <ul>
          <li>Terus mengembangkan kemampuan dan keterampilan</li>
          <li>Mencoba mendaftar lagi di periode selanjutnya</li>
          <li>Mencari kesempatan magang di tempat lain</li>
          <li>Tetap semangat dalam mengejar tujuan karier Anda</li>
        </ul>
      </div>

      <p>Kami menghargai waktu dan usaha yang Anda investasikan dalam proses aplikasi ini. Tetap semangat dan sukses
        selalu!</p>

      <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Sistem Pendaftaran Magang - Pojok Literasi Statistik</p>
    </div>
  </div>
</body>

</html>
