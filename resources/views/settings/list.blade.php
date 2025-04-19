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
                    <div class="col fw-bold fs-5 align-items-center">Data Merk Kendaraan</div>
                    <div class="col  d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" id="modals" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered " id="list_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center col-auto">No</th>
                                <th scope="col" class="text-center col-auto">Email</th>
                                <th scope="col" class="text-center col-auto">Jabatan</th>
                                <th scope="col" class="text-center col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($list as $items)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $items->email }}</td>
                                    @if ($items->role_id == 1)
                                        <td>Superadmin</td>
                                    @else
                                        <td>Admin</td>
                                    @endif
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm edit_user" data-user_id="{{ $items->id }}"
                                                    data-email="{{ $items->email }}"
                                                    data-role="{{ $items->role_id }}"data-password="{{ $items->password }}"
                                                    data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                        class="bi bi-pencil-square"
                                                        style="pointer-events: none;"></i></button>
                                                        <form id="hapus_form" action="{{ route('list.hapus', ['id' => $items->id]) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('put')
                                                            <button id="hapus_button" type="submit" class="btn btn-sm p-0 border-0 bg-transparent">
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
        <!--------------------------------------------------- Modals ------------------------------------------------->
        <div class="modal fade" id="modal_tambah" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue-custom">
                        <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Tambah User</h1>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="add_list" method="POST" action="{{ route('list.add') }}">
                                @csrf
                                <div class="col p-5">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                                id="email" name="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="role">Jabatan</label>
                                            <select class="form-select @error('role') is-invalid @enderror" id="role"
                                                name="role">
                                                <option selected value="0">Admin</option>
                                                <option value="1">Superadmin</option>
                                            </select>
                                            @error('role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="text"
                                                class="form-control  @error('password') is-invalid @enderror" id="password"
                                                name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
                            <form method="POST" action="" id="edit_user_form">
                                @csrf
                                @method('put')
                                <div class="col p-5">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input type="text"
                                                class="form-control  @error('email') is-invalid @enderror" id="edit_email"
                                                name="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="role">Jabatan</label>
                                            <select class="form-select @error('role') is-invalid @enderror" id="edit_role"
                                                name="role">
                                                <option value="0">Admin</option>
                                                <option value="1">Superadmin</option>
                                            </select>
                                            @error('role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="text"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                id="edit_password" name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#list_table').DataTable();
            });
        </script>
    @endpush
    <script type="module">
        // const myModal = new bootstrap.Modal('#modal_tambah', {
        //             keyboard: true
        //         })
        //         window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_user')) {
                var userId = event.target.dataset.user_id;
                var email = event.target.dataset.email;
                var role = event.target.dataset.role;

                var edituserForm = document.getElementById('edit_user_form');

                var editemailInput = document.getElementById('edit_email');
                var editroleInput = document.getElementById('edit_role');


                editemailInput.value = email;
                editroleInput.value = role;
                edituserForm.action = '/user/edit/' + userId;

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
                        document.getElementById('add_list').submit();

                    }

                });
            });

        });

        $(document).ready(function() {
            $(document).on('click', '#hapus_button', function(e) {
                e.preventDefault();
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
                        document.getElementById('hapus_form').submit();
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
                        document.getElementById('edit_user_form').submit();
                    }
                });
            });

        });
    </script>
@endsection
