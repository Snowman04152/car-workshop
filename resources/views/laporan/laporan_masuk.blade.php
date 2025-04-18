@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Laporan Masuk
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Laporan Masuk</div>
                    {{-- <div class="col  d-flex justify-content-end ">
                        <div class="btn btn-primary">
                            Tambah Data <i class="bi bi-plus-circle"></i></div>
                    </div> --}}

                </div>
                <div class="my-2 row d-flex justify-content-between">
                    <label for="tanggal" class="form-label">Filter tanggal</label>
                    <div class="col  fs-5 align-items-center">
                        <form>
                            <div>
                                <div class="d-flex gap-3">
                                    <input type="date" class="form-control w-25" id="tanggal" name="tanggal" required>
                                    <input type="date" class="form-control w-25" id="tanggal" name="tanggal" required>
                                    <a class="btn btn-primary col-2 rounded-0" href="{{ route('laporanmasuk.exportExcel') }}" >
                                        Excel
                                    </a>
                                    <a class="btn btn-outline-primary col-2 rounded-0" href="{{ route('laporanmasuk.exportPdf') }}">
                                        Pdf
                                    </a>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col  d-flex justify-content-end ">
                        <div class="search-container">
                            <!-- Input Search -->
                            <input type="text" class="search-input" placeholder="Search...">
                            <!-- Ikon Search -->
                            <button class="search-button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-5 fs-5 align-items-center">Show <div class="btn btn-primary btn-rounded shadow-md">2 <i
                    class="bi bi-chevron-down"></i> </div> entries</div>
                <div class="">
                    <table class="table table-bordered ">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto">Tanggal Masuk</th>
                                <th scope="col" class="col-auto">Kode Servis Masuk</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Jenis</th>
                                <th scope="col" class="col-auto">Kendaraan</th>
                                <th scope="col" class="col-auto">Jumlah</th>
                                <th scope="col" class="col-auto">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($laporan_masuk as $item)
                            <tr>
                                <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                <td>{{toIndoDate($item->tanggal_masuk)}}</td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->kendaraan->plat_nomor}}</td>
                                <td>{{$item->kendaraan->jenis->jenis_item}}</td>
                                <td>{{$item->kendaraan->merk->merk_item}}</td>
                                <td>{{$item->kendaraan->jumlah}}</td>
                                <td>
                                    @if ($item->status == 1)
                                        Dikerjakan
                                    @else
                                        Selesai
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row ms-5 p-3 d-flex justify-content-between ">
                <div class="col fw-bold"> Showing 1 to 2 Entries</div>
                <div class="col d-flex justify-content-end align-items-center">
                    <div class="btn custom-btn w-25">Previous</div>
                    <div class="p-2 bg-light">1</div>
                    <div class="btn custom-btn w-25">Next</div>
                </div>
            </div>
        </div>
    </div>
@endsection
