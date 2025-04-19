@extends('layouts.app')

@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Jenis
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Jenis Kendaraan</div>
                    <div class="col  d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" id="modals" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
                    </div>
                </div>

                <div class="text-center">
                    <table class="table table-bordered " id="jenis_table">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1 text-center">No</th>
                                <th scope="col" class="col-10 text-center">Jenis Item</th>
                                <th scope="col" class="col-1 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis as $jenis_mobil)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $jenis_mobil->jenis_item }}</td>
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm edit_jenis_kendaraan"
                                                    data-jenis_id="{{ $jenis_mobil->id }}"
                                                    data-jenis_item="{{ $jenis_mobil->jenis_item }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_edit"><i class="bi bi-pencil-square"
                                                        style="pointer-events: none;"></i></button>
                                                <button class="btn btn-sm"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!--------------------------------------------------- Modals ------------------------------------------------->
    <div class="modal fade" id="modal_tambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Tambah Jenis Kendaraan</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="add_jenis" method="POST" action="{{ route('jenis.add') }}">
                            @csrf
                            <div class="col p-5">
                                <div class="mb-3">
                                    <label for="jenis" class="fw-bold mb-2 fs-5">Jenis Kendaraan</label>
                                    <input type="text" name="jenis"
                                        class="form-control @error('jenis') is-invalid @enderror" required
                                        autocomplete="jenis" id="jenis">
                                    @error('jenis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer bg-blue-custom">
                    <button type="submit" id="add" class="btn btn-light">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal">Batal</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Edit Jenis Kendaraan</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <form method="POST" action="" id="edit_jenis_form">
                            @csrf
                            @method('put')
                            <div class="col p-5">
                                <div class="mb-3">
                                    <input type="hidden" name="jenis_id" id="edit_id_jenis">
                                    <label for="jenis" class="fw-bold mb-2 fs-5">Jenis Kendaraan</label>
                                    <input type="text" name="edit_jenis"
                                        class="form-control @error('edit_jenis') is-invalid @enderror" required
                                        autocomplete="jenis" id="edit_jenis_item">
                                    @error('edit_jenis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer bg-blue-custom">
                    <button type="submit" id="edit_button" class="btn btn-light">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal_edit">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#jenis_table').DataTable();
            });
        </script>
    @endpush

    <script type="module">
        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_jenis_kendaraan')) {
                var jenisId = event.target.dataset.jenis_id;
                var jenis = event.target.dataset.jenis_item;

                var editJenisForm = document.getElementById('edit_jenis_form');
                var editIdInput = document.getElementById('edit_id_jenis');
                var editJenisInput = document.getElementById('edit_jenis_item');

                editIdInput.value = jenisId;
                editJenisInput.value = jenis;
                editJenisForm.action = '/jenis/edit/' + jenisId;

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
                        document.getElementById('add_jenis').submit();

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
                        document.getElementById('edit_jenis_form').submit();
                    }
                });
            });

        });
    </script>
@endsection

{{-- // window.location.href =
//     "{{ route('produk.cancelPesan', ['id' => $transaksiuser->id]) }}"; --}}
