@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2 align="center">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                <br>
                <h1 align="center">KARTU HASIL STUDI (KHS)</h1>
            </div>
            <br><br>
            <div class="float-left my-2">
                <p><strong>Nama :</strong> {{ $nilai->nama }}</p>
                <p><strong>NIM :</strong> {{ $nilai->nim }}</p>
                <p><strong>Kelas :</strong> {{ $nilai->kelas->nama_kelas }}</p>
            </div>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <tr>
            <th><strong>Mata Kuliah</strong></th>
            <th><strong>SKS</strong></th>
            <th><strong>Semester</strong></th>
            <th><strong>Nilai</strong></th>
        </tr>
        @foreach($nilai->matakuliah as $score)
        <tr>
            <td>{{$score->nama_matkul}}</td>
            <td>{{$score->sks}}</td>
            <td>{{$score->semester}}</td>
            <td>{{$score->pivot->nilai}}</td>
        </tr>
        @endforeach

    </table>
    <div class="float-right my-2">
        <a class="btn btn-success mt-3" href="{{ route('mahasiswa.index') }}">Kembali</a>
    </div>
    <div class="float-center my-2 text-center">
        <a class="btn btn-danger mt-3" href="{{ route('mahasiswa.cetak_khs',$nilai->nim) }}">Cetak PDF</a>
    </div>
    @endsection