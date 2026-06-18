@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Video Pembelajaran" subtitle="Perbarui data video pembelajaran" :breadcrumbs="['Datapedia','Edukasi','Video','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-video"></i>Form Edit Video</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('admin_video-pembelajaran.update', $video_pembelajaran->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Subjek Materi</label><select name="subjek_materi_id" class="form-input form-select" required>@foreach($subjek_materi??[] as $item)<option value="{{$item->id}}" {{ old('subjek_materi_id', $video_pembelajaran->subjek_materi_id)==$item->id?'selected':'' }}>{{$item->judul}}</option>@endforeach</select></div>
            <div style="margin-bottom:14px"><label class="form-label">Judul Video</label><input type="text" name="judul" value="{{ old('judul', $video_pembelajaran->judul) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Deskripsi</label><input type="text" name="deskripsi" value="{{ old('deskripsi', $video_pembelajaran->deskripsi) }}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Link Video</label><input type="text" name="link" value="{{ old('link', $video_pembelajaran->link) }}" class="form-input" placeholder="https://youtube.com/..."></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('admin_video-pembelajaran.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection