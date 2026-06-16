@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Detail Sub Judul {{ $detail_subjudul_artikel->sub_judul_artikel->sub_judul }}
            </h3>
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
          <form method="POST" action="{{ route('admin_detail-subjudul-artikel.update', $detail_subjudul_artikel->id) }}"
            enctype="multipart/form-data">
            <div class="card-body">
              @csrf
              @method('PUT')
              <input type="hidden" name="sub_judul_artikel_id"
                value="{{ $detail_subjudul_artikel->sub_judul_artikel->id }}">
              <div class="form-group">
                <label for="konten_text">Konten</label>
                <textarea name="konten_text" class="form-control" id="editor" placeholder="Masukkan Konten Teks" cols="30"
                  rows="10">{{ $detail_subjudul_artikel->konten_text }}</textarea>
              </div>
              <div class="form-group">
                <label for="link_embed">Link Power BI (Opsional)</label>
                <input type="text" name="link_embed" class="form-control" id="link_embed"
                  value="{{ $detail_subjudul_artikel->link_embed }}" placeholder="Masukkan Link">
              </div>
              <div class="form-group">
                <label for="gambar">Gambar (Opsional)</label>
                <input type="file" name="gambar" class="form-control" id="gambar" placeholder="Masukkan Gambar">
              </div>
              <div class="form-group">
                <label for="urutan">Urutan</label>
                <input type="number" name="urutan" class="form-control" id="urutan"
                  value="{{ $detail_subjudul_artikel->urutan }}" placeholder="Masukkan Urutan" required>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
    <script>
      ClassicEditor
        .create(document.querySelector('#editor'), {
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
          console.error(error);
        });
    </script>
  @endpush
@endsection
