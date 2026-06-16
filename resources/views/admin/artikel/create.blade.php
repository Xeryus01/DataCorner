@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Artikel</h3>
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
          <form method="POST" action="{{ route('admin_artikel.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="card-body">
              @csrf
              @include('components.form.select', ['name' => 'subjek_materi', 'label' => 'Subjek Materi', 'options' => $subjek_materi->pluck('judul','id')->toArray(), 'required' => true])
              @include('components.form.input', ['name' => 'judul', 'label' => 'Judul Artikel', 'type' => 'text', 'placeholder' => 'Masukkan Judul Artikel', 'required' => true])
              @include('components.form.input', ['name' => 'deskripsi', 'label' => 'Deskripsi Artikel', 'type' => 'text', 'placeholder' => 'Masukkan Deskripsi Artikel', 'required' => true])
              <div class="form-group">
                <label for="gambar">Gambar Artikel</label>
                <input type="file" name="gambar" class="form-control" id="gambar"
                  placeholder="Masukkan Gambar Artikel" accept="image/jpg, image/jpeg, image/png" required>
                @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@else<p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>@enderror
              </div>
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
