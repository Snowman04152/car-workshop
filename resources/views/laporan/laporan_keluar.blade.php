@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Laporan Pemakaian
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Laporan Pemakaian</div>
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
                                        href="{{ route('laporankeluar.exportExcel') }}">
                                        Excel
                                    </a>
                                    <a class="btn btn-outline-primary col-1 rounded-0"
                                        href="{{ route('laporankeluar.exportPdf') }}">
                                        Pdf
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered " id="laporankeluar_table">
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

                                    @if ($item->jam_kembali == null || 0)
                                        <td class="text-center">Kosong</td>
                                    @else
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->jam_kembali)->format('H:i') }}
                                    @endif
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#laporankeluar_table').DataTable();
            });
        </script>
    @endpush
@endsection
