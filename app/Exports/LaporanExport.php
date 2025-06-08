<?php

namespace App\Exports;

use App\Models\Kendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithMapping, WithHeadings
{
    private $index = 0;
    public function collection()
    {
        return Kendaraan::where('hapus_id', 0)->get();
    }

    public function map($item): array
    {

        $this->index++; // untuk kolom "No"


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
            24 => 'Charging Accu'
        ];

        $pemeliharaan = array_filter([
            $item->jenis_pemeliharaan_1,
            $item->jenis_pemeliharaan_2,
            $item->jenis_pemeliharaan_3,
        ]);

        $decoded_pemeliharaan = array_map(function ($jenis) use ($jenis_pemeliharaan_encoder) {
            return $jenis_pemeliharaan_encoder[$jenis] ?? null;
        }, $pemeliharaan);

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
            12 => 'Desember'
        ];

        $servis_selanjutnya = 'Belum Bisa Prediksi';
        if ($item->bulan_prediksi != 0) {
            $bulan_sekarang = date('n'); // bulan sekarang, 1 - 12
            $selisih_bulan = $item->bulan_prediksi - $bulan_sekarang;
            if ($selisih_bulan < 0) {
                $selisih_bulan += 12;
            }
            $servis_selanjutnya = $selisih_bulan . ' bulan lagi';
        }

        return [
            $this->index,                   
            $item->plat_nomor,
            $item->nama_kendaraan,
            $item->tanggal_masuk,
            $item->usia_mesin . ' Tahun',
            $item->riwayat_masalah == 0 ? 'Tidak ada Masalah' : 'Mesin Lanjut Usia',
            implode(', ', array_filter($decoded_pemeliharaan)),
            $item->jam_operasi_perbulan ?? 'Kosong',
            $item->frekuensi_km_harian ?? 'Kosong',
            $item->interval_km,
            ($bulan_encoder[$item->bulan_terakhir_servis] ?? '-') . ' ' . $item->tahun_terakhir_servis,
            $servis_selanjutnya
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Plat Nomor',
            'Nama Kendaraan',
            'Tanggal Masuk',
            'Usia Mesin',
            'Kondisi Kendaraan',
            'Jenis Pemeliharaan',
            'Jam Operasi Perbulan',
            'Frekuensi Harian(KM)',
            'Interval Kendaraan',
            'Bulan Terakhir Servis',
            'Servis Selanjutnya',
        ];
    }
}
