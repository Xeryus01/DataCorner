@extends('layout.app')
@section('content')
<style>

        #successAlert {
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }
        .hidden {
            display: none !important;
        }

        .form-floating {
            position: relative;
        }
        .form-floating input:focus + label,
        .form-floating input:not(:placeholder-shown) + label,
        .form-floating select:focus + label,
        .form-floating select:not([value=""]) + label,
        .form-floating textarea:focus + label,
        .form-floating textarea:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #002B6A;
        }
        .form-floating label {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            color: #6B7280;
            background: white;
            padding: 0 0.25rem;
        }
        .radio-custom {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #D1D5DB;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .radio-custom:checked {
            border-color: #002B6A;
            background-color: #002B6A;
        }
        .radio-custom:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem;
            height: 0.5rem;
            background-color: white;
            border-radius: 50%;
        }

        /* Success Alert Animations */
        .alert-overlay {
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }

        .alert-container {
            animation: slideIn 0.4s ease-out;
        }

        .success-icon {
            animation: checkmark 0.6s ease-in-out 0.2s both;
        }

        .success-check {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: draw 0.8s ease-out 0.3s forwards;
        }

        .pulse-ring {
            animation: pulse-ring 1.5s ease-out infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes draw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .fade-out {
            animation: fadeOut 0.3s ease-in forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    </style>
    <div class="container mx-auto px-4 max-w-2xl mt-16">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-primary mb-2">Form Konsultasi</h1>
            <p class="text-gray-600">Silakan lengkapi data di bawah ini dengan benar</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Data Diri
                </h2>
            </div>

            <form class="p-8 space-y-6" method="POST" action="{{ route('konsultasi.klik') }}" id="janjiTemuForm">
                @csrf

                <div>
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        placeholder="Contoh: abcd@example.com"
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    />

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jenis_kelamin" class="text-sm font-medium text-gray-700">Jenis Kelamin</label><span class="text-red-500">*</span>
                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    >
                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="laki_laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>                    
                <div>
                    <label for="instansi" class="text-sm font-medium text-gray-700">Instansi/Universitas</label><span class="text-red-500">*</span>
                    <input
                        id="instansi"
                        name="instansi"
                        type="text"
                        placeholder="Contoh: BPS, Universitas Indonesia, dll."
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    />
                    @error('instansi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_diminta" class="text-sm font-medium text-gray-700">Data yang Dibutuhkan</label><span class="text-red-500">*</span>
                    <textarea
                        id="data_diminta"
                        name="data_diminta"
                        placeholder="Tuliskan pertanyaan atau data yang Anda butuhkan..."
                        rows="4"
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors resize-none"
                        required
                    ></textarea>
                    @error('data_diminta')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Keperluan Penggunaan Data <span class="text-red-500">*</span>
                    </label>

                    @php
                        $keperluanOptions = [
                            'Tugas Sekolah/Kuliah',
                            'Perencanaan',                            
                            'Skripsi/Tesis/Disertasi',
                            'Evaluasi',                            
                            'Penelitian',
                            'Diskusi',
                            'Lainnya',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-3">
                        @foreach ($keperluanOptions as $option)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="keperluan_data[]"
                                    value="{{ $option }}"
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($option, old('keperluan_data', [])) ? 'checked' : '' }}
                                >

                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('keperluan_data')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @error('keperluan_data.*')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="posisi" class="text-sm font-medium text-gray-700">Posisi Anda</label><span class="text-red-500">*</span>
                    <select
                        id="posisi"
                        name="posisi"
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    >
                        <option value="" disabled selected>-- Pilih Posisi --</option>
                        <option value="asn">Aparatur Sipil Negara</option>
                        <option value="karyawan_swasta">Karyawan Swasta</option>
                        <option value="wiraswasta">Wiraswasta</option>
                        <option value="peneliti">Peneliti</option>
                        <option value="pelajar_mahasiswa">Pelajar/Mahasiswa</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                    @error('posisi')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="memiliki_akun" class="text-sm font-medium text-gray-700">Memiliki Akun PST BPS</label><span class="text-red-500">*</span>
                    <select
                        id="memiliki_akun"
                        name="memiliki_akun"
                        class="w-full px-3 py-3 mt-1 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    >
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="ya">Ya</option>
                        <option value="tidak">Tidak</option>
                    </select>
                    @error('memiliki_akun')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-4">
                    <button
                        onclick="this.disabled=true;this.form.submit();"
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-primary to-primary-light text-white font-semibold py-4 px-6 rounded-lg hover:from-primary-dark hover:to-primary transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Buat Konsultasi</span>
                    </button>
                </div>

                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        Dengan menyimpan data, Anda menyetujui syarat dan ketentuan yang berlaku
                    </p>
                </div>
            </form>
        </div>
    </div>

      @if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('successAlert')?.classList.remove('hidden');
    });
</script>
@endif

    <script>
        // Form handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('janjiTemuForm');
            const submitBtn = document.getElementById('submitBtn');
            const successAlert = document.getElementById('successAlert');

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                const formData = new FormData(form);
                let isValid = true;

                // Check required fields
                for (let [key, value] of formData.entries()) {
                    if (!value.toString().trim()) {
                        isValid = false;
                        break;
                    }
                }

                if (!isValid) {
                    showErrorAlert('Mohon lengkapi semua field yang diperlukan.');
                    return;
                }

                // Show loading state
                showLoadingState();

                // Simulate API call (replace with actual Laravel form submission)
                setTimeout(() => {
                    // Hide loading state
                    hideLoadingState();

                    // Show success alert
                    showSuccessAlert();

                    // For actual Laravel implementation, you would submit the form normally:
                    // form.submit();
                }, 1500);
            });

            // Phone number formatting
            const phoneInput = document.getElementById('no_hp');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = '62' + value.substring(1);
                }
                e.target.value = value;
            });
        });

        function showLoadingState() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Memproses...</span>
            `;
        }

        function hideLoadingState() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 9l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Buat Janji Temu</span>
            `;
        }

        function showSuccessAlert() {
        const successAlert = document.getElementById('successAlert');
        successAlert.classList.remove('hidden');

            // Auto redirect after 5 seconds
            setTimeout(() => {
                redirectToIndex();
            }, 500);
        }

        function closeAlert() {
        const successAlert = document.getElementById('successAlert');
        const alertContainer = successAlert.querySelector('.alert-container');

        alertContainer.classList.add('fade-out');
        successAlert.classList.add('fade-out');

        setTimeout(() => {
            successAlert.classList.add('hidden');
            successAlert.classList.remove('fade-out');
            alertContainer.classList.remove('fade-out');
            }, 300);
        }


        function redirectToIndex() {
            closeAlert();

            // For demo purposes - replace with actual Laravel route
            setTimeout(() => {
                window.location.href = '{{ route("home") }}';
                // For demo: window.location.href = '/user/dashboard';
            }, 300);
        }

        function showErrorAlert(message) {
            // Simple error alert (you can enhance this)
            alert(message);
        }

        // Close alert when clicking outside
        document.getElementById('successAlert').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAlert();
            }
        });

        // Close alert with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const successAlert = document.getElementById('successAlert');
                if (!successAlert.classList.contains('hidden')) {
                    closeAlert();
                }
            }
        });
    </script>
@endsection



