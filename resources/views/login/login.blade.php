<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-blue-custom">
        <!-- Pills navs -->
        <section class="vh-100  gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-white text-dark" style="border-radius: 1rem;">
                            <div class="card-body p-4 text-center">
                                <div class="mb-md-5 mt-md-4">
                                    <img class="img-fluid w-25 mb-4" src="{{ Vite::asset('resources/images/login-logo.jpeg') }}" alt="">
                                    <h3 class="fw-bold mb-2 inter-100 text-uppercase">Data Kendaraan & Sarpras</h2>
                                    <h4 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <form>
                                        <!-- Input dengan ikon orang -->
                                        <div class="mb-3">

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-person"></i>
                                                    <!-- Ikon orang dari Bootstrap Icons -->
                                                </span>
                                                <input type="email" class="form-control" id="nama"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="mb-3">

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-eye"></i> <!-- Ikon orang dari Bootstrap Icons -->
                                                </span>
                                                <input type="password" class="form-control" id="nama"
                                                    placeholder="Password">
                                            </div>
                                        </div>


                                    </form>
                                    <button data-mdb-button-init data-mdb-ripple-init
                                        class="btn custom-login-btn btn-lg px-5" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>
