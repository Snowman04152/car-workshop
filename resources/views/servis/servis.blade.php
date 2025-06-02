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
                    {{-- <div class="col  d-flex justify-content-end ">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah">
                            Tambah Data <i class="bi bi-plus-circle"></i></button>
                    </div> --}}
                </div>
                <div class="">
                    <table class="table table-bordered" id="servis_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center col-auto">No</th>
                                <th scope="col" class="text-center col-auto">Plat Nomor</th>
                                <th scope="col" class="text-center col-auto">Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Usia Mesin</th>
                                <th scope="col" class="text-center col-auto">Kondisi Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Jenis Pemeliharaan</th>
                                <th scope="col" class="text-center col-auto">Jam Operasi Perbulan</th>
                                <th scope="col" class="text-center col-auto">Frekuensi Harian(KM)</th>
                                <th scope="col" class="text-center col-auto">Interval Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Terakhir Servis</th>
                                <th scope="col" class="text-center col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($kendaraan as $kendaraans)
                                <tr class="">
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td class="text-center">{{ $kendaraans->plat_nomor }}</td>
                                    <td>{{ $kendaraans->nama_kendaraan }}</td>
                                    <td class="text-center">{{ $kendaraans->usia_mesin }} Tahun</td>
                                    @if ($kendaraans->riwayat_masalah == 0)
                                        <td>Tidak ada Masalah</td>
                                    @else
                                        <td>Mesin Lanjut Usia</td>
                                    @endif
                                    <td>
                                        @php
                                            $jenis_pemeliharaan_encoder = [
                                                1 => 'Ganti Bumper Belakang',
                                                2 => 'Ganti Bumper Depan',
                                                3 => 'Ganti Kampas Rem',
                                                4 => 'Ganti Lampu Depan',
                                                5 => 'Ganti Minyak Rem',
                                                6 => 'Ganti Oli',
                                                7 => 'Pemeriksaan Filter Udara',
                                                8 => 'Pemeriksaan Kampas Rem',
                                                9 => 'Pemeriksaan Kelistrikan',
                                                10 => 'Pemeriksaan Minyak Rem',
                                                11 => 'Pemeriksaan Rem',
                                                12 => 'Pemeriksaan Suspensi',
                                                13 => 'Pemeriksaan Sistem Pendingin',
                                                14 => 'Pemeriksaan Sistem Pengapian',
                                                15 => 'Pemeriksaan Transmisi',
                                                16 => 'Perbaikan Bumper Depan',
                                                17 => 'Pergantian Busi',
                                                18 => 'Pergantian Kampas Rem',
                                                19 => 'Pergantian Oli',
                                                20 => 'Rotasi Ban',
                                                21 => 'Service Berkala',
                                                22 => 'Service Kopling',
                                                23 => 'Tune Up',
                                                24 => 'Charging Accu',
                                            ];

                                            $pemeliharaan = array_filter([
                                                $kendaraans->jenis_pemeliharaan_1,
                                                $kendaraans->jenis_pemeliharaan_2,
                                                $kendaraans->jenis_pemeliharaan_3,
                                            ]);

                                            $decoded_pemeliharaan = array_map(function ($jenis) use (
                                                $jenis_pemeliharaan_encoder,
                                            ) {
                                                return $jenis_pemeliharaan_encoder[$jenis] ?? null;
                                            }, $pemeliharaan);
                                        @endphp
                                        {{ implode(', ', array_filter($decoded_pemeliharaan)) }}
                                    </td>
                                    @if ($kendaraans->jam_operasi_perbulan == null)
                                        <td class="text-center">Kosong</td>
                                    @else
                                        <td class="text-center">{{ $kendaraans->jam_operasi_perbulan }}</td>
                                    @endif
                                    @if ($kendaraans->frekuensi_km_harian == null)
                                        <td class="text-center">Kosong</td>
                                    @else
                                    <td class="text-center">{{ $kendaraans->frekuensi_km_harian }}</td>
                                    @endif
                                    <td class="text-center">{{ $kendaraans->interval_km }}</td>
                                    <td>
                                        @php
                                            $bulan_encoder = [
                                                1 => 'Januari',
                                                2 => 'Februari',
                                                3 => 'Maret',
                                                4 => 'April',
                                                5 => 'Mei',
                                                6 => 'Juni',
                                                7 => 'Juli',
                                                8 => 'Agustus',
                                                9 => 'September',
                                                10 => 'Oktober',
                                                11 => 'November',
                                                12 => 'Desember',
                                            ];
                                        @endphp
                                        {{ $bulan_encoder[$kendaraans->bulan_terakhir_servis] ?? '-' }}
                                        {{ $kendaraans->tahun_terakhir_servis }}
                                    </td>

                                    <td><button class="btn btn-sm edit_servis_kendaraan"
                                            data-kendaraan_id='{{ $kendaraans->id }}'
                                            data-tanggal_masuk='{{ $kendaraans->tanggal_masuk }}'
                                            data-riwayat_masalah='{{ $kendaraans->riwayat_masalah }}'
                                            data-jenis_pemeliharaan_1='{{ $kendaraans->jenis_pemeliharaan_1 }}'
                                            data-jenis_pemeliharaan_2='{{ $kendaraans->jenis_pemeliharaan_2 }}'
                                            data-jenis_pemeliharaan_3='{{ $kendaraans->jenis_pemeliharaan_3 }}'
                                            data-frekuensi_km_harian='{{ $kendaraans->frekuensi_km_harian }}'
                                            data-bulan_terakhir_servis='{{ $kendaraans->bulan_terakhir_servis }}'
                                            data-tahun_terakhir_servis='{{ $kendaraans->tahun_terakhir_servis }}'
                                            data-interval_km='{{ $kendaraans->interval_km }}'
                                            data-jam_operasi_perbulan='{{ $kendaraans->jam_operasi_perbulan }}'
                                            data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                class="bi bi-pencil-square "style="pointer-events: none;"></i></button>

                                        <form class="hapus_servis" method="POST" style="display: inline;"
                                            action="{{ route('servis.hapus', ['id' => $kendaraans->id]) }}"
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
                <form id="edit_servis_form" method="POST" action="">
                    @method('put')
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
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
                                    <select class="form-select @error('interval_km') is-invalid @enderror" id="interval_km"
                                        name="interval_km">
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
                                    <select class="form-select @error('frekuensi_km_harian') is-invalid @enderror"
                                        id="frekuensi_km_harian" name="frekuensi_km_harian">
                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        <option value="50">50 Km/hari</option>
                                        <option value="80">80 Km/hari</option>
                                        <option value="100">100 Km/hari</option>
                                    </select>
                                    @error('interval_km')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jam_operasi">Jam Operasi Perbulan</label>
                                    <input type="number" name="jam_operasi"
                                        class="form-control @error('jam_operasi') is-invalid @enderror" id="jam_operasi"
                                        min="0">
                                    @error('jam_operasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                            id="tahun_terakhir_servis" min="2020" value="2020"
                                            name="tahun_terakhir_servis">
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
                                    <select class="form-select " id="jenis_pemeliharaan_2" name="jenis_pemeliharaan_2">
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
                                    <select class="form-select " id="jenis_pemeliharaan_3" name="jenis_pemeliharaan_3">
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

    {{-- <div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis </h1>

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
            </div>
        </div> --}}

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
        // const myModal = new bootstrap.Modal('#modal_edit', {
        //     keyboard: true
        // })
        // window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_servis_kendaraan')) {
                var kendaraanId = event.target.dataset.kendaraan_id;
                var usiaMesin = event.target.dataset.tanggal_masuk;
                var riwayatMasalah = event.target.dataset.riwayat_masalah;
                var jenisPemeliharaan1 = event.target.dataset.jenis_pemeliharaan_1;
                var jenisPemeliharaan2 = event.target.dataset.jenis_pemeliharaan_2;
                var jenisPemeliharaan3 = event.target.dataset.jenis_pemeliharaan_3;
                var jamOperasi = event.target.dataset.jam_operasi_perbulan;
                var frekuensiKm = event.target.dataset.frekuensi_km_harian;
                var intervalKm = event.target.dataset.interval_km;
                var bulanTerakhirServis = event.target.dataset.bulan_terakhir_servis;
                var tahunTerakhirServis = event.target.dataset.tahun_terakhir_servis;

                var editservisForm = document.getElementById('edit_servis_form');
                var editusiaMesin = document.getElementById('tanggal_masuk');
                var editriwayatMasalah = document.getElementById('riwayat_masalah');
                var editjenisPemeliharaan1 = document.getElementById('jenis_pemeliharaan_1');
                var editjenisPemeliharaan2 = document.getElementById('jenis_pemeliharaan_2');
                var editjenisPemeliharaan3 = document.getElementById('jenis_pemeliharaan_3');
                var editjamOperasi = document.getElementById('jam_operasi');
                var editfrekuensiKm = document.getElementById('frekuensi_km_harian');
                var editbulanTerakhirServis = document.getElementById('bulan_terakhir_servis');
                var edittahunTerakhirServis = document.getElementById('tahun_terakhir_servis');
                var editintervalKm = document.getElementById('interval_km');


                editusiaMesin.value = usiaMesin;
                editriwayatMasalah.value = riwayatMasalah;
                editjenisPemeliharaan1.value = jenisPemeliharaan1;
                editjenisPemeliharaan2.value = jenisPemeliharaan2;
                editjenisPemeliharaan3.value = jenisPemeliharaan3;
                editjamOperasi.value = jamOperasi;
                editfrekuensiKm.value = frekuensiKm;
                editintervalKm.value = intervalKm;
                editbulanTerakhirServis.value = bulanTerakhirServis;
                edittahunTerakhirServis.value = tahunTerakhirServis;

                editservisForm.action = '/servis/edit/' + kendaraanId;

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
