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
            <h1 class="text-3xl font-bold text-primary mb-2">Form Janji Temu</h1>
            <p class="text-gray-600">Silakan lengkapi data di bawah ini dengan benar</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Data Janji Temu
                </h2>
            </div>

            <form class="p-8 space-y-6" method="POST" action="{{ route('janjitemu.store') }}" id="janjiTemuForm">
                @csrf

                <!-- Alamat -->
                <div class="form-floating">
                    <textarea
                        id="alamat"
                        name="alamat"
                        placeholder=""
                        rows="3"
                        class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors resize-none"
                        required
                    ></textarea>
                    <label for="alamat">Alamat Lengkap</label>
                    @error('alamat')
                         <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keperluan -->
                <div class="form-floating">
                    <input
                        type="text"
                        id="keperluan"
                        name="keperluan"
                        placeholder=" "
                        class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-0 focus:outline-none transition-colors"
                        required
                    />
                    <label for="keperluan">Keperluan</label>
                    @error('keperluan')
                         <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Jenis -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Jenis Layanan</label>
                    <div class="grid grid-cols-1 gap-4">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary/50 transition-colors group">
                        <input type="radio" name="jenis" value="online" class="radio-custom mr-3" required />
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-700 group-hover:text-primary transition-colors">Online</span>
                            </div>
                        </label>


                    </div>
                    @error('jenis')
                         <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
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
                        <span>Buat Janji Temu</span>
                    </button>
                </div>

                <!-- Info -->
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        Dengan menyimpan data, Anda menyetujui syarat dan ketentuan yang berlaku
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Alert Modal -->
    <div id="successAlert" class="fixed inset-0 hidden bg-black bg-opacity-50 alert-overlay z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full alert-container">
            <!-- Success Icon with Animation -->
            <div class="text-center p-8">
                <div class="relative inline-flex items-center justify-center">
                    <!-- Pulse Ring -->
                    <div class="absolute w-20 h-20 bg-green-400 rounded-full pulse-ring"></div>
                    <!-- Success Circle -->
                    <div class="relative w-20 h-20 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center success-icon shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path class="success-check" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Success Text -->
                <div class="mt-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Berhasil!</h3>
                    <p class="text-gray-600 mb-6">Janji temu Anda telah berhasil dibuat. Kami akan menghubungi Anda segera untuk konfirmasi.</p>

                    <!-- Success Details -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-center space-x-2 text-green-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Data tersimpan dengan aman</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            onclick="redirectToIndex()"
                            class="w-full bg-gradient-to-r from-primary to-primary-light text-white font-semibold py-3 px-6 rounded-lg hover:from-primary-dark hover:to-primary transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]"
                        >
                            Kembali ke Beranda
                        </button>
                        <button
                            onclick="closeAlert()"
                            class="w-full bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
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


