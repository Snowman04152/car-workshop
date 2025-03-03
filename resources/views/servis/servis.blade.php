@extends('layouts.app')
@section('content')
<div class="col-10 p-3">
    <div class="p-0 ms-5 fs-2 fw-bold">
        <div class="ms-5">
            Service
        </div>
    </div>
    <div class="ms-5 mt-3">
        <div class="container bg-white p-3 ms-5 w-auto shadow">
            <div class="row d-flex justify-content-between">
                <div class="col fw-bold fs-5 align-items-center">Data Jenis Item</div>
                <div class="col  d-flex justify-content-end ">
                    <div class="btn btn-primary">
                        Tambah Data <i class="bi bi-plus-circle"></i></div>
                </div>
            </div>
            <div class="my-5 row d-flex justify-content-between">
                <div class="col  fs-5 align-items-center">Show <div class="btn btn-primary btn-rounded shadow-md">2 <i
                            class="bi bi-chevron-down"></i> </div> entries</div>
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
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th scope="row" class="text-center">1</th>
                            <td>30 Desember 2023</td>
                            <td>MBL - 1827283930</td>
                            <td>MBL - 1827283930</td>
                            <td>Gajah</td>
                            <td>Avanza</td>
                            <td >10</td>    
                        </tr>
                        <tr>
                            <th scope="row" class="text-center">2</th>
                            <td>30 Desember 2023</td>
                            <td>MBL - 1827283930</td>
                            <td>MBL - 1827283930</td>
                            <td>Gajah</td>
                            <td>Avanza</td>
                            <td >10</td>    
                        </tr>
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