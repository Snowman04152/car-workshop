@extends('layouts.app')

@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Dashboard
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Jenis Item</div>
                    <div class="col  d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
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
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Kendaraan</th>
                                <th scope="col" class="col-auto">Merk</th>
                                <th scope="col" class="col-auto">Jenis</th>
                                <th scope="col" class="col-auto">Usia Mesin</th>
                                <th scope="col" class="col-auto">Kerusakan</th>
                                <th scope="col" class="col-auto">Jam Operasi Perbulan</th>
                                <th scope="col" class="col-auto">Bulan Terakhir Servis</th>
                                <th scope="col" class="col-auto">Servis Selanjutnya</th>
                                <th scope="col" class="col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-center">1</th>
                                <td>X-2901</td>
                                <td>Mobil</td>
                                <td>Avanza</td>
                                <td>Gajah</td>
                                <td>3</td>
                                <td>Servis Rutin</td>
                                <td>156</td>
                                <td>Juni 2024</td>
                                <td>3 Bulan Lagi</td>
                                <td>
                                    <div class="row d-flex gap-0 justify-content-center">
                                        <div class="col-auto ">
                                            <div class="btn btn-sm"><i class="bi bi-pencil-square"></i></div>
                                            <div class="btn btn-sm"><i class="bi bi-trash"></i></div>
                                        </div>
                                    </div>
                                </td>
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
    <!--------------------------------------------------- Modals ------------------------------------------------->
    <div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="kode_item_masuk">Kode Item Masuk</label>
                                <input type="text" id="kode_item_masuk" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input type="text" class="form-control" id="nama_kendaraan">
                            </div>
                            <div class="mb-3">
                                <label for="jenis">Jenis</label>
                                <select class="form-select" id="jenis">
                                    <option selected class="text-center">--- Pilih ---</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="merk">Merk</label>
                                <select class="form-select" id="merk">
                                    <option selected class="text-center">--- Pilih ---</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    
                        <!-- Kolom Kanan -->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="kode_item">Kode Item*</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="kode_item" placeholder="Search...">
                                    <span class="input-group-text" style="cursor: pointer;">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="usia_mesin">Usia Mesin</label>
                                <input type="text" class="form-control" id="usia_mesin">
                            </div>
                            <div class="mb-3">
                                <label for="kerusakan">Kerusakan</label>
                                <input type="text" class="form-control" id="kerusakan">
                            </div>
                            <div class="mb-3">
                                <label for="jam_operasi">Jam Operasi Perbulan</label>
                                <input type="text" class="form-control" id="jam_operasi">
                            </div>
                        </div>
                    
                        <!-- Baris Baru untuk "Bulan Terakhir Servis" -->
                        <div class="col-12">
                            <div class="mb-3 d-flex justify-content-end">
                                <div class="w-50">
                                    <label for="bulan_terakhir" class="form-label">Bulan Terakhir Servis</label>
                                    <input type="month" class="form-control" id="bulan_terakhir">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Simpan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    <script type="module">
        const myModal = new bootstrap.Modal('#modal_tambah', {
            keyboard: true
        })
        // window.onload = myModal.show();
    </script>
@endsection
