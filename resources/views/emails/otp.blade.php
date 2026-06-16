<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Kode OTP Verifikasi Akun</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: black;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
    }

    p {
      text-align: center;
      margin: 20px 0;
      font-size: 14px;
    }

    h1 {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    .footer {
      background-color: #edf2f7;
      text-align: center;
      font-size: 12px;
      color: #718096;
      margin-top: 20px;
      padding: 10px;
    }
  </style>
</head>

<body>
  <p>Halo, Kode OTP verifikasi akun kamu adalah :</p>
  <h1>{{ $otp }}</h1>
  <p>Kode di atas hanya berlaku selama 3 menit. Harap segera masukkan untuk verifikasi akun Anda.</p>
  <p>Demi kerahasiaan data Anda, mohon tidak membagikan kode ini kepada orang lain.</p>

  <!-- Footer -->
  <div class="footer">
    <p>Email ini dikirim secara otomatis dari sistem kami.
    </p>
    <p>
      © {{ date('Y') }} Pojok Literasi Statistik. All rights reserved.
    </p>
  </div>
</body>

</html>
