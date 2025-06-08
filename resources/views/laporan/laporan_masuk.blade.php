@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Laporan Servis
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Laporan Servis</div>
                    {{-- <div class="col  d-flex justify-content-end ">
                        <div class="btn btn-primary">
                            Tambah Data <i class="bi bi-plus-circle"></i></div>
                    </div> --}}

                </div>
                <div class="my-2 row d-flex justify-content-between">
                    <div class="col  fs-5 align-items-center">
                        <form>
                            <div>
                                <div class="d-flex gap-2 justify-content-start">
                                    <a class="btn btn-primary col-1 rounded-0"
                                        href="{{ route('laporanmasuk.exportExcel') }}">
                                        Excel
                                    </a>
                                    <a class="btn btn-outline-primary col-1 rounded-0"
                                        href="{{ route('laporanmasuk.exportPdf') }}">
                                        Pdf
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered " id="laporanmasuk_table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto">Plat Nomor</th>
                                <th scope="col" class="col-auto">Nama Kendaraan</th>
                                <th scope="col" class="col-auto">Tanggal Masuk</th>
                                <th scope="col" class="text-center col-auto">Usia Mesin</th>
                                <th scope="col" class="text-center col-auto">Kondisi Kendaraan</th>
                                <th scope="col" class="text-center col-auto">Jenis Pemeliharaan</th>
                                <th scope="col" class="text-center col-auto">Jam Operasi Perbulan</th>
                                <th scope="col" class="text-center col-auto">Frekuensi Harian(KM)</th>
                                <th scope="col" class="text-center col-auto">Interval Kendaraan</th>
                                <th scope="col" class="col-auto text-center">Bulan Terakhir Servis</th>
                                <th scope="col" class="col-auto text-center">Servis Selanjutnya</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($laporan_masuk as $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    <td class="text-center">{{ $item->plat_nomor }}</td>
                                    <td>{{ $item->nama_kendaraan }}</td>
                                    <td>{{ toIndoDate($item->tanggal_masuk) }}</td>
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
                                    @if ($item->jam_operasi_perbulan == null)
                                        <td class="text-center">Kosong</td>
                                    @else
                                        <td class="text-center">{{ $item->jam_operasi_perbulan }}</td>
                                    @endif
                                    @if ($item->frekuensi_km_harian == null)
                                        <td class="text-center">Kosong</td>
                                    @else
                                        <td class="text-center">{{ $item->frekuensi_km_harian }}</td>
                                    @endif
                                    <td class="text-center">{{ $item->interval_km }}</td>
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
                                        {{ $bulan_encoder[$item->bulan_terakhir_servis] ?? '-' }}
                                        {{ $item->tahun_terakhir_servis }}
                                    </td>
                                    <td>
                                        @php
                                            $output = 'Belum Bisa Prediksi';
                                            if ($item->bulan_prediksi != 0) {
                                                $selisih_bulan = $item->bulan_prediksi - $item->bulan_terakhir_servis;
                                                if ($selisih_bulan < 0) {
                                                    $selisih_bulan += 12;
                                                }
                                                $output = $selisih_bulan . ' bulan lagi';
                                            }
                                        @endphp
                                        {{ $output }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#laporanmasuk_table').DataTable();
            });
        </script>
    @endpush
@endsection
