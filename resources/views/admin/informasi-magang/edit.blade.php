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
                <h3 class="card-title">Edit Informasi Magang</h3>
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
              <form method="POST" action="{{ route('admin_informasi-magang.update', $informasi_magang->id) }}">

                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" id="editor-deskripsi" placeholder="Masukkan Deskripsi Magang">{{ $informasi_magang->deskripsi }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="persyaratan">Persyaratan</label>
                    <textarea name="persyaratan" class="form-control" id="editor-persyaratan" placeholder="Masukkan Persyaratan Magang">{{ $informasi_magang->persyaratan }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="benefit">Benefit</label>
                    <textarea name="benefit" class="form-control" id="editor-benefit" placeholder="Masukkan Benefit Magang">{{ $informasi_magang->benefit }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="info_kontak">Info Kontak</label>
                    <textarea name="info_kontak" class="form-control" id="editor-info-kontak" placeholder="Masukkan Info Kontak Magang">{{ $informasi_magang->info_kontak }}</textarea>
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
  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
    <script>
      const editors = ['editor-deskripsi', 'editor-persyaratan', 'editor-benefit', 'editor-info-kontak'];
      editors.forEach(id => {
        ClassicEditor
          .create(document.querySelector(`#${id}`), {
            toolbar: [
              'heading', '|',
              'bold', 'italic', 'underline', 'strikethrough', '|',
              'fontColor', 'fontSize', '|',
              'link', 'bulletedList', 'numberedList', '|',
              'alignment',
              'insertTable', '|',
              'undo', 'redo'
            ],
            fontSize: {
              options: [9, 11, 13, 'default', 17, 19, 21],
              supportAllValues: false
            },
            fontColor: {
              columns: 5,
              documentColors: 5
            }
          })
          .catch(error => {
            console.error(`Editor ${id} error:`, error);
          });
      });
    </script>
  @endpush

@endsection
