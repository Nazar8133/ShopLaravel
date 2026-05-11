<form action="{{ route('basket.calculator') }}">
    @csrf
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-modal-size">
            <div class="modal-content">
                @if($errors->errorKolvo->any())
                    <div class="alert alert-warning" role="alert">
                        {{ $errors->errorKolvo->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Кошик</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
                </div>

                @if(session('basket') && !empty(session('basket')))
                    <div class="modal-body p-0">
                        <div class="px-3 pt-3 modal-scroll-area">
                            @foreach(session('basket') as $tmpSession)
                                <div class="mb-3 pb-2 @if(count(session('basket')) > 1) border-bottom @endif">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img src="{{ $tmpSession['photo'] }}" class="img-thumbnail basket-modal-photo" alt="...">
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('show.user', ['id' => $tmpSession['idWatch']]) }}" class="text-dark text-decoration-none">
                                                <p class="card-text m-0">{{ $tmpSession['name'] }}</p>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group basket-quantity-group">
                                                <input type="number" name="kolvo{{ $tmpSession['idWatch'] }}" class="form-control" value="{{ $tmpSession['kolvo'] }}" required min="1" max="{{ $tmpSession['maxKolvo'] }}">
                                                <a href="{{ route('basket.mode', ['mode' => 'del', 'id' => $tmpSession['idWatch']]) }}" class="input-group-text bg-danger text-white text-decoration-none">&times;</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <p class="card-text m-0">{{ $tmpSession['price'] * $tmpSession['kolvo'] }} ₴</p>
                                            @if(session('promoCode'))
                                                <p class="text-danger">-{{ session('promoCode')['discountValue'] }}%</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if(session('promoCode'))
                            <p class="me-auto m-0 ms-4 text-danger">Використовується промокод</p>
                        @endif
                        <p class="card-text m-0">Загальна сума: @if(session('totalCost')) {{ session('totalCost') }} @endif ₴</p>
                    </div>

                    <div class="modal-footer d-flex justify-content-between w-100">
                        <div>
                            <a class="btn btn-danger" href="{{ route('basket.mode', ['mode' => 'clear', 'id' => 0]) }}" role="button">Очистити</a>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <input type="submit" class="btn btn-secondary" name="watchList" value="Перерахувати">
                            @if(!$isCheckoutPage)
                                <a class="btn btn-primary" href="{{ route('checkout.user') }}" role="button">Оформити замовлення</a>
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
