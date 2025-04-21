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
        
    <title>Laporan Masuk</title>
</head>
<body>
    <h1>Laporan Masuk</h1>
    <table class="table table-bordered ">
        <thead>
            <tr class="text-center">
                <th scope="col" class="col-auto">No</th>
                <th scope="col" class="col-auto">Tanggal Masuk</th>
                <th scope="col" class="col-auto">Kode Servis Masuk</th>
                <th scope="col" class="col-auto">Kode Item</th>
                <th scope="col" class="col-auto">Jenis</th>
                <th scope="col" class="col-auto">Kendaraan</th>
                <th scope="col" class="col-auto">Jumlah</th>
                <th scope="col" class="col-auto">Keterangan</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($laporan_masuk as $item)
                <tr class="text-center">
                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                    <td>{{ toIndoDate($item->tanggal_masuk) }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kendaraan->plat_nomor }}</td>
                    <td>{{ $item->kendaraan->jenis->jenis_item }}</td>
                    <td>{{ $item->kendaraan->nama_kendaraan }}</td>
                    <td>{{ $item->kendaraan->jumlah }}</td>
                    <td>
                        @if ($item->status == 1)
                            Dikerjakan
                        @else
                            Selesai
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>