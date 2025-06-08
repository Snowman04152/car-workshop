<?php

namespace App\Exports;

use App\Models\Pemakaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class LaporanKeluarExport implements FromCollection, WithMapping, WithHeadings
{
    private $index = 0;

    public function collection()
    {
        return Pemakaian::with('kendaraan')
            ->whereHas('kendaraan', function ($query) {
                $query->where('hapus_id', 0);
            })
            ->orderByRaw('CASE WHEN jam_kembali IS NULL THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function map($item): array
    {
        $this->index++;

        return [
            $this->index,
            $item->kendaraan->plat_nomor ?? '-',
            $item->kendaraan->nama_kendaraan ?? '-',
            $item->nama_supir ?? '-',
            $item->hari ? Carbon::parse($item->hari)->format('d-m-Y') : '-',
            $item->jam_keluar ? Carbon::parse($item->jam_keluar)->format('H:i') : '-',
            $item->jam_kembali ? Carbon::parse($item->jam_kembali)->format('H:i') : '-',
            $item->km_harian_keluar ?? '-',
            ($item->km_harian_kembali == null || $item->km_harian_kembali == 0) ? 'Kosong' : $item->km_harian_kembali,
            ($item->km_harian == null || $item->km_harian == 0) ? 'Kosong' : $item->km_harian,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Plat Nomor',
            'Kendaraan',
            'Supir',
            'Hari',
            'Jam Keluar',
            'Jam Kembali',
            'KM Harian Keluar',
            'KM Harian Kembali',
            'KM Harian',
        ];
    }
}
