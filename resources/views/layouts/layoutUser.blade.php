<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
@php($isCheckoutPage = request()->routeIs('checkout.user'))
@include('partials.user.modal-scripts')

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index.user') }}">Магазин годинників</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Навігаційні пункти --}}
            </ul>

            <div class="d-flex align-items-center gap-3">
                @if(!$isCheckoutPage)
                    <button type="button"
                            class="basket-wrapper position-relative border-0 bg-transparent p-0"
                            data-bs-toggle="modal" data-bs-target="#myModal">
                        <img src="{{ asset('img/basket.png') }}" class="nav-icon" alt="Кошик">
                        @if(session('basket'))
                            <span class="basket-badge">{{ count(session('basket')) }}</span>
                        @endif
                    </button>
                @endif

                @if(!$isCheckoutPage && !auth('buyers')->check())
                    <img src="{{ asset('img/account.png') }}"
                         class="nav-icon nav-icon-clickable"
                         alt="Account"
                         data-bs-toggle="modal"
                         data-bs-target="#authModal">

                    @include('partials.user.auth-modal')
                @endif

                @auth('buyers')
                    <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle p-0" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ asset('img/account.png') }}" class="nav-icon" alt="Account">
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

<main class="container flex-grow-1">
    @yield('content')
    @include('partials.user.basket-modal')
</main>

@include('partials.user.footer')

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>
