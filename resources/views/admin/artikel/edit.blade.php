@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Data Artikel</h3>
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
              <form method="POST" action="{{ route('admin_artikel.update', $artikel->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="card-body">
                  @csrf
                  @method('PUT')
                  @include('components.form.select', ['name' => 'subjek_materi_id', 'label' => 'Subjek Materi', 'options' => $subjek_materi->pluck('judul','id')->toArray(), 'selected' => $artikel->subjek_materi_id, 'required' => true])
                  @include('components.form.input', ['name' => 'judul', 'label' => 'Judul Artikel', 'type' => 'text', 'value' => $artikel->judul, 'required' => true])
                  @include('components.form.input', ['name' => 'deskripsi', 'label' => 'Deskripsi Artikel', 'type' => 'text', 'value' => $artikel->deskripsi, 'required' => true])
                  <div class="form-group">
                    <label for="gambar">Gambar Artikel</label>
                    <input type="file" name="gambar" class="form-control" id="gambar" accept="image/jpg, image/jpeg, image/png" placeholder="Masukkan Gambar Artikel">
                    @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@else<p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>@enderror
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
