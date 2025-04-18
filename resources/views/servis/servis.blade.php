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
                                <th scope="col" class="col-auto">Kode Servis Masuk</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Tanggal Masuk</th>
                                <th scope="col" class="col-auto">Tanggal Keluar</th>
                                <th scope="col" class="col-auto">Jenis</th>
                                <th scope="col" class="col-auto">Kendaraan</th>
                                <th scope="col" class="col-auto">Jumlah</th>
                                <th scope="col" class="col-auto">Status</th>
                                <th scope="col" class="col-auto">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($servis as $serviss)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $serviss->id }}</td>
                                    <td>{{ $serviss->kendaraan->plat_nomor }}</td>
                                    <td>{{ toIndoDate($serviss->tanggal_masuk) }}</td>
                                    @if ($serviss->tanggal_selesai == null)
                                        <td>Sedang Dikerjakan</td>
                                    @else
                                        <td>{{ toIndoDate($serviss->tanggal_selesai) }}</td>
                                    @endif
                                    <td>{{ $serviss->kendaraan->jenis->jenis_item }}</td>
                                    <td>{{ $serviss->kendaraan->merk->merk_item }}</td>
                                    <td>{{ $serviss->kendaraan->jumlah }}</td>
                                    <td>
                                        @if ($serviss->status == 1)
                                            Dikerjakan
                                        @else
                                            Selesai
                                        @endif
                                    </td>
                                    <td><button class="btn btn-sm edit_servis_kendaraan" data-servis_id='{{ $serviss->id }}'
                                            data-kendaraan_id='{{ $serviss->kendaraan_id }}'
                                            data-tanggal_masuk='{{ $serviss->tanggal_masuk }}'
                                            data-tanggal_keluar='{{ $serviss->tanggal_selesai }}'
                                            data-status='{{ $serviss->status }}' data-bs-toggle="modal"
                                            data-bs-target="#modal_edit"><i class="bi bi-pencil-square "style="pointer-events: none;"></i></button>

                                        <form id="hapus_servis" method="POST" action="{{ route('servis.hapus', ['id' => $serviss->id]) }}" class="d-inline"> 
                                        @csrf
                                            @method('put') 
                                        <button class="btn btn-sm" id="delete_servis"
                                            style="padding: 0.25rem 0.5rem; border: none; background: none;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        </form>
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
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white">Data Servis Selesai</h1>
                </div>
                <form id="edit_servis_form" method="POST" action="">
                    @method('put')
                    @csrf
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" hidden id="edit_id_servis" class="form-control">

                            <div class="mb-3">
                                <label for="kode_item_masuk">Kode Servis</label>
                                <input type="text" disabled id="edit_kode_item_masuk" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="edit_kode_item">Kode Item*</label>
                                <select class="form-select @error('edit_kode_item') is-invalid @enderror" name="kode_item"
                                    id="edit_kode_item">
                                    <option disabled selected class="text-center">--- Pilih ---</option>
                                    @foreach ($kendaraan as $kendaraans)
                                        <option value="{{ $kendaraans->id }}"
                                            {{ old('kendaraans') == $kendaraans->id ? 'selected' : '' }}
                                            class="text-center">
                                            {{ $kendaraans->id }} - {{ $kendaraans->nama_kendaraan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('edit_kode_item')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk"
                                    class="form-control @error('tanggal_masuk') is-invalid @enderror "
                                    id="edit_tanggal_masuk">
                                @error('tanggal_masuk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="tanggal_keluar">Tanggal Keluar</label>
                                <input type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror "
                                    name="tanggal_keluar" id="edit_tanggal_keluar">
                                @error('tanggal_keluar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="edit_status"
                                name="status">
                                <option disabled selected class="text-center">--- Pilih ---</option>
                                <option value="1" class="text-center">Dikerjakan</option>
                                <option value="2" class="text-center">Selesai</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="submit" id="edit_button" class="btn btn-light">Simpan</button>
                    <button type="button" id="batal_edit" class="btn btn-light">Batal</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Selesai</h1>

                </div>
                <form id="add_servis" method="POST" action="{{ route('servis.add') }}">
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kode_item_masuk">Kode Servis</label>
                                    <input type="text" disabled id="kode_item_masuk" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kode_item">Kode Item*</label>
                                    <select class="form-select @error('kode_item') is-invalid @enderror" name="kode_item"
                                        id="kode_item">
                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        @foreach ($kendaraan as $kendaraans)
                                            <option value="{{ $kendaraans->id }}" class="text-center">
                                                {{ $kendaraans->id }} - {{ $kendaraans->nama_kendaraan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kode_item')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk"
                                        class="form-control @error('tanggal_masuk') is-invalid @enderror "
                                        id="tanggal_masuk">
                                    @error('tanggal_masuk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="tanggal_keluar">Tanggal Keluar</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_keluar') is-invalid @enderror "
                                        name="tanggal_keluar" id="tanggal_keluar">
                                    @error('tanggal_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="status">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option disabled selected class="text-center">--- Pilih ---</option>
                                    <option value="1" class="text-center">Dikerjakan</option>
                                    <option value="2" class="text-center">Selesai</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                </form>
                {{-- <div class="col-6">
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
                        <div class="col-6">
                            <label for="jenis">Jenis</label>
                            <select class="form-select" id="jenis">
                                <option selected class="text-center">--- Pilih ---</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input type="text" class="form-control" id="nama_kendaraan">
                            </div>
                        </div> --}}

            </div>
            {{-- <div class="mt-1 row d-flex align-items-center justify-content-end">
                        <div class="col-6">
                            <div class="me-2">Jumlah :</div>
                            <input type="text" class="form-control w-auto" id="merk"> <!-- Input kecil -->
                        </div>
                    </div> --}}
        </div>

        <div class="modal-footer bg-blue-custom">
            <button type="submit" id="add" class="btn btn-light">Simpan</button>
            <button type="button" id="batal" class="btn btn-light">Batal</button>
        </div>
    </div>





    {{-- </div>
    </div> --}}


    <script type="module">
        // const myModal = new bootstrap.Modal('#modal_edit', {
        //     keyboard: true
        // })
        // window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_servis_kendaraan')) {
                var servisId = event.target.dataset.servis_id;
                var kendaraanId = event.target.dataset.kendaraan_id;
                var tanggalMasuk = event.target.dataset.tanggal_masuk;
                var tanggalKeluar = event.target.dataset.tanggal_keluar;
                var status = event.target.dataset.status;

                var editservisForm = document.getElementById('edit_servis_form');
                var editIdInput = document.getElementById('edit_id_servis');
                var editKendaraanIdInput = document.getElementById('edit_kode_item');
                var editTanggalMasukInput = document.getElementById('edit_tanggal_masuk');
                var editTanggalKeluarInput = document.getElementById('edit_tanggal_keluar');
                var editStatusInput = document.getElementById('edit_status');

               
            
                editIdInput.value = servisId;
                editKendaraanIdInput.value = kendaraanId;
                editTanggalKeluarInput.value = tanggalKeluar.split(' ')[0];
                editTanggalMasukInput.value = tanggalMasuk.split(' ')[0];
                editStatusInput.value = status;
                editservisForm.action = '/servis/edit/' + servisId;

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
                        document.getElementById('add_servis').submit();

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
                        document.getElementById('edit_servis_form').submit();
                    }
                });
            });

        });

        
        $(document).ready(function() {
            $(document).on('click', '#delete_servis', function(e) {
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
                        document.getElementById('hapus_servis').submit();
                    }

                });
            });

        });
    </script>
@endsection
