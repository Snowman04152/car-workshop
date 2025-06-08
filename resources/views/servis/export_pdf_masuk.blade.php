<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        body {
            font-size: 11px;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>

    <title>Laporan Servis</title>
</head>

<body>
    <h1>Laporan Servis</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Nomor</th>
                <th>Nama Kendaraan</th>
                <th>Tanggal Masuk</th>
                <th>Usia Mesin</th>
                <th>Kondisi Kendaraan</th>
                <th>Jenis Pemeliharaan</th>
                <th>Jam Operasi /Bulan</th>
                <th>Frekuensi Harian (KM)</th>
                <th>Interval Kendaraan</th>
                <th>Bulan Terakhir Servis</th>
                <th>Servis Selanjutnya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan_masuk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->plat_nomor }}</td>
                    <td>{{ $item->nama_kendaraan }}</td>
                    <td>{{ toIndoDate($item->tanggal_masuk) }}</td>
                    <td>{{ $item->usia_mesin }} Tahun</td>
                    <td>{{ $item->riwayat_masalah == 0 ? 'Tidak ada Masalah' : 'Mesin Lanjut Usia' }}</td>
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
                            $decoded = array_map(fn($x) => $jenis_pemeliharaan_encoder[$x] ?? null, $pemeliharaan);
                        @endphp
                        {{ implode(', ', array_filter($decoded)) }}
                    </td>
                    <td>{{ $item->jam_operasi_perbulan ?? 'Kosong' }}</td>
                    <td>{{ $item->frekuensi_km_harian ?? 'Kosong' }}</td>
                    <td>{{ $item->interval_km }}</td>
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
                        {{ $bulan_encoder[$item->bulan_terakhir_servis] ?? '-' }} {{ $item->tahun_terakhir_servis }}
                    </td>
                    <td>
                        @php
                            $output = 'Belum Bisa Prediksi';
                            if ($item->bulan_prediksi != 0) {
                                $bulan_sekarang = date('n'); // bulan sekarang, 1 - 12
                                $selisih = $item->bulan_prediksi - $bulan_sekarang;
                                if ($selisih < 0) {
                                    $selisih += 12; // agar hasilnya positif dan melingkar ke tahun berikutnya
                                }
                                $output = $selisih . ' bulan lagi';
                            }
                        @endphp
                        {{ $output }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
