@extends('layouts.layoutUser', ['title'=>'Головна сторінка'])

@section('content')
    <style>
        .filter-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
        }

        .form-check {
            margin-bottom: 0.25rem;
        }

        .main-wrapper {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: nowrap;
        }

        .left-column {
            width: 25%;
            min-width: 250px;
        }

        .right-column {
            flex: 1;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }

            .left-column,
            .right-column {
                width: 100%;
            }
        }

        .sort-filter-wrapper {
            background-color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
        }


        @media (max-width: 768px) {
            .sort-filter-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-form {
                width: 100%;
            }
        }

        /* Стилі інпутів */
        .price-input {
            max-width: 100px;
            border-radius: 10px;
            text-align: center;
        }

    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.sort-group').forEach(group =>
                group.addEventListener('click', e => {
                    const arrow = e.target.closest('.sort-arrow');
                    if (!arrow) return;
                    const icon = arrow.querySelector('i');
                    if (icon.classList.contains('text-primary')) {
                        e.preventDefault();
                        return;
                    }
                    group.querySelectorAll('i').forEach(i => i.classList.replace('text-primary', 'text-muted'));
                    icon.classList.replace('text-muted', 'text-primary');
                })
            );
        });
    </script>
    @endpush

    <blockquote class="blockquote text-center">
        <p class="h1">Головна сторінка</p>
    </blockquote>

    @if($errors->any() && !$errors->errorKolvo->any() && !$errors->has('email') && !$errors->has('emailReg') && !$errors->has('password'))
        @foreach($errors->all() as $tmpError)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{$tmpError}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    @if(session('succes'))
        <div class="alert alert-success" role="alert">
            {{session('succes')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="main-wrapper mb-4">
        <!-- Фільтр -->
        <form action="{{route('index.user')}}">
        <div class="left-column">
            <div class="filter-section">
                <div class="mb-3">
                    <h6>Фільтри</h6>
                </div>
                @if(session('mechanismFilter') || session('brendFilter') || session('styleFilter') || session('genderFilter') || session('priceMin') || session('priceMax'))
                    <div class="mb-3">
                        <a href="{{route('clear.allFilters')}}" class="btn btn-outline-primary p-1" style="font-size: 1rem;">
                            Скинути фільтри
                        </a>
                    </div>
                @endif
                <div class="mb-3">
                    <h6>Бренди</h6>
                    @foreach($brend as $tmpBrend)
                    <div class="form-check"><input class="form-check-input" @if(session('brendFilter')) @foreach(session('brendFilter') as $brendFilter) @if($brendFilter==$tmpBrend->idBrend) checked @endif @endforeach @endif type="checkbox" name="brendFilter[]" value="{{$tmpBrend->idBrend}}"><label class="form-check-label">{{$tmpBrend->brend}}</label></div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <h6>Ціна</h6>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <input type="number" name="priceMin" placeholder="Від" class="form-control price-input" @if(session('priceMin') &&!empty(session('priceMin'))) value="{{session('priceMin')}}" @endif >
                        <span>–</span>
                        <input type="number" name="priceMax" placeholder="До" class="form-control price-input" value="{{session('priceMax')}}">
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Стиль</h6>
                    @foreach($style as $tmpStyle)
                    <div class="form-check"><input class="form-check-input" @if(session('styleFilter')) @foreach(session('styleFilter') as $styleFilter) @if($styleFilter==$tmpStyle->idStyle) checked @endif @endforeach @endif type="checkbox" name="styleFilter[]" value="{{$tmpStyle->idStyle}}"><label class="form-check-label">{{$tmpStyle->style}}</label></div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <h6>Механізм</h6>
                    @foreach($mechanism as $tmpMechanism)
                    <div class="form-check"><input class="form-check-input" @if(session('mechanismFilter')) @foreach(session('mechanismFilter') as $mechanismFilter) @if($mechanismFilter==$tmpMechanism->idMechanism) checked @endif @endforeach @endif type="checkbox" name="mechanismFilter[]" value="{{$tmpMechanism->idMechanism}}"><label class="form-check-label">{{$tmpMechanism->type}}</label></div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <h6>Стать</h6>
                    @foreach($gender as $tmpGender)
                        <div class="form-check"><input class="form-check-input" @if(session('genderFilter')) @foreach(session('genderFilter') as $genderFilter) @if($genderFilter==$tmpGender->idGender) checked @endif @endforeach @endif type="checkbox" name="genderFilter[]" value="{{$tmpGender->idGender}}"><label class="form-check-label">{{$tmpGender->gender}}</label></div>
                    @endforeach
                </div>
                <input class="btn btn-primary" type="submit" value="Фільтрувати">
            </div>
        </div>
        </form>

        <!-- Товари -->
        <div class="right-column">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 sort-filter-wrapper">
                <div id="sort-filter" class="d-flex align-items-center flex-wrap gap-4">
                    <!-- Назва -->
                    <div class="d-flex align-items-center gap-1 fw-bold">
                        Назва товару
                        <div class="d-flex flex-column lh-1 sort-group" data-sort="name">
                            <a href="{{route('index.user', ['sort' => 'name', 'direction' => 'asc'])}}" class="text-decoration-none sort-arrow" data-direction="asc">
                                <i class="bi bi-caret-up-fill @if(session('sortName')=='name' && session('typeSort')=='asc') text-primary @else text-muted @endif"></i>
                            </a>
                            <a href="{{route('index.user', ['sort' => 'name', 'direction' => 'desc'])}}" class="text-decoration-none sort-arrow" data-direction="desc">
                                <i class="bi bi-caret-down-fill @if(session('sortName')=='name' && session('typeSort')=='desc') text-primary @else text-muted @endif"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Механізм -->
                    <div class="d-flex align-items-center gap-1 fw-bold">
                        Механізм
                        <div class="d-flex flex-column lh-1 sort-group" data-sort="mechanism">
                            <a href="{{route('index.user', ['sort' => 'type', 'direction' => 'asc'])}}" class="text-decoration-none sort-arrow" data-direction="asc">
                                <i class="bi bi-caret-up-fill @if(session('sortName')=='type' && session('typeSort')=='asc') text-primary @else text-muted @endif"></i>
                            </a>
                            <a href="{{route('index.user', ['sort' => 'type', 'direction' => 'desc'])}}" class="text-decoration-none sort-arrow" data-direction="desc">
                                <i class="bi bi-caret-down-fill @if(session('sortName')=='type' && session('typeSort')=='desc') text-primary @else text-muted @endif"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Ціна -->
                    <div class="d-flex align-items-center gap-1 fw-bold">
                        Ціна
                        <div class="d-flex flex-column lh-1 sort-group" data-sort="price">
                            <a href="{{route('index.user', ['sort' => 'price', 'direction' => 'asc'])}}" class="text-decoration-none sort-arrow" data-direction="asc">
                                <i class="bi bi-caret-up-fill @if(session('sortName')=='price' && session('typeSort')=='asc') text-primary @else text-muted @endif"></i>
                            </a>
                            <a href="{{route('index.user', ['sort' => 'price', 'direction' => 'desc'])}}" class="text-decoration-none sort-arrow" data-direction="desc">
                                <i class="bi bi-caret-down-fill @if(session('sortName')=='price' && session('typeSort')=='desc') text-primary @else text-muted @endif"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <form class="d-flex search-form" role="search" action="{{route('index.user')}}">
                    @csrf
                    <input class="form-control me-2" type="search" placeholder="Назва годинника" required aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Пошук</button>
                </form>
            </div>

            @if(!empty($watchIndex[0]['name']))
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($watchIndex as $tmp)
                    <div class="col">
                        <div class="card">
                            <img src="{{$tmp->photo}}" style="height: 250px; object-fit: contain; width: 100%;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$tmp->name}}</h5>
                                <p class="card-text">Ціна: {{$tmp->price}} грн.<br>Механізм: {{$tmp->type}}</p>
                                <a href="{{route('show.user', ['id'=>$tmp->idWatch])}}" class="btn btn-primary">Детальніше</a>
                                @if($tmp->kolvo<=0)
                                    Немає в наявності!
                                @else
                                @if(session('basket') && !empty(session('basket')))
                                    @for($i=0; $i<count(session('basket')); $i++)
                                        @if(session('basket')[$i]['idWatch']==$tmp->idWatch)
                                            <button type="button" class="basket-wrapper position-relative ms-3 border-0 bg-transparent p-0" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <img src="{{ asset('img/basket.png') }}" style="width: 27px; height: auto;">
                                                    <span class="basket-badge">✓</span>
                                            </button>
                                            @break
                                        @elseif(count(session('basket'))==$i+1)
                                            <a href="{{route('basket.mode', ['mode'=>'add', 'id'=>$tmp->idWatch])}}" class="basket-wrapper position-relative ms-2">
                                                <img src="{{ asset('img/basket.png') }}" alt="basket" style="width: 27px; height: auto;">
                                            </a>
                                            @break
                                        @endif
                                    @endfor
                                @else
                                    <a href="{{route('basket.mode', ['mode'=>'add', 'id'=>$tmp->idWatch])}}" class="basket-wrapper position-relative ms-2">
                                        <img src="{{ asset('img/basket.png') }}" alt="basket" style="width: 27px; height: auto;">
                                    </a>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="row">
                    <blockquote class="blockquote text-center">
                        <p class="h2">Нажаль такого товару неіснує!</p>
                    </blockquote>
                </div>
            @endif
            <br>
            {{$watchIndex->links()}}
        </div>
    </div>
@endsection
