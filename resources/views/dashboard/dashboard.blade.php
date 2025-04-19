@extends('layouts.app')

@section('content')


    <div class="col-10 p-3">
        <div class="p-0 ms-5 fs-2 fw-bold">
            <div class="ms-5">
                Dashboard
            </div>
        </div>
        <div>
            <div class="row gap-5  justify-content-center ">
                <div class="d-grid col-3 my-4  ">
                    <a href="{{route('jenis')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class=" row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Jenis</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                <div class="d-grid col-3 my-4 ">
                    <a href="{{route('pemeliharaan')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-8 fs-4">Pemeliharaan</div>
                            <div class="col-2 fs-2"><i class="bi bi-arrow-repeat color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row gap-5  justify-content-center">
                <div class="d-grid col-3  my-4">
                    <a href="{{route('merk')}}" class="p-3  btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Merk</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                <div class="d-grid col-3  my-4">
                    <a href="{{route('laporan_masuk')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-8 fs-4">Laporan Masuk</div>
                            <div class="col-3 fs-2"><i class="bi bi-printer color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="row gap-5 justify-content-center">
                <div class="d-grid col-3  my-4">
                    <a href="{{route('kendaraan')}}" class="p-3  btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Kendaraan</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                <div class="d-grid col-3  my-4">
                    <a href="{{route('laporan_keluar')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-9 fs-4">Laporan Selesai</div>
                            <div class="col-3 fs-2"><i class="bi bi-printer color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row gap-5 justify-content-center">
                <div class="d-grid col-3 my-4">
                    <a href="{{route('servis')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Servis</div>
                            <div class="col-3 fs-3"><i class="bi bi-arrow-repeat color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                @if (Auth::user()->role_id == 1)
                <div class="d-grid col-3 my-4 ">
                    <a href="{{route('list')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-7 fs-4">Settings</div>
                            <div class="col-2 fs-2"><i class="bi bi-gear color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                @else
                <div class="d-grid col-3 my-4 ">
                    <a href="{{route('dashboard')}}" class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-7 fs-4">Dashboard</div>
                            <div class="col-2 fs-2"><i class="bi bi-gear color-blue-custom"></i></div>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

