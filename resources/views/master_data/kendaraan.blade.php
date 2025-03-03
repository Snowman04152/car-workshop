@extends('layouts.app')

@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Kendaraan
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Kendaraan</div>
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
                    <table class="table table-bordered ">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto">Gambar</th>
                                <th scope="col" class="col-auto">Kode</th>
                                <th scope="col" class="col-auto">Nama Kendaraan</th>
                                <th scope="col" class="col-auto">Jenis</th>
                                <th scope="col" class="col-auto">Merk</th>
                                <th scope="col" class="col-auto">Jumlah Item</th>
                                <th scope="col" class="col-auto">Keterangan</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row gap-5 p-2">
                        <div class="col">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kode_item">Kode Item*</label>
                                    <input type="text" class="form-control" id="kode_item">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama_kendaraan">Nama Kendaraan*</label>
                                    <input type="text" class="form-control" id="nama_kendaraan">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="jenis">Jenis*</label>
                                    <select class="form-select" id="jenis" aria-label="Default select example">
                                        <option selected>--- Pilih ---</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="merk">Merk*</label>
                                    <select class="form-select" id="merk" aria-label="Default select example">
                                        <option selected>--- Pilih ---</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="jumlah">Jumlah Item</label>
                                    <input type="text" class="form-control" id="jumlah">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ">
                            <div class="mb-3">Foto</div>
                            <img class="w-75 p-2 border border-primary rounded-2"
                                src="{{ Vite::asset('resources/images/image-icon.png') }}" alt="">
                            <input type="file" class="form-control mt-3 w-75" id="inputGroupFile04"
                                aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Simpan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
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
