<x-guest-layout>

  <div class="text-center mb-8 fade-in-up">
    <div class="mx-auto mb-4">
      <svg class="w-16 h-16 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
    </div>
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi Email</h2>
    <p class="text-gray-600">Masukkan kode OTP yang dikirim ke <strong class="text-gray-800">{{ $email }}</strong></p>
  </div>

  <div class="mb-6 text-center fade-in-up delay-100">
    <div class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-200 rounded-full">
      <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 102 0V6z" clip-rule="evenodd"/>
      </svg>
      <span class="text-sm font-semibold text-blue-700" id="otp-timer"></span>
    </div>
  </div>

  <form method="POST" action="{{ route('verification.otp.submit') }}" id="otp-form">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="otp" id="otp" />

    <div class="flex justify-center gap-3 mb-6 fade-in-up delay-200">
      @for ($i = 0; $i < 6; $i++)
        <input type="text" maxlength="1"
          class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
          inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" />
      @endfor
    </div>

    <x-input-error :messages="$errors->get('otp')" class="text-center mb-6" />

    <div class="flex flex-col gap-3 fade-in-up delay-300">
      <button type="submit" class="w-full px-6 py-4 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-sm rounded-xl transition ease-in-out duration-150 hover:shadow-lg">
        Verifikasi OTP
      </button>
    </div>
  </form>


  {{-- Tombol kirim ulang --}}
  <form method="POST" action="{{ route('verification.otp.resend') }}" class="mt-6 text-center fade-in-up delay-400">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors duration-200">
      Kirim ulang kode OTP
    </button>
  </form>

  <style>
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.6s ease-out;
    }

    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }

    .otp-input {
      font-variant-numeric: tabular-nums;
    }

    .otp-input::-webkit-outer-spin-button,
    .otp-input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .otp-input[type=number] {
      -moz-appearance: textfield;
    }
  </style>

  <script>
    // Ambil waktu expired dari server (format ISO)
    const expiredAt = new Date("{{ $expired_at }}").getTime();

    function updateTimer() {
      const now = new Date().getTime();
      const distance = expiredAt - now;

      if (distance <= 0) {
        document.getElementById("otp-timer").innerHTML = "Kadaluarsa!";
        document.getElementById("otp-timer").parentElement.classList.remove("bg-blue-50", "border-blue-200");
        document.getElementById("otp-timer").parentElement.classList.add("bg-red-50", "border-red-200");
        document.getElementById("otp-timer").classList.remove("text-blue-700");
        document.getElementById("otp-timer").classList.add("text-red-700");
        return;
      }

      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      const timerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} menit tersisa`;
      document.getElementById("otp-timer").innerHTML = timerText;
    }

    // Update setiap detik
    updateTimer();
    setInterval(updateTimer, 1000);

    const inputs = document.querySelectorAll(".otp-input");
    const hiddenOtp = document.getElementById("otp");
    const form = document.getElementById("otp-form");

    inputs.forEach((input, index) => {
      input.addEventListener("input", (e) => {
        // Hanya izinkan angka
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
        
        if (e.target.value.length > 0 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
        updateHiddenOtp();
      });

      input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) {
          inputs[index - 1].focus();
        }
        // Izinkan navigasi dengan arrow keys
        if (e.key === "ArrowRight" && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
        if (e.key === "ArrowLeft" && index > 0) {
          inputs[index - 1].focus();
        }
      });

      input.addEventListener("paste", (e) => {
        e.preventDefault();
        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        const digits = pastedData.replace(/[^0-9]/g, '').split('');
        
        digits.forEach((digit, i) => {
          if (index + i < inputs.length) {
            inputs[index + i].value = digit;
          }
        });
        
        if (digits.length > 0) {
          inputs[Math.min(index + digits.length - 1, inputs.length - 1)].focus();
        }
        updateHiddenOtp();
      });
    });

    function updateHiddenOtp() {
      hiddenOtp.value = Array.from(inputs).map(i => i.value).join("");
    }

    form.addEventListener("submit", (e) => {
      updateHiddenOtp();
      if (hiddenOtp.value.length < 6) {
        e.preventDefault();
        alert("Kode OTP harus 6 digit.");
      }
    });
  </script>
</x-guest-layout>
