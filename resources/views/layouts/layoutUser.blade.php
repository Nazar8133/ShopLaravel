<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>
<body>
@if($errors->errorKolvo->any() || session('open_modal'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            let modal = new bootstrap.Modal(document.getElementById('myModal'));
            modal.show();
        });
    </script>
@endif
@if(url()->current() != 'http://127.0.0.1:8000/checkout' && $errors->has('email') || $errors->has('emailReg') || $errors->has('password'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var authModal = new bootstrap.Modal(document.getElementById('authModal'));
            authModal.show();
            @if($errors->has('emailReg') || $errors->has('password'))
                document.querySelector('#register-tab').click();
            @endif
        });
    </script>
@endif
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index.user') }}">Магазин годинників</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Навігаційні пункти (якщо будуть) --}}
            </ul>


            <div class="d-flex align-items-center gap-3">
                @if (url()->current() != 'http://127.0.0.1:8000/checkout')
                    <button type="button"
                            class="basket-wrapper position-relative border-0 bg-transparent p-0"
                            data-bs-toggle="modal" data-bs-target="#myModal">
                        <img src="{{ asset('img/basket.png') }}" style="width: 35px; height: auto;">
                        @if (session('basket'))
                            <span class="basket-badge">{{ count(session('basket')) }}</span>
                        @endif
                    </button>
                @endif

                @if(url()->current()!='http://127.0.0.1:8000/checkout' && !auth('buyers')->check())
                        <img src="{{ asset('img/account.png') }}"
                             style="width: 35px; height: auto; cursor: pointer;"
                             alt="Account"
                             data-bs-toggle="modal"
                             data-bs-target="#authModal">

                        <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3 shadow">
                                    <div class="modal-header border-0">
                                        <ul class="nav nav-tabs w-100" id="authTab" role="tablist">
                                            <li class="nav-item w-50 text-center" role="presentation">
                                                <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                                                    Вхід
                                                </button>
                                            </li>
                                            <li class="nav-item w-50 text-center" role="presentation">
                                                <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                                                    Реєстрація
                                                </button>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="tab-content" id="authTabContent">

                                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                                <form action="{{ route('authenticate.buyer') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="loginEmail" class="form-label">Електронна адреса</label>
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" name="email" value="{{ old('email') ?? '' }}" required>
                                                        @error('email')
                                                        <div class="invalid-feedback d-block">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="loginPassword" class="form-label">Пароль</label>
                                                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check text-start mt-2">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="remember">
                                                                    Запам’ятати мене
                                                                </label>
                                                            </div>
                                                            <div>
                                                                <a href="{{route('buyers.password.request')}}" class="btn btn-link text-decoration-none text-primary p-0">Забули пароль?</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary w-100 mb-2">Увійти</button>
                                                    <a href="{{route('login.google')}}" class="btn btn-outline-danger w-100">
                                                        <i class="bi bi-google me-2"></i> Ввійти через Google аккаунт
                                                    </a>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade" id="register" role="tabpanel">
                                                <form method="post" action="{{route('smallRegistration.buyer')}}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="registerEmail" class="form-label">Електронна адреса</label>
                                                        <input type="email" class="form-control @error('emailReg') is-invalid @enderror" id="registerEmail" name="emailReg" required>
                                                        @error('emailReg')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="registerPassword" class="form-label">Пароль</label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="registerPassword" name="password" required>
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="registerPasswordConfirm" class="form-label">Підтвердження пароля</label>
                                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="registerPasswordConfirm" name="password_confirmation" required>
                                                        @error('password_confirmation')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-success w-100 mb-2">Зареєструватись</button>
                                                    <a href="{{route('registration.google')}}" class="btn btn-outline-danger w-100">
                                                        <i class="bi bi-google me-2"></i> Зареєструватись через Google аккаунт
                                                    </a>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @auth('buyers')
                    <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle p-0" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ asset('img/account.png') }}" style="width: 35px; height: auto;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <form method="POST" action="{{ route('logout.buyer') }}">
                                @csrf
                                <input type="submit" name="knopka" class="btn btn-link text-decoration-none text-primary p-0" value="Вийти">
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
<div class="container">
    @yield('content')
        <form action="{{route('basket.calculator')}}">
            @csrf
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog custom-modal-size">
                    <div class="modal-content">
                        @if($errors->errorKolvo->any())
                            <div class="alert alert-warning" role="alert">
                                {{$errors->errorKolvo->first()}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Кошик</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
                        </div>

                        @if(session('basket') && !empty(session('basket')))
                            <div class="modal-body p-0">
                                <div style="max-height: 400px; overflow-y: auto;" class="px-3 pt-3 modal-scroll-area">
                                    @foreach(session('basket') as $tmpSession)
                                        <div class="mb-3 pb-2 @if(count(session('basket'))>1) border-bottom @endif">
                                            <div class="row align-items-center">
                                                <div class="col-md-3 text-center">
                                                    <img src="{{$tmpSession['photo']}}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;" alt="...">
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="{{route("show.user", ['id'=>$tmpSession['idWatch']])}}" class="text-dark text-decoration-none">
                                                        <p class="card-text m-0">{{$tmpSession['name']}}</p>
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group" style="max-width: 110px;">
                                                        <input type="number" name="kolvo{{$tmpSession['idWatch']}}" class="form-control" value="{{$tmpSession['kolvo']}}" required min="1" max="{{$tmpSession['maxKolvo']}}">
                                                        <a href="{{route('basket.mode', ['mode'=>'del', 'id'=>$tmpSession['idWatch']])}}" class="input-group-text bg-danger text-white" style="text-decoration: none;">&times;</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <p class="card-text m-0">{{$tmpSession['price'] * $tmpSession['kolvo']}} ₴</p>@if(session('promoCode')) <p class="text-danger">-{{session('promoCode')['discountValue']}}%</p>  @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="modal-footer">
                                @if(session('promoCode')) <p class="me-auto m-0 ms-4 text-danger">Використовується промокод</p> @endif<p class="card-text m-0">Загальна сумма: @if(session('totalCost')) {{session('totalCost')}} @endif ₴</p>
                            </div>

                            <div class="modal-footer d-flex justify-content-between w-100">
                                <div>
                                    <a class="btn btn-danger" href="{{route('basket.mode', ['mode'=>'clear', 'id'=>0])}}" role="button">Очистити</a>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <input type="submit" class="btn btn-secondary" name="watchList" value="Перерахувати">
                                    @if(url()->current()!='http://127.0.0.1:8000/checkout')
                                    <a class="btn btn-primary" href="{{route('checkout.user')}}" role="button">Оформити замовлення</a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="modal-body">
                                <p class="card-text m-0">Тут поки що нічого немає(</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
</div>
<footer class="text-center text-lg-start bg-body-tertiary text-muted">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-google"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-github"></i>
            </a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>Company name
                    </h6>
                    <p>
                        Here you can use rows and columns to organize your footer content. Lorem ipsum
                        dolor sit amet, consectetur adipisicing elit.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Products
                    </h6>
                    <p>
                        <a href="#!" class="text-reset">Angular</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">React</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Vue</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Laravel</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Useful links
                    </h6>
                    <p>
                        <a href="#!" class="text-reset">Pricing</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Settings</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Orders</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Help</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        info@example.com
                    </p>
                    <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2025 Copyright:
        <a class="text-reset fw-bold" href="/"></a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>
