@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Merk
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Merk Kendaraan</div>
                    <div class="col  d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered " id="merk_table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center col-0">No</th>
                                <th scope="col" class="text-center col-6">Jenis Item</th>
                                <th scope="col" class="text-center col-6">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merk as $merks)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td class="text-center">{{ $merks->merk_item }}</td>
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm  edit_merk_kendaraan"
                                                    data-merk_id="{{ $merks->id }}"
                                                    data-merk_item="{{ $merks->merk_item }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_edit"><i class="bi bi-pencil-square"
                                                        style="pointer-events: none;"></i></button>
                                                <form method="POST"
                                                    action="{{ route('merk.hapus', ['id' => $merks->id]) }}"
                                                    class="d-inline merk_hapus" style="display: inline;">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-sm delete_merk"
                                                        style="padding: 0.25rem 0.5rem; border: none; background: none;">
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
        </div>
    </div>
    <!--------------------------------------------------- Modals ------------------------------------------------->
    <div class="modal fade" id="modal_tambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Tambah Merk Kendaraan</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="add_merk" method="POST" action="{{ route('merk.add') }}">
                            @csrf
                            <div class="col p-5">
                                <div class="mb-3">
                                    <label for="merk" class="fw-bold mb-2 fs-5">Merk Kendaraan</label>
                                    <input type="text" name="merk"
                                        class="form-control @error('merk') is-invalid @enderror" required
                                        autocomplete="merk" id="merk">

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
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Edit Merk Kendaraan</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <form method="POST" action="" id="edit_merk_form">
                            @csrf
                            @method('put')
                            <div class="col p-5">
                                <div class="mb-3">
                                    <input type="hidden" name="merk_id" id="edit_id_merk">
                                    <label for="merk" class="fw-bold mb-2 fs-5">Merk Kendaraan</label>
                                    <input type="text" name="edit_merk"
                                        class="form-control @error('edit_merk') is-invalid @enderror" required
                                        autocomplete="merk" id="edit_merk_item">
                                    @error('edit_merk')
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
                $('#merk_table').DataTable();
            });
        </script>
    @endpush
    <script type="module">
        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_merk_kendaraan')) {
                var merkId = event.target.dataset.merk_id;
                var merk = event.target.dataset.merk_item;

                var editmerkForm = document.getElementById('edit_merk_form');
                var editIdInput = document.getElementById('edit_id_merk');
                var editmerkInput = document.getElementById('edit_merk_item');

                editIdInput.value = merkId;
                editmerkInput.value = merk;
                editmerkForm.action = '/merk/edit/' + merkId;

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
                        document.getElementById('add_merk').submit();

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
                        document.getElementById('edit_merk_form').submit();
                    }
                });
            });

        });

        $(document).ready(function() {
            $(document).on('click', '.delete_merk', function(e) {
                e.preventDefault();
                const form = $(this).closest('.merk_hapus');

                Swal.fire({
                    title: 'Hapus Data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
