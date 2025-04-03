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
                            @foreach ($kendaraan as $kendaraans)
                                <tr class="text-center">
                                    <th scope="row">1</th>
                                    <td><img class="w-25"
                                            src="{{ asset('storage/files/' . $kendaraans->encrypted_filename) }}"
                                            alt=""></td>
                                    <td>X-000{{ $kendaraans->id }}</td>
                                    <td>{{ $kendaraans->nama_kendaraan }}</td>
                                    <td>{{ $kendaraans->jenis->jenis_item }}</td>
                                    <td>{{ $kendaraans->merk->merk_item }}</td>
                                    <td>{{ $kendaraans->jumlah }}</td>
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm edit_kendaraan"
                                                    data-kendaraan_id="{{ $kendaraans->id }}"
                                                    data-nama_kendaraan="{{ $kendaraans->nama_kendaraan }}"
                                                    data-jenis_kendaraan="{{ $kendaraans->id_jenis}}"
                                                    data-merk_kendaraan="{{ $kendaraans->id_merk }}"
                                                    data-jumlah="{{ $kendaraans->jumlah }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_edit"><i
                                                        class="bi bi-pencil-square" style="pointer-events: none;"></i></button>

                                                        <form id="hapus_kendaraan" method="POST" action="{{ route('kendaraan.hapus', ['id' => $kendaraans->id]) }}" class="d-inline">
                                                            @csrf
                                                            @method('put')
                                                            <button class="btn btn-sm" id="delete_kendaraan" style="padding: 0.25rem 0.5rem; border: none; background: none;">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                            </div>
                                        </div>
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
    <!--------------------------------------------------- Modals ------------------------------------------------->
    <div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row gap-5 p-2">
                        <form id="add_kendaraan" action="{{ route('kendaraan.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kode_item">Kode Item*</label>
                                        <input type="text" disabled class="form-control" id="kode_item">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_kendaraan">Nama Kendaraan*</label>
                                        <input type="text"
                                            class="form-control  @error('nama_kendaraan') is-invalid @enderror"
                                            id="nama_kendaraan" name="nama_kendaraan">
                                        @error('nama_kendaraan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jenis">Jenis*</label>
                                        <select class="form-select  @error('jenis') is-invalid @enderror" id="jenis"
                                            name="jenis" aria-label="Default select example">
                                            <option>--- Pilih ---</option>
                                            @foreach ($jenis as $jeniss)
                                                <option value="{{ $jeniss->id }}">{{ $jeniss->jenis_item }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="merk">Merk*</label>
                                        <select class="form-select  @error('merk') is-invalid @enderror" id="merk"
                                            name="merk" aria-label="Default select example">
                                            <option>--- Pilih ---</option>
                                            @foreach ($merk as $merks)
                                                <option value="{{ $merks->id }}">{{ $merks->merk_item }}</option>
                                            @endforeach
                                        </select>
                                        @error('merk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jumlah">Jumlah Item</label>
                                        <input type="text" class="form-control  @error('jumlah') is-invalid @enderror"
                                            name="jumlah" id="jumlah">
                                    </div>
                                    @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-auto ">
                                <div class="mb-3">Foto</div>

                                <input type="file"
                                    class="form-control mt-3 w-75  @error('gambar') is-invalid @enderror" id="gambar"
                                    name="gambar" aria-label="Upload">
                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="submit" class="btn btn-light" id="add">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row gap-5 p-2">
                        <form id="edit_kendaraan_form" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="col">
                                <input type="hidden" name="kendaraan_id" id="edit_id_kendaraan">

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kode_item">Kode Item*</label>
                                        <input type="text" disabled class="form-control" id="kode_item">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_kendaraan">Nama Kendaraan*</label>
                                        <input type="text"
                                            class="form-control  @error('nama_kendaraan') is-invalid @enderror"
                                            id="edit_nama_kendaraan" name="nama_kendaraan">
                                        @error('nama_kendaraan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jenis">Jenis*</label>
                                        <select class="form-select  @error('jenis') is-invalid @enderror" name="jenis"
                                            id="edit_jenis_kendaraan" aria-label="Default select example">
                                            <option>--- Pilih ---</option>
                                            
                                            @foreach ($jenis as $jeniss)
                                            
                                                <option value="{{ $jeniss->id }}"
                                                    {{ old('jeniss') == $jeniss->id ? 'selected' : '' }}>
                                                    {{ $jeniss->jenis_item }}
                                                </option>
                                            
                                            @endforeach
                                        </select>
                                        @error('jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="merk">Merk*</label>
                                        <select class="form-select   @error('merk') is-invalid @enderror"
                                            id="edit_merk_kendaraan" name="merk" aria-label="Default select example">
                                            <option>--- Pilih ---</option>
                                            @foreach ($merk as $merks)
                                                <option value="{{ $merks->id }}">{{ $merks->merk_item }}</option>
                                            @endforeach
                                        </select>
                                        @error('merk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jumlah">Jumlah Item</label>
                                        <input type="text" class="form-control  @error('jumlah') is-invalid @enderror"
                                            name="jumlah" id="edit_jumlah">
                                    </div>
                                    @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-auto ">
                                <div class="mb-3">Foto</div>

                                <input type="file"
                                    class="form-control mt-3 w-75  @error('gambar') is-invalid @enderror" id="edit_gambar"
                                    name="gambar" aria-label="Upload">
                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" id="edit_button"
                        >Simpan</button>
                    <button type="button" class="btn btn-light" id="batal_edit" >Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_kendaraan')) {
                var kendaraanId = event.target.dataset.kendaraan_id;
                var namaKendaraan = event.target.dataset.nama_kendaraan;
                var jenisKendaraan = event.target.dataset.jenis_kendaraan;
                var merkKendaraan = event.target.dataset.merk_kendaraan;
                var jumlah = event.target.dataset.jumlah;

                // console.log(jumlah);

                var editkendaraanForm = document.getElementById('edit_kendaraan_form');
                var editIdInput = document.getElementById('edit_id_kendaraan');
                var editNamakendaraanInput = document.getElementById('edit_nama_kendaraan');
                var editJeniskendaraanInput = document.getElementById('edit_jenis_kendaraan');
                var editMerkkendaraanInput = document.getElementById('edit_merk_kendaraan');
                var editJumlahInput = document.getElementById('edit_jumlah');
                // var editGambarInput = document.getElementById('edit_gambar');

                editIdInput.value = kendaraanId;
                editNamakendaraanInput.value = namaKendaraan;
                editJeniskendaraanInput.value = jenisKendaraan;
                editMerkkendaraanInput.value = merkKendaraan;
                editJumlahInput.value = jumlah;

                editkendaraanForm.action = '/kendaraan/edit/' + kendaraanId;

            }
        });

        @if (session('modal_open'))
            const myModal = new bootstrap.Modal('#modal_tambah', {
                keyboard: true
            })
            window.onload = myModal.show();
        @endif

        $(document).ready(function() {
            $(document).on('click', '#batal', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Batalkan Data?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let modalElement = document.getElementById('modal_tambah');
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                    }

                });
            });

        });

        $(document).ready(function() {
            $(document).on('click', '#batal_edit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Batalkan Data?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let modalElement = document.getElementById('modal_edit');
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                    }

                });
            });

        });

        $(document).ready(function() {
            $(document).on('click', '#add', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambahkan Data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('add_kendaraan').submit();

                    }

                });
            });

        });


        $(document).ready(function() {
            $(document).on('click', '#edit_button', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambahkan Data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('edit_kendaraan_form').submit();
                    }
                });
            });

        });

        $(document).ready(function() {
            $(document).on('click', '#delete_kendaraan', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('hapus_kendaraan').submit();
                    }

                });
            });

        });

    </script>
@endsection
