<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="{{ asset('image/logo-bpskecil.png') }}" type="image/x-icon" />
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <title>Welcome To Admin</title>

  <style>
    :root {
      color-scheme: light;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    body {
      background: #f8fafc;
      color: #0f172a;
    }

    #navbar {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(148, 163, 184, 0.15);
      box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
    }

    #sideBar {
      top: 4rem;
      background: #ffffff;
      border-right: 1px solid #e2e8f0;
      border-bottom: none;
      padding: 2rem;
      width: 18rem;
      min-height: calc(100vh - 4rem);
      box-shadow: 0 24px 55px rgba(15, 23, 42, 0.08);
    }

    #sideBar a {
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      padding: 0.9rem 1rem;
      border-radius: 1.25rem;
      transition: background-color 0.2s ease, transform 0.2s ease, color 0.2s ease;
    }

    #sideBar a:hover {
      background: rgba(59, 130, 246, 0.08);
      color: #1d4ed8;
      transform: translateX(2px);
    }

    #sideBar a.active {
      background: rgba(59, 130, 246, 0.14);
      color: #1d4ed8;
      font-weight: 700;
    }

    .content {
      padding: 2rem 1.5rem 3rem;
      min-height: calc(100vh - 4rem);
    }

    .content .card {
      border-radius: 1.5rem;
      border: 1px solid rgba(148, 163, 184, 0.15);
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
    }

    .card-header {
      background: #f8fafc;
      border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .table-responsive {
      border-radius: 1.5rem;
      border: 1px solid rgba(148, 163, 184, 0.12);
      overflow: hidden;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(15, 23, 42, 0.03);
    }

    .btn-primary {
      border-radius: 9999px;
      padding-left: 1.4rem;
      padding-right: 1.4rem;
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }

    .btn-secondary {
      border-radius: 9999px;
    }

    .badge {
      border-radius: 9999px;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .menu-btn {
      border-radius: 9999px;
    }

    @media (max-width: 767px) {
      #sideBar {
        position: relative;
        top: 0;
        width: 100%;
        min-height: auto;
        box-shadow: none;
      }

      .content {
        padding-top: 1rem;
      }
    }
  </style>

</head>

<body class="bg-gray-100">
  <a href="#main-content" class="skip-link sr-only focus:not-sr-only" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;" aria-label="Skip to main content">Skip to content</a>
  <!-- start navbar -->
  <div
    class="md:fixed md:w-full md:top-0 md:z-20 flex flex-row flex-wrap items-center bg-white p-6 border-b border-gray-300">
    <!-- logo -->
    <div class="flex-none w-56 flex flex-row items-center">
      <img src="{{ asset('image/logo-bpsbiru.png') }}" class="w-56 flex-none" />
      <strong class="capitalize ml-1 flex-1"></strong>

      <button id="sliderBtn" class="flex-none text-right text-gray-900 hidden md:block">
        <i class="fad fa-list-ul"></i>
      </button>
    </div>
    <!-- end logo -->

    <!-- navbar content toggle -->
    <button id="navbarToggle" class="hidden md:block md:fixed right-0 mr-6">
      <i class="fad fa-chevron-double-down"></i>
    </button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div id="navbar"
      class="animated md:hidden md:fixed md:top-0 md:w-full md:left-0 md:mt-16 md:border-t md:border-b md:border-gray-200 md:p-10 md:bg-white flex-1 pl-3 flex flex-row flex-wrap justify-between items-center md:flex-col md:items-center">
      <!-- left -->
      <div
        class="text-gray-600 md:w-full md:flex md:flex-row md:justify-evenly md:pb-10 md:mb-10 md:border-b md:border-gray-200">

      </div>
      <!-- end left -->

      <!-- right -->
      <div class="flex flex-row-reverse items-center">
        <!-- user -->
        <div class="">
          <button class="menu-btn focus:outline-none focus:shadow-outline flex flex-wrap items-center">
            <div class="w-8 h-8 overflow-hidden rounded-full">
              <img class="w-full h-full object-cover" src="img/user.svg" />
            </div>

            <div class="ml-2 capitalize flex">


@php
    $admin = Auth::guard('admin')->user() ?? Session::get('adminLogin');
@endphp

@if($admin)
    <h1 class="text-sm text-gray-800 font-semibold m-0 p-0 leading-none">
        {{ $admin->nama ?? $admin->email }}
    </h1>
@endif

            </div>
          </button>

          <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>
        </div>
        <!-- end user -->

        <!-- notifcation -->
        <div class="dropdown relative mr-5 md:static">
          <button
            class="text-gray-500 menu-btn p-0 m-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none transition-all ease-in-out duration-300">
            <i class="fad fa-bells"></i>
          </button>

          <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

          <div
            class="menu hidden rounded bg-white md:right-0 md:w-full shadow-md absolute z-20 right-0 w-84 mt-5 py-2 animated faster">
            <!-- top -->
            <div class="px-4 py-2 flex flex-row justify-between items-center capitalize font-semibold text-sm">
              <h1>notifications</h1>
              <div class="bg-teal-100 border border-teal-200 text-teal-500 text-xs rounded px-1">
                <strong>5</strong>
              </div>
            </div>
            <hr />
            <!-- end top -->

            <!-- body -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                <i class="fad fa-birthday-cake text-sm"></i>
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">poll..</h1>
                  <p class="text-xs text-gray-500">text here also</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>4 min ago</p>
                </div>
              </div>
            </a>
            <hr />
            <!-- end item -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                <i class="fad fa-user-circle text-sm"></i>
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">mohamed..</h1>
                  <p class="text-xs text-gray-500">text here also</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>78 min ago</p>
                </div>
              </div>
            </a>
            <hr />
            <!-- end item -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                <i class="fad fa-images text-sm"></i>
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">new imag..</h1>
                  <p class="text-xs text-gray-500">text here also</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>65 min ago</p>
                </div>
              </div>
            </a>
            <hr />
            <!-- end item -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                <i class="fad fa-alarm-exclamation text-sm"></i>
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">time is up..</h1>
                  <p class="text-xs text-gray-500">text here also</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>1 min ago</p>
                </div>
              </div>
            </a>
            <!-- end item -->

            <!-- end body -->

            <!-- bottom -->
            <hr />
            <div class="px-4 py-2 mt-2">
              <a href="#"
                class="border border-gray-300 block text-center text-xs uppercase rounded p-1 hover:text-teal-500 transition-all ease-in-out duration-500">
                view all </a>
            </div>
            <!-- end bottom -->
          </div>
        </div>
        <!-- end notifcation -->

        <!-- messages -->
        <div class="dropdown relative mr-5 md:static">
          <button
            class="text-gray-500 menu-btn p-0 m-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none transition-all ease-in-out duration-300">
            <i class="fad fa-comments"></i>
          </button>

          <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

          <div
            class="menu hidden md:w-full md:right-0 rounded bg-white shadow-md absolute z-20 right-0 w-84 mt-5 py-2 animated faster">
            <!-- top -->
            <div class="px-4 py-2 flex flex-row justify-between items-center capitalize font-semibold text-sm">
              <h1>messages</h1>
              <div class="bg-teal-100 border border-teal-200 text-teal-500 text-xs rounded px-1">
                <strong>3</strong>
              </div>
            </div>
            <hr />
            <!-- end top -->

            <!-- body -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="w-10 h-10 rounded-full overflow-hidden mr-3 bg-gray-100 border border-gray-300">
                <img class="w-full h-full object-cover" src="img/user1.jpg" alt="" />
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">mohamed said</h1>
                  <p class="text-xs text-gray-500">yeah i know</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>4 min ago</p>
                </div>
              </div>
            </a>
            <hr />
            <!-- end item -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="w-10 h-10 rounded-full overflow-hidden mr-3 bg-gray-100 border border-gray-300">
                <img class="w-full h-full object-cover" src="img/user2.jpg" alt="" />
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">sull goldmen</h1>
                  <p class="text-xs text-gray-500">for sure</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>1 day ago</p>
                </div>
              </div>
            </a>
            <hr />
            <!-- end item -->

            <!-- item -->
            <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out"
              href="#">
              <div class="w-10 h-10 rounded-full overflow-hidden mr-3 bg-gray-100 border border-gray-300">
                <img class="w-full h-full object-cover" src="img/user3.jpg" alt="" />
              </div>

              <div class="flex-1 flex flex-rowbg-green-100">
                <div class="flex-1">
                  <h1 class="text-sm font-semibold">mick</h1>
                  <p class="text-xs text-gray-500">is typing ....</p>
                </div>
                <div class="text-right text-xs text-gray-500">
                  <p>31 feb</p>
                </div>
              </div>
            </a>
            <!-- end item -->

            <!-- end body -->

            <!-- bottom -->
            <hr />
            <div class="px-4 py-2 mt-2">
              <a href="#"
                class="border border-gray-300 block text-center text-xs uppercase rounded p-1 hover:text-teal-500 transition-all ease-in-out duration-500">
                view all </a>
            </div>
            <!-- end bottom -->
          </div>
        </div>
        <!-- end messages -->
      </div>
      <!-- end right -->
    </div>
    <!-- end navbar content -->
  </div>
  <!-- end navbar -->

  <!-- strat wrapper -->
  <div class="flex ">
    <!-- start sidebar -->
    <div id="sideBar"
      class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">
      <!-- sidebar content -->
      <div class="flex flex-col">
        <!-- sidebar toggle -->
        <div class="text-right hidden md:block mb-4">
          <button id="sideBarHideBtn">
            <i class="fad fa-times-circle"></i>
          </button>
        </div>
        <!-- end sidebar toggle -->

        <p class="uppercase text-xs text-blue-600 mb-4 tracking-wider">Dashboard</p>

        <!-- link -->
        <a href="{{ route('dashboard.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          Halaman Dashboard
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 tracking-wider">Role User</p>

        <!-- link -->
        <a href="{{ route('admin.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          Admin
        </a>

        <!-- link -->
        <a href="{{ route('dataUser') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          user
        </a>

        <a href="{{ route('konsultan.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          konsultan statistik
        </a>

        <a href="{{ route('petugas.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          Petugas Minggu Ini
        </a>

        <a href="{{ route('petugas-berprestasi.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          Petugas Berprestasi
        </a>

        <a href="{{ route('bidang-keahlian.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-chart-pie text-xs mr-2"></i>
          Bidang Keahlian
        </a>
        <!-- end link -->


        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Layanan</p>

        <!-- link -->
        <a href="{{ route('jadwal.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-envelope-open-text text-xs mr-2"></i>
          Jadwal Janji Temu
        </a>

        <a href="{{ route('layanan.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-envelope-open-text text-xs mr-2"></i>
          layanan 24 jam
        </a>
        <!-- end link -->

        <!-- link -->
        <a href="{{ route('standar.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-comments text-xs mr-2"></i>
          standar pelayanan
        </a>

        <a href="{{ route('maklumat.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-comments text-xs mr-2"></i>
          maklumat layanan
        </a>

        <a href="{{ route('jam-operasional.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-comments text-xs mr-2"></i>
         Jam Operasional
        </a>

        <a href="{{ route('adminKonsultasi.create') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-comments text-xs mr-2 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Penambahan Jumlah Konsultasi
            </span>

        </a>
        <!-- end link -->

        
        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Statistik Layanan</p>

        <!-- link -->
        <a href="{{ route('statistik.perpustakaan.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Layanan Perpustakaan
            </span>

        </a>

        <a href="{{ route('statistik.konsultasi-statistik.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Layanan Konsultasi Statistik
            </span>

        </a>

        <a href="{{ route('statistik.produk-statistik.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Layanan Produk Statistik Berbayar
            </span>

        </a>

        <a href="{{ route('statistik.rekomendasi.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Layanan Rekomendasi Statistik
            </span>

        </a>

        <a href="{{ route('statistik.pojok-statistik.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Pojok Statistik
            </span>

        </a>        

        <a href="{{ route('statistik.website.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Website BPS Provinsi Kepulauan Bangka Belitung
            </span>

        </a>

        <a href="{{ route('survei-layanan.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          
            <div class="w-5 flex-shrink-0 mr-2">
              <i class="fad fa-chart-pie text-xs mt-1 transition-all duration-500"></i>
            </div>
            
            <span class="leading-tight">
              Survei Kepuasan Masyarakat
            </span>

        </a>


        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Edukasi Statistik</p>

        <a href="{{ route('admin_subjek-materi.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-book text-xs mt-1"></i></div>
          <span class="leading-tight">Subjek Materi</span>
        </a>

        <a href="{{ route('admin_artikel.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-newspaper text-xs mt-1"></i></div>
          <span class="leading-tight">Artikel Edukasi</span>
        </a>

        <a href="{{ route('admin_video-pembelajaran.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-video text-xs mt-1"></i></div>
          <span class="leading-tight">Video Pembelajaran</span>
        </a>

        <a href="{{ route('admin_infografis.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-image text-xs mt-1"></i></div>
          <span class="leading-tight">Infografis</span>
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Program Magang</p>

        <a href="{{ route('admin_informasi-magang.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-briefcase text-xs mt-1"></i></div>
          <span class="leading-tight">Informasi Magang</span>
        </a>

        <a href="{{ route('admin_daftar-magang.index-admin') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-users text-xs mt-1"></i></div>
          <span class="leading-tight">Pendaftar Magang</span>
        </a>

        <a href="{{ route('admin_pengaturan-presensi.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-calendar-check text-xs mt-1"></i></div>
          <span class="leading-tight">Pengaturan Presensi</span>
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Program Riset</p>

        <a href="{{ route('admin_informasi-riset.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-flask text-xs mt-1"></i></div>
          <span class="leading-tight">Informasi Riset</span>
        </a>

        <a href="{{ route('admin_daftar-riset.index-admin') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-file-signature text-xs mt-1"></i></div>
          <span class="leading-tight">Pendaftar Riset</span>
        </a>

        <a href="{{ route('admin_daftar-riset.risetDiterima') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-check-circle text-xs mt-1"></i></div>
          <span class="leading-tight">Riset Diterima</span>
        </a>

        <a href="{{ route('admin_daftar-riset.risetDitolak') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-times-circle text-xs mt-1"></i></div>
          <span class="leading-tight">Riset Ditolak</span>
        </a>

        <a href="{{ route('admin_daftar-riset.riwayatRiset') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-history text-xs mt-1"></i></div>
          <span class="leading-tight">Riwayat Riset</span>
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Kuis & Alat Statistik</p>

        <a href="{{ route('admin_kuis-reguler.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-question-circle text-xs mt-1"></i></div>
          <span class="leading-tight">Kuis Reguler</span>
        </a>

        <a href="{{ route('admin_periode.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-trophy text-xs mt-1"></i></div>
          <span class="leading-tight">Tantangan Bulanan</span>
        </a>

        <a href="{{ route('alat-statistik.index') }}" target="_blank"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-calculator text-xs mt-1"></i></div>
          <span class="leading-tight">Preview Alat Statistik</span>
        </a>

        <a href="{{ route('visualisasi.index') }}" target="_blank"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-chart-bar text-xs mt-1"></i></div>
          <span class="leading-tight">Preview Visualisasi Data</span>
        </a>

        <a href="{{ route('simulasi.index') }}" target="_blank"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-random text-xs mt-1"></i></div>
          <span class="leading-tight">Preview Simulasi Statistik</span>
        </a>

        <a href="{{ route('admin_wilayah-bps.index') }}"
          class="flex items-start mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500 group">
          <div class="w-5 flex-shrink-0 mr-2"><i class="fad fa-map-marker-alt text-xs mt-1"></i></div>
          <span class="leading-tight">Wilayah BPS</span>
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">FAQ</p>

        <!-- link -->
        <a href="{{ route('faq.pesan') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-text text-xs mr-2"></i>
          Pertanyaan Dari Whatsapp
        </a>

        <a href="{{ route('faq.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-text text-xs mr-2"></i>
          Frequently Ask Question
        </a>

        <p class="uppercase text-xs text-blue-600 mb-4 mt-4 tracking-wider">Navigasi</p>

        <!-- link -->
        <a href="{{ route('footer-item.index') }}"
          class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
          <i class="fad fa-text text-xs mr-2"></i>
          Footer Item
        </a>

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">Logout</p>
                <a href="{{ route('logoutAdmin') }}"
                    class="mb-3 capitalize font-medium text-sm hover:text-blue-600 transition ease-in-out duration-500">
                    <i class="fad fa-text text-xs mr-2"></i>
                    Log Out
                </a>
        <!-- end link -->

      </div>
      <!-- end sidebar content -->
    </div>
    <!-- end sidbar -->

    <!-- strat content -->
    <div id="main-content" class="content flex-1 min-h-screen bg-slate-100 pt-24 md:pl-[18rem]">
      <div class="max-w-[1800px] mx-auto">
        @yield('content')
      </div>
    </div>

  </div>
  <!-- end wrapper -->

  <!-- script -->
  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
  <!-- end script -->
  <script>
    // Accessibility: ensure keyboard focus visible styles
    document.addEventListener("DOMContentLoaded", function () {
        const rowsPerPage = 5;
        const rows = document.querySelectorAll(".layanan-item-row");
        const paginationControls = document.getElementById("pagination-controls");

        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = index >= start && index < end ? "" : "none";
            });

            // Update active button
            document.querySelectorAll(".pagination-btn").forEach((btn, i) => {
                btn.classList.toggle("bg-blue-500", i === page - 1);
                btn.classList.toggle("text-white", i === page - 1);
            });
        }

        function setupPagination() {
            paginationControls.innerHTML = "";
            const pageCount = Math.ceil(rows.length / rowsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement("button");
                btn.setAttribute("type", "button"); // ✅ FIX: Hindari submit
                btn.innerText = i;
                btn.className = "pagination-btn px-3 py-1 rounded bg-gray-200 hover:bg-blue-400 text-blue-800 font-medium";
                btn.addEventListener("click", () => showPage(i));
                paginationControls.appendChild(btn);
            }

            showPage(1);
        }

        if (rows.length > 0) {
            setupPagination();
        }
    });

    document.getElementById('gambar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

@stack('scripts')

    document.getElementById('file').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview-pdf');

        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            preview.src = fileURL;
            preview.classList.remove('hidden');
        } else {
            preview.src = "";
            preview.classList.add('hidden');
        }
    });
</script>

</body>

</html>
