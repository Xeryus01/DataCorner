@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Input Topik Kuis Reguler</div>
        <div class="page-sub">Tambah topik kuis reguler baru</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-question-mark"></i>Form Input Kuis Reguler</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_kuis-reguler.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Judul Kuis Reguler</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan Judul Kuis" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-textarea" id="editor" placeholder="Masukkan Deskripsi Kuis" style="min-height:120px">{{ old('deskripsi') }}</textarea>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Gambar</label>
                <input type="file" name="gambar" style="font-size:13px" accept="image/jpg, image/jpeg, image/png" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Durasi Pengerjaan (menit)</label>
                <input type="number" name="durasi_menit" value="{{ old('durasi_menit') }}" class="form-input" placeholder="Masukkan Durasi Pengerjaan" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Tambah</button>
                <a href="{{ route('admin_kuis-reguler.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor'), {
        toolbar: [
            'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
            'fontColor', 'fontSize', '|', 'link', 'bulletedList', 'numberedList', '|',
            'alignment', 'insertTable', '|', 'undo', 'redo'
        ],
        fontSize: { options: [9, 11, 13, 'default', 17, 19, 21], supportAllValues: false },
        fontColor: { columns: 5, documentColors: 5 }
    }).catch(error => { console.error('Editor error:', error); });
</script>
@endsection