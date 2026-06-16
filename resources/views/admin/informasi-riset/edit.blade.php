@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Edit Informasi Riset</div>
        <div class="page-sub">Perbarui informasi program riset</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-flask"></i>Form Edit Informasi Riset</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_informasi-riset.update', $informasi_riset->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-textarea" id="editor-deskripsi" placeholder="Masukkan Deskripsi Riset">{{ $informasi_riset->deskripsi }}</textarea>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Persyaratan</label>
                <textarea name="persyaratan" class="form-textarea" id="editor-persyaratan" placeholder="Masukkan Persyaratan Riset">{{ $informasi_riset->persyaratan }}</textarea>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Benefit</label>
                <textarea name="benefit" class="form-textarea" id="editor-benefit" placeholder="Masukkan Benefit Riset">{{ $informasi_riset->benefit }}</textarea>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Info Kontak</label>
                <textarea name="info_kontak" class="form-textarea" id="editor-info-kontak" placeholder="Masukkan Info Kontak Riset">{{ $informasi_riset->info_kontak }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Ubah</button>
                <a href="{{ route('admin_informasi-riset.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
<script>
    const editors = ['editor-deskripsi', 'editor-persyaratan', 'editor-benefit', 'editor-info-kontak'];
    editors.forEach(id => {
        ClassicEditor.create(document.querySelector(`#${id}`), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                'fontColor', 'fontSize', '|', 'link', 'bulletedList', 'numberedList', '|',
                'alignment', 'insertTable', '|', 'undo', 'redo'
            ],
            fontSize: { options: [9, 11, 13, 'default', 17, 19, 21], supportAllValues: false },
            fontColor: { columns: 5, documentColors: 5 }
        }).catch(error => { console.error(`Editor ${id} error:`, error); });
    });
</script>
@endpush
@endsection