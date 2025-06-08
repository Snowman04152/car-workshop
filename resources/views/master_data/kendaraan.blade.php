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
                    <div class="col d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
                    </div>
                </div>

                <div class="">
                    <table class="table table-bordered " id="kendaraan_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center col-0">No</th>
                                <th scope="col" class="text-center col-3">Gambar</th>
                                <th scope="col" class="text-center col-auto">Plat Nomor</th>
                                <th scope="col" class="text-center col-auto">Nama Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Jenis</th>
                                <th scope="col" class="text-center col-auto">Merk</th>
                                <th scope="col" class="text-center col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraan as $kendaraans)
                                <tr class="text-center">
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td><img class="w-25"
                                            src="{{ asset('storage/files/' . $kendaraans->encrypted_filename) }}"
                                            alt=""></td>
                                    <td>{{ $kendaraans->plat_nomor }}</td>
                                    <td>{{ $kendaraans->nama_kendaraan }}</td>
                                    <td>{{ $kendaraans->jenis }}</td>
                                    <td>{{ $kendaraans->merk }}</td>
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm edit_kendaraan"
                                                    data-kendaraan_id="{{ $kendaraans->id }}"
                                                    data-plat_nomor="{{ $kendaraans->plat_nomor }}"
                                                    data-nama_kendaraan="{{ $kendaraans->nama_kendaraan }}"
                                                    data-jenis_kendaraan="{{ $kendaraans->jenis }}"
                                                    data-merk_kendaraan="{{ $kendaraans->merk }}" data-bs-toggle="modal"
                                                    data-bs-target="#modal_edit"><i class="bi bi-pencil-square"
                                                        style="pointer-events: none;"></i></button>

                                                <form method="POST"
                                                    action="{{ route('kendaraan.hapus', ['id' => $kendaraans->id]) }}"
                                                    class="d-inline hapus_kendaraan" style="display: inline;">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-sm delete_kendaraan"
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
    <div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Kendaraan Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row gap-5 p-2">
                        <form id="add_kendaraan" action="{{ route('kendaraan.add') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="plat_nomor">Plat Nomor</label>
                                            <input type="text" name="plat_nomor" id="plat_nomor"
                                                class="form-control @error('plat_nomor') is-invalid @enderror"
                                                id="plat_nomor">
                                            @error('plat_nomor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nama_kendaraan">Nama Kendaraan</label>
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
                                            <label for="jenis">Jenis</label>
                                            <input type="text" class="form-control  @error('jenis') is-invalid @enderror"
                                                id="jenis" name="jenis">
                                            @error('jenis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="merk">Merk</label>
                                            <input type="text"
                                                class="form-control  @error('merk') is-invalid @enderror" id="merk"
                                                name="merk">
                                            @error('merk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="riwayat_masalah">Riwayat Masalah</label>
                                            <select class="form-select @error('riwayat_masalah') is-invalid @enderror"
                                                id="riwayat_masalah" name="riwayat_masalah">
                                                <option disabled selected class="text-center">--- Pilih ---</option>
                                                <option value="0">Tidak ada masalah</option>
                                                <option value="1">Masalah Mesin Usia Lanjut</option>
                                            </select>
                                            @error('riwayat_masalah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="interval_km">Interval Pemeliharaan</label>
                                        <select class="form-select @error('interval_km') is-invalid @enderror"
                                            id="interval_km" name="interval_km">
                                            <option disabled selected class="text-center">--- Pilih ---</option>
                                            <option value="10000">10000 KM</option>
                                            <option value="12000">12000 KM</option>
                                        </select>
                                        @error('interval_km')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="frekuensi_km_harian">Frekuensi Harian (KM)</label>
                                        <input type="number" class="form-control @error('frekuensi_km_harian') is-invalid @enderror"
                                            id="frekuensi_km_harian" name="frekuensi_km_harian" >
                                        @error('interval_km')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="bulan_terakhir_servis">Bulan Terakhir Servis</label>
                                        <select class="form-select @error('bulan_terakhir_servis') is-invalid @enderror"
                                            name="bulan_terakhir_servis" id="bulan_terakhir_servis">
                                            <option disabled selected class="text-center">--- Pilih ---</option>
                                            @foreach (range(1, 12) as $bulan)
                                                <option value="{{ $bulan }}">
                                                    {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bulan_terakhir_servis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_terakhir_servis">Tahun Terakhir Servis</label>
                                        <div class="input-group">
                                            <input type="number"
                                                class="form-control @error('tahun_terakhir_servis') is-invalid @enderror"
                                                id="tahun_terakhir_servis" min="2020" value="2020" name="tahun_terakhir_servis">
                                            @error('tahun_terakhir_servis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_pemeliharaan_1">Jenis Pemeliharaan 1</label>
                                        <select class="form-select @error('jenis_pemeliharaan_1') is-invalid @enderror"
                                            id="jenis_pemeliharaan_1" name="jenis_pemeliharaan_1">
                                            <option selected value="0">Tidak ada</option>
                                            <option value="1">Ganti Bumper Belakang</option>
                                            <option value="2">Ganti Bumper Depan</option>
                                            <option value="3">Ganti Kampas Rem</option>
                                            <option value="4">Ganti Lampu Depan</option>
                                            <option value="5">Ganti Minyak Rem</option>
                                            <option value="6">Ganti Oli</option>
                                            <option value="7">Pemeriksaan Filter Udara</option>
                                            <option value="8">Pemeriksaan Kampas Rem</option>
                                            <option value="9">Pemeriksaan Kelistrikan</option>
                                            <option value="10">Pemeriksaan Minyak Rem</option>
                                            <option value="11">Pemeriksaan Rem</option>
                                            <option value="12">Pemeriksaan Suspensi</option>
                                            <option value="13">Pemeriksaan Sistem Pendingin</option>
                                            <option value="14">Pemeriksaan Sistem Pengapian</option>
                                            <option value="15">Pemeriksaan Transmisi</option>
                                            <option value="16">Perbaikan Bumper Depan</option>
                                            <option value="17">Pergantian Busi</option>
                                            <option value="18">Pergantian Kampas Rem</option>
                                            <option value="19">Pergantian Oli</option>
                                            <option value="20">Rotasi Ban</option>
                                            <option value="21">Service Berkala</option>
                                            <option value="22">Service Kopling</option>
                                            <option value="23">Tune Up</option>
                                            <option value="24">Charging Accu</option>
                                        </select>
                                        @error('jenis_pemeliharaan_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_pemeliharaan_2">Jenis Pemeliharaan 2</label>
                                        <select class="form-select " id="jenis_pemeliharaan_2"
                                            name="jenis_pemeliharaan_2">
                                            <option selected value="0">Tidak ada</option>
                                            <option value="1">Ganti Bumper Belakang</option>
                                            <option value="2">Ganti Bumper Depan</option>
                                            <option value="3">Ganti Kampas Rem</option>
                                            <option value="4">Ganti Lampu Depan</option>
                                            <option value="5">Ganti Minyak Rem</option>
                                            <option value="6">Ganti Oli</option>
                                            <option value="7">Pemeriksaan Filter Udara</option>
                                            <option value="8">Pemeriksaan Kampas Rem</option>
                                            <option value="9">Pemeriksaan Kelistrikan</option>
                                            <option value="10">Pemeriksaan Minyak Rem</option>
                                            <option value="11">Pemeriksaan Rem</option>
                                            <option value="12">Pemeriksaan Suspensi</option>
                                            <option value="13">Pemeriksaan Sistem Pendingin</option>
                                            <option value="14">Pemeriksaan Sistem Pengapian</option>
                                            <option value="15">Pemeriksaan Transmisi</option>
                                            <option value="16">Perbaikan Bumper Depan</option>
                                            <option value="17">Pergantian Busi</option>
                                            <option value="18">Pergantian Kampas Rem</option>
                                            <option value="19">Pergantian Oli</option>
                                            <option value="20">Rotasi Ban</option>
                                            <option value="21">Service Berkala</option>
                                            <option value="22">Service Kopling</option>
                                            <option value="23">Tune Up</option>
                                            <option value="24">Charging Accu</option>
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_pemeliharaan_3">Jenis Pemeliharaan 3</label>
                                        <select class="form-select " id="jenis_pemeliharaan_3"
                                            name="jenis_pemeliharaan_3">
                                            <option selected value="0">Tidak ada</option>
                                            <option value="1">Ganti Bumper Belakang</option>
                                            <option value="2">Ganti Bumper Depan</option>
                                            <option value="3">Ganti Kampas Rem</option>
                                            <option value="4">Ganti Lampu Depan</option>
                                            <option value="5">Ganti Minyak Rem</option>
                                            <option value="6">Ganti Oli</option>
                                            <option value="7">Pemeriksaan Filter Udara</option>
                                            <option value="8">Pemeriksaan Kampas Rem</option>
                                            <option value="9">Pemeriksaan Kelistrikan</option>
                                            <option value="10">Pemeriksaan Minyak Rem</option>
                                            <option value="11">Pemeriksaan Rem</option>
                                            <option value="12">Pemeriksaan Suspensi</option>
                                            <option value="13">Pemeriksaan Sistem Pendingin</option>
                                            <option value="14">Pemeriksaan Sistem Pengapian</option>
                                            <option value="15">Pemeriksaan Transmisi</option>
                                            <option value="16">Perbaikan Bumper Depan</option>
                                            <option value="17">Pergantian Busi</option>
                                            <option value="18">Pergantian Kampas Rem</option>
                                            <option value="19">Pergantian Oli</option>
                                            <option value="20">Rotasi Ban</option>
                                            <option value="21">Service Berkala</option>
                                            <option value="22">Service Kopling</option>
                                            <option value="23">Tune Up</option>
                                            <option value="24">Charging Accu</option>
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_masuk">Tahun Registrasi Mobil</label>
                                        <div class="input-group">
                                            <input type="number"
                                                class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                                id="tanggal_masuk" min="2000" value="2000" name="tanggal_masuk">
                                            @error('tanggal_masuk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_operasi">Jam Operasi Perbulan</label>
                                        <input type="number" name="jam_operasi"
                                            class="form-control @error('jam_operasi') is-invalid @enderror"
                                            id="jam_operasi" min="0">
                                        @error('jam_operasi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    

                                </div>
                                <div class="mb-3">
                                    <div>Foto</div>
                                    <input type="file" class="form-control" id="gambar" name="gambar"
                                        aria-label="Upload">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="submit" class="btn btn-light" id="add">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal">Batal</button>
                </div>
            </div>
            </form>
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
                                        <label for="plat_nomor">Plat Nomor</label>
                                        <input type="text" name="edit_plat_nomor"
                                            class="form-control @error('edit_plat_nomor') is-invalid @enderror"
                                            id="edit_plat_nomor">
                                        @error('plat_nomor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_kendaraan">Nama Kendaraan</label>
                                        <input type="text"
                                            class="form-control  @error('edit_nama_kendaraan') is-invalid @enderror"
                                            id="edit_nama_kendaraan" name="edit_nama_kendaraan">
                                        @error('nama_kendaraan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jenis">Jenis</label>
                                        <input type="text"
                                            class="form-control  @error('edit_jenis') is-invalid @enderror"
                                            id="edit_jenis" name="edit_jenis">
                                        @error('edit_jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="merk">Merk</label>
                                        <input type="text"
                                            class="form-control  @error('edit_merk') is-invalid @enderror" id="edit_merk"
                                            name="edit_merk">
                                        @error('edit_merk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto ">
                                <div class="mb-3">Foto</div>

                                <input type="file"
                                    class="form-control mt-3 w-75  @error('gambar') is-invalid @enderror"
                                    id="edit_gambar" name="gambar" aria-label="Upload">
                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" id="edit_button">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal_edit">Batal</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#kendaraan_table').DataTable();
            });
        </script>
    @endpush

    <script type="module">
        // const myModal = new bootstrap.Modal('#modal_tambah', {
        //     keyboard: true
        // })
        // window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_kendaraan')) {
                var kendaraanId = event.target.dataset.kendaraan_id;
                var namaKendaraan = event.target.dataset.nama_kendaraan;
                var jenisKendaraan = event.target.dataset.jenis_kendaraan;
                var merkKendaraan = event.target.dataset.merk_kendaraan;
                var plat_nomor = event.target.dataset.plat_nomor;

                // console.log(jumlah);

                var editkendaraanForm = document.getElementById('edit_kendaraan_form');
                var editIdInput = document.getElementById('edit_id_kendaraan');
                var editNamakendaraanInput = document.getElementById('edit_nama_kendaraan');
                var editJeniskendaraanInput = document.getElementById('edit_jenis');
                var editMerkkendaraanInput = document.getElementById('edit_merk');
                var editPlatnomorInput = document.getElementById('edit_plat_nomor');
                // var editGambarInput = document.getElementById('edit_gambar');

                editIdInput.value = kendaraanId;
                editNamakendaraanInput.value = namaKendaraan;
                editJeniskendaraanInput.value = jenisKendaraan;
                editMerkkendaraanInput.value = merkKendaraan;
                editPlatnomorInput.value = plat_nomor;

                editkendaraanForm.action = '/kendaraan/edit/' + kendaraanId;

            }
        });

        $(document).ready(function() {
            $(document).on('click', '.delete_kendaraan', function(e) {
                e.preventDefault();
                const form = $(this).closest('.hapus_kendaraan');

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
            $(document).on('click', '.delete_kendaraan', function(e) {
                e.preventDefault();
                const form = $(this).closest('.hapus_kendaraan');

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
