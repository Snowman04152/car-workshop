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
                                <th scope="col" class="col-auto">Gambar Item</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Nama Mobil</th>
                                <th scope="col" class="col-auto">Rincian Servis</th>
                                <th scope="col" class="col-auto">Waktu Servis</th>
                                <th scope="col" class="col-auto">Status</th>
                                <th scope="col" class="col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-center">1</th>
                                <td><img class="w-25" src="{{ Vite::asset('resources/images/image-icon.png') }}"
                                        alt=""></td>
                                <td>X-2901</td>
                                <td>Lamborghini</td>
                                <td>Servis Rutin</td>
                                <td>45 Hari Lagi</td>
                                <td>Belum Servis</td>
                                <td>
                                    <div class="row d-flex gap-0 justify-content-center">
                                        <div class="col-auto ">
                                            <div class="btn btn-sm"><i class="bi bi-pencil-square"></i></div>
                                            <div class="btn btn-sm"><i class="bi bi-trash"></i></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-center">2</th>
                                <td><img class="w-25" src="{{ Vite::asset('resources/images/image-icon.png') }}"
                                        alt=""></td>
                                <td>X-2901</td>
                                <td>Lamborghini</td>
                                <td>Servis Rutin</td>
                                <td>45 Hari Lagi</td>
                                <td>Belum Servis</td>
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
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="kode_item_masuk">Kode Item Masuk</label>
                                <input type="text" id="kode_item_masuk" class="form-control">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="kode_item">Kode Item*</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="kode_item" placeholder="Search...">
                                    <span class="input-group-text" style="cursor: pointer;">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="rincian_servis">Rincian Servis</label>
                                <input type="text" class="form-control" id="rincian_ servis">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input type="text" class="form-control" id="nama_kendaraan">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="jenis">Jenis</label>
                                <input type="text" class="form-control" id="jenis">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <label for="merk">Merk</label>
                                <input type="text" class="form-control" id="merk">
                            </div>
                        </div>

                    </div>
                    <div class="mt-3 d-flex align-items-center justify-content-end">
                        <div class="me-2">Jumlah :</div> 
                        <input type="text" class="form-control w-auto" id="merk" style="max-width: 100px;"> <!-- Input kecil -->
                      </div>
                </div>

                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Simpan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        const myModal = new bootstrap.Modal('#modal_tambah', {
            keyboard: true
        })
        window.onload = myModal.show();
    </script>
@endsection
