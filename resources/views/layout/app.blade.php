<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="app-base-url" content="{{ url('') }}">
    <title>DATAPEDIA BPS</title>

    <script>
        window.APP_BASE_URL = "{{ url('') }}";
    </script>

    <!-- External CSS -->    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/user-page.js']) -->

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/user-page.js', 'resources/js/about-datapedia.js', 'resources/css/about-datapedia.css'])

    @stack('styles')

    <!-- FAQ -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased" style="font-family:'Plus Jakarta Sans',system-ui,sans-serif;background:#f8fafc;color:#1e293b">

    @include('components.user.navbar')
    @yield('hero')
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    @include('components.user.footer')
    
    @stack('scripts')
    <!-- External JS (tetap boleh CDN kalau tidak via npm) -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/user-page.js') }}?v={{ time() }}"></script> -->

    <script>
    AOS.init({
        once: false,
        offset: 200,
        duration: 800,
    });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const counters = document.querySelectorAll('.stat-number');

            const formatNumber = (num) => {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            };

            const runCounter = (counter) => {
                const target = +counter.getAttribute('data-target');
                let count = 0;
                const speed = 40;

                const update = () => {
                    const increment = target / speed;

                    if (count < target) {
                        count += increment;
                        counter.innerText = formatNumber(Math.ceil(count));
                        requestAnimationFrame(update);
                    } else {
                        counter.innerText = formatNumber(target);
                    }
                };

                update();
            };

            // Intersection Observer (biar jalan saat muncul)
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        runCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.6 });

            counters.forEach(counter => {
                observer.observe(counter);
            });        

        });
    </script>

    <!-- FAQ -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

</body>
</html>