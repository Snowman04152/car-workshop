<?php

namespace App\Exports;

use App\Models\Servis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use function App\Helpers\toIndoDate;
// require_once app_path('Helpers/helper.php');
class LaporanKeluarExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->where('status', 2)->get();
    }

    public function map($servis): array
    {
        return [
            $servis->id,
            $servis->kendaraan->nama_kendaraan ?? '-',
            $servis->tanggal_masuk,
            $servis->tanggal_selesai,
            $servis->kendaraan_id,
            $servis->kendaraan->jenis->jenis_item,
            $this->formatStatus($servis->status),
            $servis->kendaraan->jumlah,
            $servis->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kendaraan',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Kode Item',
            'Jenis',
            'Status',
            'Jumlah',
            'Waktu Dibuat'
        ];
    }

    private function formatStatus($status)
    {
        return [
            1 => 'Dikerjakan',
            2 => 'Selesai'
        ][$status] ?? 'Tidak diketahui';
    }
}