@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Video Pembelajaran</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form method="POST" action="{{ route('admin_video-pembelajaran.store') }}" class="needs-validation" novalidate>
            <div class="card-body">
              @csrf
              @include('components.form.select', ['name' => 'subjek_materi', 'label' => 'Subjek Materi', 'options' => $subjek_materi->pluck('judul','id')->toArray(), 'required' => true])
              @include('components.form.input', ['name' => 'judul', 'label' => 'Judul Video', 'type' => 'text', 'placeholder' => 'Masukkan Judul Video', 'required' => true])
              @include('components.form.input', ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'text', 'placeholder' => 'Masukkan Deskripsi Video', 'required' => true])
              @include('components.form.input', ['name' => 'link', 'label' => 'Link Video', 'type' => 'text', 'placeholder' => 'Masukkan Link Video', 'required' => true])
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection
