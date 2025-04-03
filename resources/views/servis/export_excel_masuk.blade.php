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
            <tr>
                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                <td>{{ toIndoDate($item->tanggal_masuk) }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->kendaraan_id }}</td>
                <td>{{ $item->kendaraan->jenis->jenis_item }}</td>
                <td>{{ $item->kendaraan->merk->merk_item }}</td>
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
