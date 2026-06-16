<x-layout-web>
  <div class="max-w-4xl mx-auto my-10 p-6 bg-white rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4 text-orange-600">Simulasi Distribusi Sampling</h2>

    <form method="POST" action="{{ route('simulasi.sampling.run') }}">
      @csrf
      <div class="grid grid-cols-1 gap-4 mb-4">
        <div>
          <label class="font-semibold">Populasi (pisahkan dengan koma)</label>
          <textarea id="populasiInput" name="populasi" class="w-full p-2 border rounded mt-1" rows="3" placeholder="Contoh: 70,80,90,85,60,95,100">{{ old('populasi', $populasiInput ?? '') }}</textarea>
          <div id="populasiError" class="text-red-500 text-sm mt-1" role="alert" aria-live="polite">
            @error('populasi')
              {{ $message }}
            @enderror
          </div>
         
        </div>
        <div>
          <label class="font-semibold">Ukuran Sample</label>
          <input id="ukuranSampleInput" type="number" name="ukuran_sample" class="w-full p-2 border rounded mt-1"
            value="{{ old('ukuran_sample', $ukuranSample ?? 3) }}">
          <div id="ukuranSampleError" class="text-red-500 text-sm mt-1">@error('ukuran_sample'){{ $message }}@enderror</div>
        </div>
        <div>
          <label class="font-semibold">Jumlah Pengulangan</label>
          <input id="jumlahPengulanganInput" type="number" name="jumlah_pengulangan" class="w-full p-2 border rounded mt-1"
            value="{{ old('jumlah_pengulangan', $jumlahPengulangan ?? 5) }}">
          <div id="jumlahPengulanganError" class="text-red-500 text-sm mt-1">@error('jumlah_pengulangan'){{ $message }}@enderror</div>
        </div>
      </div>
      <button class="bg-primary text-white px-4 py-2 rounded hover:bg-[#00295A] transition">Jalankan
        Simulasi</button>
    </form>

    @if (isset($hasilSimulasi))
      <div class="mt-8">
        <h3 class="text-xl font-semibold mb-2 text-gray-700">Hasil Simulasi ({{ $jumlahPengulangan }} kali)</h3>
        <table class="w-full table-auto border border-gray-300 mt-2 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">Pengulangan Ke</th>
              <th class="border px-4 py-2">Sample</th>
              <th class="border px-4 py-2">Mean</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($hasilSimulasi as $hasil)
              <tr>
                <td class="border px-4 py-2 text-center">{{ $hasil['ke'] }}</td>
                <td class="border px-4 py-2 text-center">{{ implode(', ', $hasil['sample']) }}</td>
                <td class="border px-4 py-2 text-center text-blue-600 font-semibold">{{ $hasil['mean'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <x-footer class="fill-[#EEF0F2]" />
  <script>
    (function () {
      // Client-side validation for sampling form
      const form = document.querySelector('form[action="{{ route('simulasi.sampling.run') }}"]');
      if (!form) return;

      function clearErrors() {
        const ids = ['populasiError', 'populasiWarning', 'ukuranSampleError', 'jumlahPengulanganError'];
        ids.forEach(id => { const el = document.getElementById(id); if (el) el.textContent = ''; });
      }

      function displayError(id, msg) {
        const el = document.getElementById(id);
        if (el) el.textContent = msg;
      }

      function displayWarning(id, msg) {
        const el = document.getElementById(id);
        if (el) el.textContent = msg;
      }

      function parsePopulasi(input) {
        const raw = (input || '').trim();
        if (!raw) return { numbers: [], invalid: [], warningSeparated: false };
        const hasComma = raw.indexOf(',') !== -1;
        let tokens = hasComma ? raw.split(',').map(s => s.trim()).filter(Boolean) : raw.split(/[\s;]+/).map(s => s.trim()).filter(Boolean);
        const numberRegex = /^-?\d+(?:\.\d+)?$/;
        const numbers = [];
        const invalid = [];
        tokens.forEach(tok => { if (numberRegex.test(tok)) numbers.push(parseFloat(tok)); else invalid.push(tok); });
        return { numbers, invalid, warningSeparated: !hasComma && tokens.length > 0 };
      }

      form.addEventListener('submit', function (e) {
        clearErrors();
        const populasi = document.getElementById('populasiInput')?.value || '';
        const ukuranSampleVal = document.getElementById('ukuranSampleInput')?.value;
        const jumlahPengulanganVal = document.getElementById('jumlahPengulanganInput')?.value;

        const { numbers, invalid, warningSeparated } = parsePopulasi(populasi);
        let blocked = false;

        if (invalid.length) {
          displayError('populasiError', 'Input populasi mengandung nilai tidak valid: ' + invalid.join(', '));
          blocked = true;
        }

        const n = numbers.length;
        const ukuran = parseInt(ukuranSampleVal, 10);
        if (isNaN(ukuran) || ukuran <= 0) {
          displayError('ukuranSampleError', 'Ukuran sample harus bilangan bulat positif.');
          blocked = true;
        } else if (ukuran > n) {
          displayError('ukuranSampleError', 'Ukuran sample tidak boleh lebih besar dari jumlah populasi (' + n + ').');
          blocked = true;
        }

        const jp = parseInt(jumlahPengulanganVal, 10);
        if (isNaN(jp) || jp <= 0) {
          displayError('jumlahPengulanganError', 'Jumlah pengulangan harus bilangan bulat positif.');
          blocked = true;
        }

        if (warningSeparated && !invalid.length) {
          displayWarning('populasiWarning', 'Format: tidak ditemukan koma — input otomatis dinormalisasi. Disarankan gunakan koma sebagai pemisah.');
          // non-blocking
        }

        if (blocked) {
          e.preventDefault();
          // focus first error
          const firstErr = document.querySelector('.text-red-500.text-sm') || document.getElementById('populasiError');
          if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    })();
  </script>
</x-layout-web>
