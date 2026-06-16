{{-- resources/views/emails/internship-application-received.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Riset</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: #333;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
    }

    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
      font-weight: bold;
    }

    .header p {
      margin: 10px 0 0 0;
      font-size: 16px;
      opacity: 0.9;
    }

    .content {
      padding: 40px 30px;
    }

    .greeting {
      font-size: 18px;
      margin-bottom: 20px;
      color: #2d3748;
    }

    .message {
      background-color: #f7fafc;
      border-left: 4px solid #4299e1;
      text-align: justify;
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 8px 8px 0;
    }

    .details {
      background-color: #edf2f7;
      padding: 20px;
      border-radius: 8px;
      margin: 25px 0;
    }

    .details h3 {
      margin-top: 0;
      color: #2d3748;
      font-size: 16px;
    }

    .detail-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      padding-bottom: 8px;
      border-bottom: 1px solid #cbd5e0;
    }

    .detail-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .detail-label {
      font-weight: 600;
      color: #4a5568;
    }

    .detail-value {
      color: #2d3748;
    }

    .next-steps {
      background: linear-gradient(135deg, #4fd1c7 0%, #06bcc1 100%);
      color: white;
      padding: 25px;
      border-radius: 8px;
      margin: 25px 0;
    }

    .next-steps h3 {
      margin-top: 0;
      font-size: 18px;
    }

    .next-steps ul {
      margin: 15px 0 0 0;
      padding-left: 20px;
    }

    .next-steps li {
      margin-bottom: 8px;
    }

    .contact-info {
      background-color: #fff5f5;
      border: 1px solid #feb2b2;
      padding: 20px;
      border-radius: 8px;
      margin: 25px 0;
    }

    .contact-info h3 {
      margin-top: 0;
      color: #c53030;
    }

    .footer {
      background-color: #edf2f7;
      padding: 30px;
      text-align: center;
      font-size: 14px;
      color: #718096;
    }

    .footer a {
      color: #4299e1;
      text-decoration: none;
    }

    .btn {
      display: inline-block;
      padding: 12px 24px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      margin: 20px 0;
      transition: transform 0.2s;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    @media (max-width: 600px) {
      .email-container {
        margin: 0;
        border-radius: 0;
      }

      .header,
      .content,
      .footer {
        padding: 20px;
      }

      .detail-item {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>

<body>
  <div class="email-container">
    <!-- Header -->
    <div class="header">
      <h1>🎉 Pendaftaran Berhasil!</h1>
      <p>Terima kasih telah mendaftar program kolaborasi riset kami</p>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Greeting -->
      <div class="greeting">
        <strong>Halo, {{ $pendaftaran->nama }}</strong>
      </div>

      <!-- Main Message -->
      <div class="message">
        <p>Pendaftaran Anda untuk program kolaborasi riset telah berhasil kami terima dan sedang dalam
          proses review oleh tim kami.</p>
        <p>Kami akan menghubungi Anda dalam <strong>3-5 hari kerja</strong> untuk informasi lebih lanjut mengenai
          tahapan berikutnya.</p>
      </div>

      <!-- Application Details -->
      <div class="details">
        <h3>📋 Detail Pendaftaran Anda :</h3>
        <div class="detail-item">
          <span class="detail-label">Nama Lengkap :&nbsp;</span> <span class="detail-value">
            {{ $pendaftaran->nama }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Judul Riset/Penelitian :&nbsp;</span> <span class="detail-value">
            {{ $pendaftaran->judul_riset }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Email :&nbsp;</span> <span class="detail-value"> {{ $pendaftaran->email }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">No. WhatsApp :&nbsp;</span> <span class="detail-value">
            {{ $pendaftaran->no_hp }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Tanggal Pendaftaran :&nbsp;</span> <span class="detail-value">
            {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d-m-Y | H:i') }}
            WIB</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Status :&nbsp;</span> <span class="detail-value"> 📝
            {{ Str::ucfirst($pendaftaran->status) }}</span>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="contact-info">
        <h3>📞 Butuh Bantuan?</h3>
        <p>Jika Anda memiliki pertanyaan mengenai proses pendaftaran, jangan ragu untuk menghubungi kami :</p>
        <p>
          <strong>Email :</strong> <a href="mailto:info@company.com">info@company.com</a><br>
          <strong>WhatsApp :</strong> <a href="https://wa.me/6281234567890">+62 812 3456 7890</a><br>
          <strong>Jam Operasional :</strong> Senin - Jumat, 09:00 - 17:00 WIB
        </p>
      </div>

      <!-- Additional Info -->
      <div
        style="background-color: #fffbf0; border: 1px solid #f6e05e; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 0; font-size: 14px; color: #744210;">
          <strong>💡 Tips:</strong> Pastikan email dan nomor WhatsApp Anda selalu aktif selama proses pendaftaran.
          Kami akan mengirimkan update status melalui email ini.
        </p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>Email ini dikirim secara otomatis dari sistem kami.</p>
      <p>
        © {{ date('Y') }} Pojok Literasi Statistik. All rights reserved.<br>
        <a href="{{ route('home') }}">Kunjungi Website Kami</a>
      </p>
      <p style="font-size: 12px; margin-top: 15px;">
        Jika Anda tidak mendaftar untuk program magang ini, silakan abaikan email ini atau
        <a href="mailto:info@company.com">hubungi kami</a>.
      </p>
    </div>
  </div>
</body>

</html>
