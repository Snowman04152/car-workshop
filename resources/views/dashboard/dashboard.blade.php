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
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class=" row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Jenis</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
                <div class="d-grid col-3 my-4 ">
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-8 fs-4">Selesai Servis</div>
                            <div class="col-2 fs-2"><i class="bi bi-arrow-repeat color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gap-5  justify-content-center">
                <div class="d-grid col-3  my-4">
                    <div class="p-3  btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Merk</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
                <div class="d-grid col-3  my-4">
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-8 fs-4">Laporan Masuk</div>
                            <div class="col-3 fs-2"><i class="bi bi-printer color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row gap-5 justify-content-center">
                <div class="d-grid col-3  my-4">
                    <div class="p-3  btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Mobil</div>
                            <div class="col-3 fs-2"> <i class="bi bi-box-seam color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
                <div class="d-grid col-3  my-4">
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-9 fs-4">Laporan Selesai</div>
                            <div class="col-3 fs-2"><i class="bi bi-printer color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gap-5 justify-content-center">
                <div class="d-grid col-3 my-4">
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-3 fs-4">Servis</div>
                            <div class="col-3 fs-3"><i class="bi bi-arrow-repeat color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
                <div class="d-grid col-3 my-4 ">
                    <div class="p-3 btn custom-btn btn-lg fw-bold rounded-4">
                        <div class="row justify-content-evenly align-items-center">
                            <div class="col-7 fs-4">Settings</div>
                            <div class="col-2 fs-2"><i class="bi bi-gear color-blue-custom"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

