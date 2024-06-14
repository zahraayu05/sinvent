@extends('layouts.adm-main')

@section('content')
<div class="container">
    <h2>Search Results for "{{ $query }}"</h2>

    @if($resultsBarang->isEmpty())
        <p>No Barang found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Seri</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultsBarang as $result)
                    <tr>
                        <td>{{ $result->merk }}</td>
                        <td>{{ $result->seri }}</td>
                        <td>{{ $result->spesifikasi }}</td>
                        <td>{{ $result->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if($resultsKategori->isEmpty())
        <p>No Kategori found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Merk</th>
                    <th>Seri</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultsKategori as $result)
                    <tr>
                        <td>{{ $result->deskripsi }}</td>
                        <td>{{ $result->kategori }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
