<x-layout-web>
  <div class="max-w-4xl mx-auto my-10 p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4 text-orange-600">Simulasi Ukuran Sampel Slovin</h1>

    <form method="POST" action="{{ route('simulasi.slovin.hitung') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block font-semibold mb-1">Jumlah Populasi (N)</label>
        <input type="number" name="populasi" class="w-full border border-gray-300 rounded p-2" required min="1"
          value="{{ old('populasi', $N ?? '') }}">
      </div>

      <div>
        <label class="block font-semibold mb-1">Margin of Error (e)</label>
        <input type="number" step="0.001" name="error" class="w-full border border-gray-300 rounded p-2"
          placeholder="Contoh: 0.05 untuk 5%" required value="{{ old('error', $e ?? '') }}">
      </div>

      <button type="submit"
        class="px-4 py-2 bg-primary text-white rounded hover:bg-[#00295A] transition">Hitung</button>
    </form>

    @isset($n)
      <div class="mt-6 p-4 text-center bg-green-100 rounded border border-green-400">
        <h2 class="text-xl font-semibold mb-2">Hasil Perhitungan</h2>
        <p>Populasi (N): <strong>{{ $N }}</strong></p>
        <p>Margin of Error (e): <strong>{{ $e }}</strong></p>
        <p>Ukuran Sampel (n): <strong>{{ number_format($n, 2) }}</strong></p>
        <p>Setelah dibulatkan: <strong class="text-green-700 text-xl">{{ $n_rounded }} orang</strong></p>
      </div>
    @endisset
  </div>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
