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

                <div class="">
                    <table class="table table-bordered text-center" id="prediksi_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Kendaraan</th>
                                <th scope="col" class="col-auto">Bulan Terakhir Servis</th>
                                <th scope="col" class="col-auto">Usia Mesin</th>
                                <th scope="col" class="col-auto">Riwayat Permasalahan</th>
                                <th scope="col" class="col-auto">Jenis Pemeliharaan</th>
                                <th scope="col" class="col-auto">Frekuensi Harian (KM)</th>
                                <th scope="col" class="col-auto">Interval Pemeliharaan</th>
                                <th scope="col" class="col-auto">Jam Operasi Perbulan</th>
                                <th scope="col" class="col-auto">Servis Selanjutnya</th>
                                <th scope="col" class="col-auto">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeliharaan as $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ $item->servis->kendaraan->plat_nomor }}</td>
                                    <td>{{ optional($item->servis->kendaraan)->nama_kendaraan }}</td>
                                
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
                                        {{ $bulan_encoder[$item->servis_terakhir_bulan] ?? '-' }}
                                    </td>

                                    <td>{{ $item->usia_mesin }} Tahun</td>
                                    @if ($item->riwayat_masalah == 0)
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
                                                $item->jenis_pemeliharaan_1,
                                                $item->jenis_pemeliharaan_2,
                                                $item->jenis_pemeliharaan_3,
                                            ]);

                                            $decoded_pemeliharaan = array_map(function ($jenis) use (
                                                $jenis_pemeliharaan_encoder,
                                            ) {
                                                return $jenis_pemeliharaan_encoder[$jenis] ?? null;
                                            }, $pemeliharaan);
                                        @endphp
                                        {{ implode(', ', array_filter($decoded_pemeliharaan)) }}
                                    </td>
                                    <td>{{ $item->frekuensi_km_harian }}</td>
                                    <td>{{ $item->interval_km }}</td>
                                    <td>{{ $item->jam_operasi_bulanan }}</td>
                                    <td>
                                        @php
                                            $selisih_bulan = $item->bulan_prediksi - $item->servis_terakhir_bulan;
                                            if ($selisih_bulan < 0) {
                                                $selisih_bulan += 12;
                                            }
                                        @endphp
                                        {{ $selisih_bulan }} bulan lagi
                                    </td>
                                    <td>
                                        <div class="row d-flex gap-0 justify-content-center">
                                            <div class="col-auto ">
                                                <button class="btn btn-sm edit_pemeliharaan"
                                                    data-pemeliharaan_id="{{ $item->id }}"
                                                    data-servis_id="{{ $item->servis_id }}"
                                                    data-usia_mesin="{{ $item->usia_mesin }}"
                                                    data-riwayat_masalah="{{ $item->riwayat_masalah }}"
                                                    data-jenis_pemeliharaan_1='{{ $item->jenis_pemeliharaan_1 }}'
                                                    data-jenis_pemeliharaan_2='{{ $item->jenis_pemeliharaan_2 }}'
                                                    data-jenis_pemeliharaan_3='{{ $item->jenis_pemeliharaan_3 }}'data-frekuensi_km_harian='{{ $item->frekuensi_km_harian }}'
                                                    data-interval_km ='{{ $item->interval_km }}'
                                                    data-jam_operasi_bulanan='{{ $item->jam_operasi_bulanan }}'
                                                    data-bulan_terakhir_servis="{{ $item->servis_terakhir_bulan }}"
                                                    data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                        style="pointer-events: none;"
                                                        class="bi bi-pencil-square "></i></button>
                                                <form id="hapus_kendaraan" method="POST"
                                                    action="{{ route('pemeliharaan.hapus', ['id' => $item->id]) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-sm" id="delete_kendaraan"
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-6">
                            <div class="mb-3">
                                <form id="add_pemeliharaan" action="{{ route('pemeliharaan.store') }}" method="POST">
                                    @csrf
                                    <label for="kode_item">Kode Item*</label>
                                    <select class="form-select @error('kode_item') is-invalid @enderror" name="kode_item"
                                        id="kode_item">
                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        @foreach ($servis as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kendaraans') == $item->id ? 'selected' : '' }}
                                                class="text-center">
                                                {{ $item->id }} - {{ $item->kendaraan->nama_kendaraan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kode_item')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
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
                                <select class="form-select @error('jenis_pemeliharaan_2') is-invalid @enderror"
                                    id="jenis_pemeliharaan_2" name="jenis_pemeliharaan_2">
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
                                @error('jenis_pemeliharaan_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jenis_pemeliharaan_3">Jenis Pemeliharaan 3</label>
                                <select class="form-select @error('jenis_pemeliharaan_3') is-invalid @enderror"
                                    id="jenis_pemeliharaan_3" name="jenis_pemeliharaan_3">
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
                                @error('jenis_pemeliharaan_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Kolom Kanan -->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="usia_mesin">Usia Mesin (Tahun)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('usia_mesin') is-invalid @enderror"
                                        id="usia_mesin" min="1" value="1" name="usia_mesin">
                                    @error('usia_mesin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
                                <label for="frekuensi_harian">Frekuensi Pemakaian Harian</label>
                                <select class="form-select @error('frekuensi_harian') is-invalid @enderror"
                                    id="frekuensi_harian" name="frekuensi_harian">
                                    <option disabled selected class="text-center">--- Pilih ---</option>
                                    <option value="50">50 Km/hari</option>
                                    <option value="80">80 Km/hari</option>
                                    <option value="100">100 Km/hari</option>
                                </select>
                                @error('frekuensi_harian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-custom">
                    <h1 class="modal-title fs-5 fw-bold text-white" id="exampleModalLabel">Data Servis Masuk</h1>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-6">
                            <div class="mb-3">
                                <form id="edit_pemeliharaan_form" method="POST">
                                    @method('put')
                                    @csrf
                                    <input type="text" name="edit_id_pemeliharaan" hidden id="edit_id_pemeliharaan">
                                    <label for="kode_item">Kode Item*</label>
                                    <select class="form-select @error('kode_item') is-invalid @enderror" name="kode_item"
                                        id="edit_kode_item">
                                        <option disabled selected class="text-center">--- Pilih ---</option>
                                        @foreach ($servis as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kendaraans') == $item->id ? 'selected' : '' }}
                                                class="text-center">
                                                {{ $item->id }} - {{ $item->kendaraan->nama_kendaraan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kode_item')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bulan_terakhir_servis">Bulan Terakhir Servis</label>
                                <select class="form-select @error('bulan_terakhir_servis') is-invalid @enderror"
                                    name="bulan_terakhir_servis" id="edit_bulan_terakhir_servis">
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
                                <label for="jenis_pemeliharaan_1">Jenis Pemeliharaan 1</label>
                                <select class="form-select @error('jenis_pemeliharaan_1') is-invalid @enderror"
                                    id="edit_jenis_pemeliharaan_1" name="jenis_pemeliharaan_1">
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
                                <select class="form-select @error('jenis_pemeliharaan_2') is-invalid @enderror"
                                    id="edit_jenis_pemeliharaan_2" name="jenis_pemeliharaan_2">
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
                                @error('jenis_pemeliharaan_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jenis_pemeliharaan_3">Jenis Pemeliharaan 3</label>
                                <select class="form-select @error('jenis_pemeliharaan_3') is-invalid @enderror"
                                    id="edit_jenis_pemeliharaan_3" name="jenis_pemeliharaan_3">
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
                                @error('jenis_pemeliharaan_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Kolom Kanan -->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="usia_mesin">Usia Mesin (Tahun)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('usia_mesin') is-invalid @enderror"
                                        id="edit_usia_mesin" min="1" value="1" name="usia_mesin">
                                    @error('usia_mesin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jam_operasi">Jam Operasi Perbulan</label>
                                <input type="number" name="jam_operasi"
                                    class="form-control @error('jam_operasi') is-invalid @enderror" id="edit_jam_operasi"
                                    min="0">
                                @error('jam_operasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="riwayat_masalah">Riwayat Masalah</label>
                                <select class="form-select @error('riwayat_masalah') is-invalid @enderror"
                                    id="edit_riwayat_masalah" name="riwayat_masalah">
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
                            <div class="mb-3">
                                <label for="interval_km">Interval Pemeliharaan</label>
                                <select class="form-select @error('interval_km') is-invalid @enderror"
                                    id="edit_interval_km" name="interval_km">
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
                                <label for="frekuensi_harian">Frekuensi Pemakaian Harian</label>
                                <select class="form-select @error('frekuensi_harian') is-invalid @enderror"
                                    id="edit_frekuensi_harian" name="frekuensi_harian">
                                    <option disabled selected class="text-center">--- Pilih ---</option>
                                    <option value="50">50 Km/hari</option>
                                    <option value="80">80 Km/hari</option>
                                    <option value="100">100 Km/hari</option>
                                </select>
                                @error('frekuensi_harian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-blue-custom">
                    <button type="button" class="btn btn-light" id="edit_button">Simpan</button>
                    <button type="button" class="btn btn-light" id="batal_edit">Batal</button>
                    </form>
                </div>

            </div>
        </div>
        @push('scripts')
            <script type="module">
                $(document).ready(function() {
                    $('#prediksi_table').DataTable();
                });
            </script>
        @endpush
    </div>

    <script type="module">
        // const myModal = new bootstrap.Modal('#modal_tambah', {
        //     keyboard: true
        // })
        // window.onload = myModal.show();

        document.addEventListener('click', function(event) {
            if (event.target.matches('.edit_pemeliharaan')) {
                var pemeliharaanId = event.target.dataset.pemeliharaan_id;
                var servis_id = event.target.dataset.servis_id;
                var usia_mesin = event.target.dataset.usia_mesin;
                var riwayat_masalah = event.target.dataset.riwayat_masalah;
                var jenis_pemeliharaan_1 = event.target.dataset.jenis_pemeliharaan_1;
                var jenis_pemeliharaan_2 = event.target.dataset.jenis_pemeliharaan_2;
                var jenis_pemeliharaan_3 = event.target.dataset.jenis_pemeliharaan_3;
                var frekuensi_km_harian = event.target.dataset.frekuensi_km_harian;
                var interval_km = event.target.dataset.interval_km;
                var jam_operasi_bulanan = event.target.dataset.jam_operasi_bulanan;
                var bulan_terakhir_servis = event.target.dataset.bulan_terakhir_servis;

                var editpemeliharaanForm = document.getElementById('edit_pemeliharaan_form');
                var editIdInput = document.getElementById('edit_id_pemeliharaan');
                var editservis_idInput = document.getElementById('edit_kode_item');
                var editusia_mesinInput = document.getElementById('edit_usia_mesin');
                var editriwayat_masalahInput = document.getElementById('edit_riwayat_masalah');
                var editjenis_pemeliharaan_1Input = document.getElementById('edit_jenis_pemeliharaan_1');
                var editjenis_pemeliharaan_2Input = document.getElementById('edit_jenis_pemeliharaan_2');
                var editjenis_pemeliharaan_3Input = document.getElementById('edit_jenis_pemeliharaan_3');
                var editfrekuensi_km_harianInput = document.getElementById('edit_frekuensi_harian');
                var editinterval_kmInput = document.getElementById('edit_interval_km');
                var editjam_operasi_bulananInput = document.getElementById('edit_jam_operasi');
                var editbulan_terakhir_servisInput = document.getElementById('edit_bulan_terakhir_servis');



                editIdInput.value = pemeliharaanId;
                editservis_idInput.value = servis_id;
                editusia_mesinInput.value = usia_mesin;
                editriwayat_masalahInput.value = riwayat_masalah;
                editjenis_pemeliharaan_1Input.value = jenis_pemeliharaan_1;
                editjenis_pemeliharaan_2Input.value = jenis_pemeliharaan_2;
                editjenis_pemeliharaan_3Input.value = jenis_pemeliharaan_3;
                editfrekuensi_km_harianInput.value = frekuensi_km_harian;
                editinterval_kmInput.value = interval_km;
                editjam_operasi_bulananInput.value = jam_operasi_bulanan;
                editbulan_terakhir_servisInput.value = bulan_terakhir_servis;
                editpemeliharaanForm.action = '/pemeliharaan/edit/' + pemeliharaanId;

            }
        });

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
                        document.getElementById('edit_pemeliharaan_form').submit();
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
                        document.getElementById('add_pemeliharaan').submit();

                    }

                });
            });

        });
    </script>
@endsection
