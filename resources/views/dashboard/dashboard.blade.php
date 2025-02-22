<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

</head>

<body>
    <div class="top-navbar">
        <div class="row">
            <div class="col-2">
                <img class="img-fluid" src="{{ Vite::asset('resources/images/login-logo.jpeg') }}" alt="">
            </div>
            <div class="col-4">
                <div class="logo">Data Kendaraan</div>
            </div>
        </div>
        <div>
            <div class="dropdown">
                <button class="btn custom-btn-no-outline text-white" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="row align-items-center g-2">
                        <div class="col fs-4 fw-bold">Admin </div>
                        <div class="col fs-1"> <i class="bi bi-person-circle"></i></div>
                    </div>

                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" type="button">Action</button></li>
                    <li><button class="dropdown-item" type="button">Another action</button></li>
                    <li><button class="dropdown-item" type="button">Something else here</button></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-0">
        <div class="row g-0 ">
            <!-- Sidebar -->
            <div class="col-2">
                <div class="sidebar" id="sidebar">
                    <div class="nav-item">
                        <a href="#" class="btn custom-btn-no-outline">
                            <div class="row align-items-center g-2">
                                <div class="col-auto fs-2"> <i class="bi bi-house-door"></i></div>
                                <div class="col-auto fs-4 fw-bold"> Dashboard</div>
                            </div>
                        </a>

                    </div>
                    <div class="nav-item ">
                        <button class="dropdown-btn ">
                            <div class="row align-items-center w-100 g-0 ">
                                <div class="col-2  fs-2 text-center">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="col-10 d-flex justify-content-between align-items-center">
                                    <div class="fs-4 fw-bold ">Master Data</div>
                                    <div class="col-1" >
                                        <img class="bi-caret-right w-100" src="{{ Vite::asset('resources/images/chevron-right.png') }}" alt="">
                                    </div> 
                                </div>
                            </div>
                        </button>
                        <div class="dropdown-container">
                            <div class="row">
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Jenis</a></div>
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Merk</a></div>
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Kendaraan</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item ">
                        <button class="dropdown-btn ">
                            <div class="row align-items-center g-0 w-100">
                                <div class="col-2 fs-2 text-center">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                                <div class="col-10 d-flex justify-content-between align-items-center">
                                    <div class="fs-4 fw-bold ">Servis</div>
                                    <div class="col-1 " >
                                        <img class="bi-caret-right w-100" src="{{ Vite::asset('resources/images/chevron-right.png') }}" alt="">
                                    </div> 
                                </div>
                            </div>
                        </button>
                        <div class="dropdown-container">
                            <div class="row">
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Servis</a></div>
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Selesai Servis</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item ">
                        <button class="dropdown-btn ">
                            <div class="row align-items-center g-0 w-100">
                                <div class="col-2 fs-2 text-center">
                                    <i class="bi bi-printer"></i>
                                </div>
                                <div class="col-10 d-flex justify-content-between align-items-center">
                                    <div class="fs-4 fw-bold ">Laporan</div>
                                    <div class="col-1 " >
                                        <img class="bi-caret-right w-100" src="{{ Vite::asset('resources/images/chevron-right.png') }}" alt="">
                                    </div> 
                                </div>
                            </div>
                        </button>
                        <div class="dropdown-container">
                            <div class="row">
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Laporan Masuk</a></div>
                                <div class="col-12"><a href="#" class="ms-5 btn custom-btn-no-outline">Laporan Selesai</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="btn custom-btn-no-outline">
                            <div class="row align-items-center g-2">
                                <div class="col-auto fs-2">
                                    <i class="bi bi-exclamation-octagon"></i>
                                </div>
                                <div class="col-auto fs-4 fw-bold">
                                    Pemeliharaan Kendaraan
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="fw-bold my-4">Other </div>
                    <div class="nav-item ">
                        <button class="dropdown-btn">
                            <div class="row align-items-center g-0 w-100">
                                <div class="col-2 fs-2 text-center">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <div class="col-10 d-flex justify-content-between align-items-center">
                                    <div class="fs-4 fw-bold ">Settings</div>
                                    <div class="col-1 " >
                                        <img class="bi-caret-right w-100" src="{{ Vite::asset('resources/images/chevron-right.png') }}" alt="">
                                    </div> 
                                </div>
                            </div>
                        </button>
                        
                        <div class="dropdown-container">
    <div class="row">
        <div class="col-12">
            <!-- Tombol Dropdown Level 1 -->
            <button class="dropdown-element">
                <div class="row align-items-center g-0 w-100">
                    <div class="col-2 fs-2 text-center"></div>
                    <div class="col-10 d-flex justify-content-between align-items-center">
                        <div class="fs-4 fw-bold">User</div>
                        <div class="col-1">
                            <img class="bi-caret-right w-100" src="{{ Vite::asset('resources/images/chevron-right.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </button>

            <!-- Sub-Menu Dropdown Level 2 -->
            <div class="dropdown-containers">
                <div class="col-12">
                    <a href="#" class="ms-5 btn custom-btn-no-outline">Role</a>
                </div>
                <div class="col-12">
                    <a href="#" class="ms-5 btn custom-btn-no-outline">List</a>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                    <div class="nav-item ms-1">
                        <a href="#" class="btn custom-btn-no-outline">
                            <div class="row align-items-center g-2">
                                <div class="col-auto fs-2">
                                    <i class="bi bi-box-arrow-right"></i>
                                </div>
                                <div class="col-auto fs-4 fw-bold">Logout</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

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
        </div>
    </div>





</body>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;

            if (dropdownContent.style.maxHeight) {
                dropdownContent.style.maxHeight = null; 
            } else {
                dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px"; 
            }
        });
    }

    var dropdowns = document.getElementsByClassName("dropdown-element");

for (var a = 0; a < dropdowns.length; a++) {
    dropdowns[a].addEventListener("click", function (e) {
        // Mencegah event bubbling ke parent dropdown
        e.stopPropagation();

        // Toggle class "active" pada tombol dropdown
        this.classList.toggle("active");

        // Temukan elemen sub-menu (dropdown-containers)
        var dropdownsContent = this.nextElementSibling;

        // Periksa apakah sub-menu ada
        if (dropdownsContent && dropdownsContent.classList.contains("dropdown-containers")) {
            if (dropdownsContent.style.maxHeight) {
                dropdownsContent.style.maxHeight = null; // Tutup sub-menu
            } else {
                dropdownsContent.style.maxHeight = dropdownsContent.scrollHeight + "px"; // Buka sub-menu
            }
        }
    });
}
</script>

</html>
