@extends('layouts.layoutUser', ['title'=>'Детальніше про товар'])
@section('content')
    <style>
        .carousel-item {
            text-align: center;
        }

        .carousel-item img {
            max-width: 100%;
            max-height: 500px;
            width: auto;
            height: auto;
            display: inline-block;
            object-fit: contain;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black; /* або будь-який інший */
            border-radius: 50%;      /* за бажанням */
        }
    </style>

    @push('scripts')
    <script>
        const myCarouselElement = document.querySelector('#carouselExample')
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: 2000,
            touch: false
        })
    </script>
    @endpush

    @if($errors->any())
        @foreach($errors->all() as $tmpError)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{$tmpError}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <br>
    <div class="card mb-3">
        <div class="d-flex justify-content-start ps-3 mt-3">
            <a href="{{ route('index.user') }}" class="btn btn-outline-primary">⬅Назад</a>
        </div>
        <div class="container" style="max-width: 600px;">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                @foreach($photo as $tmpPhoto)
                    @if($tmpPhoto->status==1)
                    <div class="carousel-item active">
                        <img src="{{$tmpPhoto->photo}}" class="d-block w-100" alt="...">
                    </div>
                    @else
                        <div class="carousel-item">
                            <img src="{{$tmpPhoto->photo}}" class="d-block w-100" alt="...">
                        </div>
                    @endif
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Назва годинника</h5>
                            <p class="card-text">{{$watch->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ціна</h5>
                            <p class="card-text">{{$watch->price}} грн</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Механізм</h5>
                            <p class="card-text">{{$watch->type}}</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Бренд</h5>
                            <p class="card-text">{{$watch->brend}}</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Стиль</h5>
                            <p class="card-text">{{$watch->style}}</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Стать</h5>
                            <p class="card-text">{{$watch->gender}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="card-text"> Детальний опис: <br>{{$watch->discription}}</p>
            @if($watch->kolvo<=0)
                <div class="alert alert-secondary text-center fw-bold py-2 mb-2">Немає в наявності!</div>
            @else
            @if(!$rezultCheck)
                <a href="{{route('basket.mode', ['mode'=>'add', 'id'=>$watch->idWatch])}}" class="btn btn-primary">Купити</a>
            @else
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#myModal">
                    В кошику
                </button>
            @endif
            @endif
        </div>

@endsection
