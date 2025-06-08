<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html {
            font-size: 12px;
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 0.5rem;
            border: 1px solid black !important;
        }
    </style>

    <title>Laporan Selesai</title>
</head>

<body>
    <h1>Laporan Selesai</h1>
    <table class="table table-bordered ">
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
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($laporan_keluar as $item)
                <tr class="">
                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $item->kendaraan->plat_nomor }}</td>
                    <td>{{ $item->kendaraan->nama_kendaraan }}</td>
                    <td class="text-center">{{ $item->nama_supir }} </td>
                    <td class="text-center">{{ toIndoDate($item->hari) }} </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->jam_kembali)->format('H:i') }}
                    </td>
                    <td class="text-center">{{ $item->km_harian_keluar }}</td>
                    @if ($item->km_harian_kembali == null || 0)
                        <td class="text-center">Kosong</td>
                    @else
                        <td class="text-center">{{ $item->km_harian_kembali }}</td>
                    @endif
                    @if ($item->km_harian == null || 0)
                        <td class="text-center">Kosong</td>
                    @else
                        <td class="text-center">{{ $item->km_harian }}</td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
