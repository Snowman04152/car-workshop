@extends('layouts.app')
@section('content')
    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Laporan Selesai
            </div>
        </div>
        <div class="ms-5 mt-3">
            <div class="container bg-white p-3 ms-5 w-auto shadow">
                <div class="row d-flex justify-content-between">
                    <div class="col fw-bold fs-5 align-items-center">Data Laporan Selesai</div>
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
                                    <a class="btn btn-primary col-1 rounded-0" href="{{ route('laporankeluar.exportExcel') }}" >
                                        Excel
                                    </a>
                                    <a class="btn btn-outline-primary col-1 rounded-0" href="{{ route('laporankeluar.exportPdf') }}">
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
                                <th scope="col" class="col-auto">No</th>
                                <th scope="col" class="col-auto text-center">Tanggal Masuk</th>
                                <th scope="col" class="col-auto text-center">Tanggal Keluar</th>
                                <th scope="col" class="col-auto">Kode Servis Masuk</th>
                                <th scope="col" class="col-auto">Kode Item</th>
                                <th scope="col" class="col-auto">Jenis</th>
                                <th scope="col" class="col-auto">Kendaraan</th>
                                <th scope="col" class="col-auto">Jumlah</th>
                                <th scope="col" class="col-auto">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($laporan_keluar as $item)
                            <tr>
                                <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                <td>{{toIndoDate($item->tanggal_masuk)}}</td>
                                @if ($item->tanggal_selesai == null)
                                <td>Sedang Dikerjakan</td>
                                @else
                                <td>{{toIndoDate($item->tanggal_selesai)}}</td>
                                @endif
                                <td class="text-center">{{$item->id}}</td>
                                <td>{{$item->kendaraan->plat_nomor}}</td>
                                <td>{{$item->kendaraan->jenis->jenis_item}}</td>
                                <td>{{$item->kendaraan->nama_kendaraan}}</td>
                                <td class="text-center">{{$item->kendaraan->jumlah}}</td>
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
