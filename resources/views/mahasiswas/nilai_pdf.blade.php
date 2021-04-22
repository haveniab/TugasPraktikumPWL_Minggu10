@extends('mahasiswas.layout')
@section('content')
<div class="container">
    <div class="text-center">
        <h3>JURUSAN TEKNOLOGI INFORMASI POLITEKNIK NEGERI MALANG</h3>
        <br>
        <h6>KARTU HASIL STUDI (KHS)</h2>
        <br>
    </div>

@if($mahasiswa)
<p><strong>Nim&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Nim }}</p>
<p><strong>Nama&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Nama }}</p>
<p><strong>Kelas&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Kelas->nama_kelas }}</p>
@else
<h2>Belum ada data!</h2>
@endif
<table class="table table-bordered">
    <tr>
        <th>Mata Kuliah</th>
        <th>SKS</th>
        <th>Semester</th>
        <th>Nilai</th>
    </tr>

    @foreach($nilai as $Nilai)
    <tr>
    <td>{{ $Nilai->matakuliah->nama_matkul }}</td>
        <td>{{ $Nilai->matakuliah->sks }}</td>
        <td>{{ $Nilai->matakuliah->semester }}</td>
        <td>{{ $Nilai->nilai }}</td>
    </tr>
    @endforeach
    </table>
</div>
@endsection