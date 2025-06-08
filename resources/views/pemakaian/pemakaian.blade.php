@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Pemakaian
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
                <div class="">
                    <table class="table table-bordered" id="servis_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center col-auto">No</th>
                                <th scope="col" class="text-center col-auto">Plat Nomor</th>
                                <th scope="col" class="text-center col-auto">Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Supir</th>
                                <th scope="col" class="text-center col-auto">Hari</th>
                                <th scope="col" class="text-center col-auto">Jam Keluar</th>
                                <th scope="col" class="text-center col-auto">Jam Kembali</th>
                                <th scope="col" class="text-center col-auto">KM Harian Keluar</th>
                                <th scope="col" class="text-center col-auto">KM Harian Kembali</th>
                                <th scope="col" class="text-center col-auto">KM Harian</th>
                                <th scope="col" class="text-center col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemakaian as $kendaraans)
                                <tr class="">
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td class="text-center">{{ $kendaraans->kendaraan->plat_nomor }}</td>
                                    <td>{{ $kendaraans->kendaraan->nama_kendaraan }}</td>
                                    <td class="text-center">{{ $kendaraans->nama_supir }} </td>
                                    <td class="text-center">{{ toIndoDate($kendaraans->hari) }} </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($kendaraans->jam_keluar)->format('H:i') }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($kendaraans->jam_kembali)->format('H:i') }}
                                    </td>
                                    <td class="text-center">{{ $kendaraans->km_harian_keluar }}</td>
                                    @if ($kendaraans->km_harian_kembali == null || 0)
                                        <td class="text-center">Kosong</td>
                                    @else
                                        <td class="text-center">{{ $kendaraans->km_harian_kembali }}</td>
                                    @endif
                                    @if ($kendaraans->km_harian == null || 0)
                                        <td class="text-center">Kosong</td>
                                    @else
                                    <td class="text-center">{{ $kendaraans->km_harian }}</td>
                                    @endif
                                    <td><button class="btn btn-sm edit_servis_kendaraan" data-id='{{ $kendaraans->id }}'
                                            data-kendaraan_id='{{ $kendaraans->kendaraan_id }}'
                                            data-nama_supir='{{ $kendaraans->nama_supir }}'
                                            data-hari='{{ $kendaraans->hari }}'
                                            data-jam_keluar='{{ $kendaraans->jam_keluar }}'
                                            data-jam_kembali='{{ $kendaraans->jam_kembali }}'
                                            data-km_keluar='{{ $kendaraans->km_harian_keluar }}'
                                            data-km_kembali='{{ $kendaraans->km_harian_kembali }}' data-bs-toggle="modal"
                                            data-bs-target="#modal_edit"><i
                                                class="bi bi-pencil-square "style="pointer-events: none;"></i></button>

                                        <form class="hapus_servis" method="POST" style="display: inline;"
                                            action="{{ route('pemakaian.hapus', ['id' => $kendaraans->id]) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('put')
                                            <button class="btn btn-sm delete_servis"
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
        </div>
    </div>
    <!--------------------------------------------------- Modals ------------------------------------------------->
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white">Data Servis</h1>
                </div>
                <form id="edit_servis_form" method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_kode_item">Plat Nomor dan Kendaraan</label>
                                    <select class="form-select @error('edit_kode_item') is-invalid @enderror"
                                        name="edit_kode_item" id="edit_kode_item">
                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        @foreach ($kendaraan as $kendaraans)
                                            <option value="{{ $kendaraans->id }}" class="text-center">
                                                {{ $kendaraans->plat_nomor }} - {{ $kendaraans->nama_kendaraan }}
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
                                    <label for="edit_nama_supir">Nama Supir</label>
                                    <input type="text" name="edit_nama_supir"
                                        class="form-control @error('edit_nama_supir') is-invalid @enderror "
                                        id="edit_nama_supir">
                                    @error('edit_nama_supir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_km_keluar">KM Keluar</label>
                                    <input type="number"
                                        class="form-control @error('edit_km_keluar') is-invalid @enderror "
                                        name="edit_km_keluar" id="edit_km_keluar" min="0">
                                    @error('edit_km_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_km_kembali">KM Kembali</label>
                                    <input type="number"
                                        class="form-control @error('edit_km_kembali') is-invalid @enderror "
                                        name="edit_km_kembali" id="edit_km_kembali" min="0">
                                    @error('edit_km_kembali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_jam_keluar">Jam Keluar</label>
                                    <input type="time"
                                        class="form-control @error('edit_jam_keluar') is-invalid @enderror "
                                        name="edit_jam_keluar" id="edit_jam_keluar" min="0">
                                    @error('edit_jam_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_jam_kembali">Jam kembali</label>
                                    <input type="time"
                                        class="form-control @error('edit_jam_kembali') is-invalid @enderror "
                                        name="edit_jam_kembali" id="edit_jam_kembali" min="0">
                                    @error('edit_jam_kembali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-0">
                                <div class="mb-3">
                                    <label for="edit_hari">Hari</label>
                                    <input type="date" class="form-control @error('edit_hari') is-invalid @enderror "
                                        name="edit_hari" id="edit_hari">
                                    @error('edit_hari')
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
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Pemakaian </h1>

                </div>
                <form id="add_pemakaian" method="POST" action="{{ route('pemakaian.add') }}">
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kode_item">Plat Nomor dan Kendaraan</label>
                                    <select class="form-select @error('kode_item') is-invalid @enderror" name="kode_item"
                                        id="kode_item">

                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        @foreach ($kendaraan as $kendaraans)
                                            <option value="{{ $kendaraans->id }}" class="text-center">
                                                {{ $kendaraans->plat_nomor }} - {{ $kendaraans->nama_kendaraan }}
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
                                    <label for="nama_supir">Nama Supir</label>
                                    <input type="text" name="nama_supir"
                                        class="form-control @error('nama_supir') is-invalid @enderror " id="nama_supir">
                                    @error('nama_supir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="km_harian_keluar">KM Keluar</label>
                                    <input type="number"
                                        class="form-control @error('km_harian_keluar') is-invalid @enderror "
                                        name="km_harian_keluar" id="km_harian_keluar" min="0">
                                    @error('km_harian')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="km_harian_kembali">KM Kembali</label>
                                    <input type="number"
                                        class="form-control @error('km_harian_kembali') is-invalid @enderror "
                                        name="km_harian_kembali" id="km_harian_kembali" min="0">
                                    @error('km_harian_kembali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="jam_keluar">Jam Keluar</label>
                                    <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror "
                                        name="jam_keluar" id="jam_keluar">
                                    @error('jam_keluar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="jam_kembali">Jam kembali</label>
                                    <input type="time"
                                        class="form-control @error('jam_kembali') is-invalid @enderror "
                                        name="jam_kembali" id="jam_kembali">
                                    @error('jam_kembali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-0">
                                <div class="mb-3">
                                    <label for="hari">Hari</label>
                                    <input type="date" class="form-control @error('hari') is-invalid @enderror "
                                        name="hari" id="hari">
                                    @error('hari')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                </form>
            </div>
        </div>

        <div class="modal-footer bg-blue-custom">
            <button type="submit" id="add" class="btn btn-light">Simpan</button>
            <button type="button" id="batal" class="btn btn-light">Batal</button>
        </div>
    </div>


    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#servis_table').DataTable();
            });
        </script>
    @endpush


    {{-- </div>
    </div> --}}


    <script type="module">
        // const myModal = new bootstrap.Modal('#modal_tambah', {
        //     keyboard: true
        // })
        // window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_servis_kendaraan')) {
                var id = event.target.dataset.id;
                var kendaraanId = event.target.dataset.kendaraan_id;
                var Supir = event.target.dataset.nama_supir;
                var Hari = event.target.dataset.hari;
                var Jamkeluar = event.target.dataset.jam_keluar;
                var Jamkembali = event.target.dataset.jam_kembali;
                var Kmkeluar = event.target.dataset.km_keluar;
                var Kmkembali = event.target.dataset.km_kembali;


                var editservisForm = document.getElementById('edit_servis_form');
                var editkendaraanId = document.getElementById('edit_kode_item');
                var editSupir = document.getElementById('edit_nama_supir');
                var editHari = document.getElementById('edit_hari');
                var editJamkeluar = document.getElementById('edit_jam_keluar');
                var editJamkembali = document.getElementById('edit_jam_kembali');
                var editKmkeluar = document.getElementById('edit_km_keluar');
                var editKmkembali = document.getElementById('edit_km_kembali');



                editkendaraanId.value = kendaraanId;
                editSupir.value = Supir;
                editHari.value = Hari;
                editJamkeluar.value = Jamkeluar;
                editJamkembali.value = Jamkembali;
                editKmkeluar.value = Kmkeluar;
                editKmkembali.value = Kmkembali;


                editservisForm.action = '/pemakaian/edit/' + id;
                console.log(editservisForm.action);
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
                        document.getElementById('add_pemakaian').submit();

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
            $(document).on('click', '.delete_servis', function(e) {
                e.preventDefault();
                const form = $(this).closest('.hapus_servis');

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
