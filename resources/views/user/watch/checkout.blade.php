@extends('layouts.layoutUser', ['title'=>'Оформлення замовлення'])
@section('content')
    @push('scripts')
        <script async src="https://pay.google.com/gp/p/js/pay.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // --- Зберігаємо scroll тільки якщо була відправка форми
                window.addEventListener('beforeunload', function () {
                    if (sessionStorage.getItem('formSubmitted') === 'true') {
                        sessionStorage.setItem('scrollPosition', window.scrollY);
                    } else {
                        sessionStorage.removeItem('scrollPosition');
                    }
                });

                // --- Ставимо маркер при відправці форми
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', () => {
                        sessionStorage.setItem('formSubmitted', 'true');
                    });
                });

                // --- Відновлення scroll тільки якщо була форма
                window.addEventListener('load', function () {
                    if (sessionStorage.getItem('formSubmitted') === 'true') {
                        const scrollY = sessionStorage.getItem('scrollPosition');
                        if (scrollY !== null) {
                            window.scrollTo(0, parseInt(scrollY));
                        }
                        sessionStorage.removeItem('formSubmitted'); // скидаємо маркер після відновлення
                    }
                });

                // --- При кліку по посиланню очищаємо тільки scroll
                document.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        sessionStorage.removeItem('scrollPosition');
                    });
                });

                // --- Зберігати останнє відкрите пошукове вікно
                document.getElementById('citySelector')?.addEventListener('click', function (e) {
                    e.preventDefault?.();
                    sessionStorage.setItem('lastSearchBox', 'city');
                    sessionStorage.setItem('openDeliveryBox', 'true');
                });
                document.getElementById('branchSelector')?.addEventListener('click', function (e) {
                    e.preventDefault?.();
                    sessionStorage.setItem('lastSearchBox', 'branch');
                    sessionStorage.setItem('openDeliveryBox', 'true');
                });
                const novaRadio = document.getElementById('novaPoshtaRadio');
                const pickupRadio = document.getElementById('pickupRadio');
                const addressRadio = document.getElementById('addressRadio');
                const deliveryBox = document.getElementById('deliveryBox');

                const citySelector = document.getElementById('citySelector');
                const citySearchBox = document.getElementById('citySearchBox');

                const branchSelector = document.getElementById('branchSelector');
                const branchSearchBox = document.getElementById('branchSearchBox');

                const radios = document.querySelectorAll('input[name="delivery_method"]');
                const editBtn = document.getElementById('editNovaPoshta');
                const selectedInfo = document.querySelector('.selected-info');

                window.errors = {
                    errorNp: @json($errors->has('errorNp')),
                    searchCity: @json($errors->has('searchCity')),
                    searchWarehouses: @json($errors->has('searchWarehouses')),
                };

                // === Якщо є помилки — виставляємо selectedDelivery = novaPoshtaRadio
                if ((window.errors.errorNp || window.errors.searchCity || window.errors.searchWarehouses) &&
                    !sessionStorage.getItem('selectedDelivery')
                ) {
                    sessionStorage.setItem('selectedDelivery', 'novaPoshtaRadio');
                }

                // === ВІДНОВЛЕННЯ radio з sessionStorage
                const savedDelivery = sessionStorage.getItem('selectedDelivery');
                if (savedDelivery) {
                    const selectedRadio = document.getElementById(savedDelivery);
                    if (selectedRadio) {
                        selectedRadio.checked = true;

                        if (savedDelivery === 'novaPoshtaRadio') {
                            if (!isNovaCompleted()) {
                                deliveryBox?.classList.add('expanded');
                            } else {
                                deliveryBox?.classList.remove('expanded');
                            }
                        }
                    }
                }

                // --- Відновлення deliveryBox
                if (
                    sessionStorage.getItem('openDeliveryBox') === 'true' ||
                    (window.errors && (window.errors.errorNp || window.errors.searchCity || window.errors.searchWarehouses))
                ) {
                    deliveryBox?.classList.add('expanded');
                }

                // --- Відновлення пошукових вікон
                if (window.errors) {
                    if (window.errors.searchCity) {
                        citySearchBox?.classList.add('expanded');
                        branchSearchBox?.classList.remove('expanded');
                        sessionStorage.setItem('openDeliveryBox', 'true');
                    } else if (window.errors.searchWarehouses) {
                        branchSearchBox?.classList.add('expanded');
                        citySearchBox?.classList.remove('expanded');
                        sessionStorage.setItem('openDeliveryBox', 'true');
                    } else if (window.errors.errorNp) {
                        const lastOpen = sessionStorage.getItem('lastSearchBox');
                        if (lastOpen === 'city') {
                            citySearchBox?.classList.add('expanded');
                        } else if (lastOpen === 'branch') {
                            branchSearchBox?.classList.add('expanded');
                        }
                        sessionStorage.setItem('openDeliveryBox', 'true');
                    }
                }

                if (citySearchBox?.classList.contains('expanded') || branchSearchBox?.classList.contains('expanded')) {
                    deliveryBox?.classList.add('expanded');
                }

                document.querySelectorAll('.city-option, .branch-option').forEach(item => {
                    item.addEventListener('click', () => {
                        sessionStorage.setItem('openDeliveryBox', 'true');
                    });
                });

                function isNovaCompleted() {
                    let city = "{{ session('selectCity') ?? '' }}".trim();
                    let warehouse = "{{ session('selectWarehouses') ?? '' }}".trim();
                    return city !== '' && warehouse !== '';
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        sessionStorage.setItem('selectedDelivery', this.id);

                        if (this.id === 'novaPoshtaRadio') {
                            if (!isNovaCompleted()) {
                                deliveryBox?.classList.add('expanded');
                            } else {
                                deliveryBox?.classList.remove('expanded');
                            }
                        } else {
                            deliveryBox?.classList.remove('expanded');
                        }

                        citySearchBox?.classList.remove('expanded');
                        branchSearchBox?.classList.remove('expanded');
                    });
                });

                if (editBtn && deliveryBox) {
                    editBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        deliveryBox.classList.toggle('expanded');
                    });
                }

                citySelector?.addEventListener('click', (e) => {
                    e.preventDefault?.();
                    citySearchBox?.classList.toggle('expanded');
                    branchSearchBox?.classList.remove('expanded');
                    sessionStorage.setItem('openDeliveryBox', 'true');
                });

                branchSelector?.addEventListener('click', (e) => {
                    e.preventDefault?.();
                    branchSearchBox?.classList.toggle('expanded');
                    citySearchBox?.classList.remove('expanded');
                    sessionStorage.setItem('openDeliveryBox', 'true');
                });

                setTimeout(() => {
                    sessionStorage.removeItem('openDeliveryBox');
                }, 1000);

                ///////////////////
                const addressRadioBtn = document.getElementById('addressRadio');
                const addressFormContainer = document.getElementById('address-form');
                const editAddressButton = document.getElementById('editAddress');
                const deliveryOptions = document.querySelectorAll('input[name="delivery_method"]');
                const addressInfoBlock = addressRadioBtn?.closest('.delivery-option')?.querySelector('.selected-info') ?? null;

                // --- Анімаційне show/hide ---
                function showAddressForm() {
                    if (addressFormContainer) {
                        addressFormContainer.classList.add('address-form--visible');
                    }
                }

                function hideAddressForm() {
                    if (addressFormContainer) {
                        addressFormContainer.classList.remove('address-form--visible');
                    }
                }

                if (addressFormContainer && addressRadioBtn) {
                    function initializeAddressSection() {
                        const hasAddress = !!addressInfoBlock;
                        if (hasAddress) {
                            hideAddressForm();
                        } else {
                            if (addressRadioBtn.checked) {
                                showAddressForm();
                            } else {
                                hideAddressForm();
                            }
                        }
                    }

                    initializeAddressSection();

                    deliveryOptions.forEach(option => {
                        option.addEventListener('change', () => {
                            const hasAddress = !!addressInfoBlock;

                            if (option === addressRadioBtn && !hasAddress && addressRadioBtn.checked) {
                                showAddressForm();
                            } else if (option !== addressRadioBtn && !hasAddress) {
                                hideAddressForm();
                            }
                        });
                    });

                    if (editAddressButton) {
                        editAddressButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (addressFormContainer.classList.contains('address-form--visible')) {
                                hideAddressForm();
                            } else {
                                showAddressForm();
                            }
                        });
                    }
                }

                // === Логіка адреси доставки (інпут блокування) ===
                const houseInputAddress = document.getElementById('house');
                const apartmentInputAddress = document.getElementById('apartment');

                if (houseInputAddress && apartmentInputAddress) {
                    function initLockState() {
                        const houseVal = houseInputAddress.value?.toString().trim();
                        const aptVal = apartmentInputAddress.value?.toString().trim();

                        if (houseVal !== '' && aptVal === '') {
                            apartmentInputAddress.disabled = true;
                        } else if (aptVal !== '' && houseVal === '') {
                            houseInputAddress.disabled = true;
                        } else {
                            houseInputAddress.disabled = false;
                            apartmentInputAddress.disabled = false;
                        }
                    }

                    houseInputAddress.addEventListener('input', () => {
                        const val = houseInputAddress.value?.toString().trim();
                        if (val !== '') {
                            apartmentInputAddress.value = '';
                            apartmentInputAddress.disabled = true;
                        } else if (apartmentInputAddress.value?.toString().trim() === '') {
                            apartmentInputAddress.disabled = false;
                        }
                    });

                    apartmentInputAddress.addEventListener('input', () => {
                        const val = apartmentInputAddress.value?.toString().trim();
                        if (val !== '') {
                            houseInputAddress.value = '';
                            houseInputAddress.disabled = true;
                        } else if (houseInputAddress.value?.toString().trim() === '') {
                            houseInputAddress.disabled = false;
                        }
                    });

                    initLockState();
                }

                const toggleForm = (showBtnId, hideBtnId, formId, extraHideId = null, extraShowId = null) => {
                    const showBtn = document.getElementById(showBtnId);
                    const hideBtn = document.getElementById(hideBtnId);
                    const form = document.getElementById(formId);
                    const extraHide = extraHideId ? document.getElementById(extraHideId) : null;
                    const extraShow = extraShowId ? document.getElementById(extraShowId) : null;

                    if (!showBtn) return;

                    showBtn.addEventListener('click', (e) => {
                        if (e && e.preventDefault) e.preventDefault();
                        form?.classList.remove('d-none');
                        showBtn.classList.add('d-none');
                        if (hideBtn) hideBtn.classList.remove('d-none');
                        extraHide?.classList.add('d-none');
                    });

                    if (hideBtn) {
                        hideBtn.addEventListener('click', (e) => {
                            if (e && e.preventDefault) e.preventDefault();
                            form?.classList.add('d-none');
                            showBtn.classList.remove('d-none');
                            hideBtn.classList.add('d-none');
                            extraHide?.classList.remove('d-none');
                            extraShow?.classList.remove('d-none');
                        });
                    }
                };

                toggleForm('togglePromoBtn', 'closePromoBtn', 'promoCodeForm');
                toggleForm('toggleContactBtn', 'collapseContactBtn', 'contactForm', 'userFullName');

                const editUserBtn = document.getElementById('toggle-edit-btn');
                const editUserForm = document.getElementById('edit-user-form');

                editUserBtn?.addEventListener('click', () => {
                    if (!editUserForm) return;
                    const isVisible = !editUserForm.classList.contains('d-none');
                    if (isVisible) {
                        editUserForm.classList.add('d-none');
                        editUserBtn.textContent = 'Змінити';
                        editUserBtn.classList.remove('btn-outline-danger');
                        editUserBtn.classList.add('btn-outline-primary');
                    } else {
                        editUserForm.classList.remove('d-none');
                        editUserBtn.textContent = 'Закрити';
                        editUserBtn.classList.remove('btn-outline-primary');
                        editUserBtn.classList.add('btn-outline-danger');
                    }
                });

                if (editUserForm?.dataset.hasErrors === 'true') {
                    editUserBtn?.click();
                }

                (function(){
                    const hasPromoCode = "{{ session('promoCode') ? 'true' : 'false' }}";

                    if (hasPromoCode === 'true') {
                        const promoForm = document.getElementById('promoCodeForm');
                        const toggleBtn = document.getElementById('togglePromoBtn');
                        const closeBtn = document.getElementById('closePromoBtn');

                        if (promoForm) promoForm.classList.add('d-none');
                        if (toggleBtn) toggleBtn.classList.add('d-none');
                        if (closeBtn) closeBtn.classList.add('d-none');
                    }
                    if (@json($errors->has('promoCode'))) {
                        const promoForm = document.getElementById('promoCodeForm');
                        const toggleBtn = document.getElementById('togglePromoBtn');
                        const closeBtn = document.getElementById('closePromoBtn');

                        if (promoForm) promoForm.classList.remove('d-none');
                        if (toggleBtn) toggleBtn.classList.add('d-none');
                        if (closeBtn) closeBtn.classList.remove('d-none');
                    }
                })();
                // ====== Доставка ======
                const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
                const hiddenDelivery = document.getElementById('selected_delivery');

                deliveryRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        hiddenDelivery.value = this.value;
                    });
                    if (radio.checked) {
                        hiddenDelivery.value = radio.value;
                    }
                });

                // ====== Оплата ======
                const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
                const hiddenPayment = document.getElementById('selected_payment');

                paymentRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        hiddenPayment.value = this.value;
                    });
                    if (radio.checked) {
                        hiddenPayment.value = radio.value;
                    }
                });
                const komentInput = document.getElementById('koment_input');
                const hiddenKoment = document.getElementById('koment');

                komentInput.addEventListener('input', function () {
                    hiddenKoment.value = this.value;
                });

                // Якщо вже є значення при завантаженні сторінки
                if (komentInput.value) {
                    hiddenKoment.value = komentInput.value;
                }
                /* ========== GOOGLE PAY CONFIG ========== */
                const baseRequest = { apiVersion: 2, apiVersionMinor: 0 };
                const allowedCardNetworks = ["VISA","MASTERCARD"];
                const allowedCardAuthMethods = ["PAN_ONLY","CRYPTOGRAM_3DS"];

                const tokenizationSpecification = {
                    type: 'PAYMENT_GATEWAY',
                    parameters: {
                        'gateway': 'example',
                        'gatewayMerchantId': 'exampleMerchantId'
                    }
                };

                const baseCardPaymentMethod = {
                    type: 'CARD',
                    parameters: {
                        allowedAuthMethods: allowedCardAuthMethods,
                        allowedCardNetworks: allowedCardNetworks
                    }
                };

                const cardPaymentMethod = Object.assign({}, baseCardPaymentMethod, { tokenizationSpecification });
                let paymentsClient = null;

                function getGooglePaymentDataRequest() {
                    const paymentDataRequest = Object.assign({}, baseRequest);
                    paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
                    paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
                    paymentDataRequest.merchantInfo = { merchantName: 'Demo Merchant' };
                    return paymentDataRequest;
                }

                function getGoogleTransactionInfo() {
                    return {
                        countryCode: 'UA',
                        currencyCode: 'UAH',
                        totalPriceStatus: 'FINAL',
                        totalPrice: document.getElementById("totalPrice").innerText
                    };
                }

                function getGooglePaymentsClient() {
                    if (paymentsClient === null) {
                        paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });
                    }
                    return paymentsClient;
                }

                /* ========== FORM SUBMIT ========== */
                const form = document.getElementById("orderForm");

                form.addEventListener("submit", function(event) {
                    const selectedPayment = document.querySelector("input[name='payment_method']:checked");

                    if (selectedPayment && selectedPayment.value === "googlePay") {
                        event.preventDefault();

                        const paymentDataRequest = getGooglePaymentDataRequest();
                        const client = getGooglePaymentsClient();

                        client.loadPaymentData(paymentDataRequest)
                            .then(function(paymentData) {
                                console.log("Google Pay Response:", paymentData);

                                // Додаємо токен у форму
                                let tokenInput = document.createElement("input");
                                tokenInput.type = "hidden";
                                tokenInput.name = "googlePayToken";
                                tokenInput.value = paymentData.paymentMethodData.tokenizationData.token;
                                form.appendChild(tokenInput);

                                form.submit(); // тепер реально відправляємо форму
                            })
                            .catch(function(err) {
                                console.error("Google Pay Error:", err);
                            });
                    }
                });
            });
        </script>
    @endpush
    <style>
        .delivery-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-width: 100%;
        }

        .delivery-option {
            display: block;
            background-color: #f1f3f5;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
        }

        .delivery-box {
            background-color: #f1f3f5;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.5s ease, opacity 0.5s ease;
            pointer-events: none;
            overflow: hidden;
        }

        .delivery-box.expanded {
            max-height: 1000px;
            opacity: 1;
            pointer-events: all;
        }

        .search-box {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            margin-top: 8px;
        }

        .search-box.expanded {
            max-height: 500px; /* або більше, якщо список може бути довгий */
            opacity: 1;
        }

        input:focus,
        button:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .delivery-header {
            padding: 0;
            background: none;
            border: none;
            font-weight: bold;
            font-size: 1rem;
            margin-top: 12px;
            margin-bottom: 10px;
        }

        .delivery-content {
            padding: 10px;
            width: 100%;
        }

        .scroll-box {
            max-height: 180px;
            overflow-y: auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        .select-option {
            display: block;
            padding: 6px 12px;
            margin-bottom: 5px;
            background-color: #e9ecef;
            border-radius: 5px;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s;
        }

        .select-option:hover {
            background-color: #ced4da;
        }

        .form-section {
            margin-bottom: 0.6rem;
        }

        input[type="radio"] {
            accent-color: #0d6efd;
            width: 18px;
            height: 18px;
        }

        .fake-input {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 8px 10px;
            width: 100%;
            cursor: pointer;
            color: #6c757d;
        }
        input.select-option[type="submit"] {
            all: unset; /* скидає всі браузерні стилі кнопки */
            display: block;
            width: 98%;
            padding: 6px 12px;
            margin-bottom: 5px;
            background-color: #e9ecef;
            border-radius: 5px;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s;
            text-align: left;
            font-family: inherit;
            font-size: 1rem;
            color: #212529;
        }

        input.select-option[type="submit"]:hover {
            background-color: #ced4da;
        }

        .selected-info {
            margin-left: 1.6rem; /* Щоб вирівняти під іконку */
            font-size: 14px;
            color: #222;
        }

        .subtitle {
            color: #888;
            font-size: 13px;
            margin-bottom: 0.1rem;
        }

        .address {
            font-weight: 500;
        }

        .edit-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: transparent;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #444;
        }
        #address-form {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.5s ease, opacity 0.5s ease;
        }

        #address-form.address-form--visible {
            max-height: 1000px; /* достатньо велике значення */
            opacity: 1;
        }
    </style>
    <div class="container my-5">
        <h2 class="mb-4">Оформлення замовлення</h2>
        <div class="row">
            @if(session('succes'))
                <div class="alert alert-success" role="alert">
                    {{session('succes')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                @foreach (['errorGuest', 'selected_delivery', 'selected_payment'] as $field)
                    @error($field)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @enderror
                @endforeach
            <!-- Ліва колонка: форма входу + решта оформлення -->
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-4">
                    @auth('buyers')
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person fs-4 me-2"></i>
                                <span class="fw-medium {{!isset($pib[0]) || !auth('buyers')->user()->number ? 'text-danger' : '' }}" id="userFullName">@if(!isset($pib[0]) || !auth('buyers')->user()->number) Для того щоб оформити замовлення потрібно заповнити всі поля! @else {{$pib[0].' '.$pib[1].' '.$pib[2]}} @endif</span>
                            </div>
                            <button id="toggle-edit-btn" class="btn btn-link text-decoration-none text-primary p-0 bg-transparent">
                                Змінити
                            </button>
                        </div>

                        <div id="edit-user-form" @if($errors->has('number') || $errors->has('email') || $errors->has('lastName') || $errors->has('middleName') || $errors->has('firstName')) data-has-errors="true" @endif class="px-3 pb-3 d-none">
                            <form action="{{route('update.buyer', ['idBuyer'=>auth('buyers')->user()->idBuyer])}}" method="post">
                                @csrf
                                @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Мобільний телефон</label>
                                    <input type="text" name="number" id="phone" class="form-control @error('number') is-invalid @enderror" value="{{old('number') ?? auth('buyers')->user()->number ?? ''}}" required minlength="10" maxlength="13">
                                    @error('number')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Електронна пошта</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email') ?? auth('buyers')->user()->email}}" required>
                                    @error('email')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="lastname" class="form-label">Прізвище</label>
                                    <input type="text" name="lastName" id="lastname" class="form-control @error('lastName') is-invalid @enderror" value="{{ old('lastName') ?? $pib[0] ?? ''}}" required>
                                    @error('lastName')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="firstname" class="form-label">Імʼя</label>
                                    <input type="text" name="firstName" id="firstname" class="form-control @error('firstName') is-invalid @enderror" value="{{old('firstName') ?? $pib[1] ?? ''}}" required>
                                    @error('firstName')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="middleName" class="form-label">По батькові</label>
                                    <input type="text" name="middleName" id="middleName" class="form-control @error('middleName') is-invalid @enderror" value="{{old('middleName') ?? $pib[2] ?? ''}}" required>
                                    @error('middleName')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" name="knopka" value="Зберегти">
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Вхід -->
                        <div class="card">
                            <div class="card-header">Увійдіть для оформлення замовлення</div>
                            <div class="card-body">
                                <form action="{{ route('authenticate.buyer') }}">
                                    @csrf
                                    <div class="d-flex flex-column align-items-center gap-2">
                                        <div class="mb-3 w-100 d-flex flex-column align-items-center">
                                            <label for="email" class="form-label" style="width: 450px; text-align: left;">Електронна адреса</label>
                                            <div style="width: 450px;">
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') ?? '' }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback d-block">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <label for="password" class="form-label mt-3" style="width: 450px; text-align: left;">Пароль</label>
                                            <div style="width: 450px;">
                                                <input type="password" name="password" class="form-control" id="password" required>
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

                                        </div>
                                        <input type="submit" name="knopka" class="btn btn-primary" style="width: 450px;" value="Продовжити">
                                    </div>
                                </form>
                                <hr>
                                <div class="text-center">або</div>
                                <div class="d-flex flex-column align-items-center gap-2 mt-3">
                                    <a class="btn btn-outline-danger" href="{{route('login.google')}}" style="width: 250px;">Продовжити через Google</a>
                                </div>
                            </div>
                        </div>

                    <div class="d-flex align-items-center">
                        <hr class="flex-grow-1">
                        <span class="mx-3 text-muted fw-bold">АБО</span>
                        <hr class="flex-grow-1">
                    </div>

                    <div class="card">
                        <div class="card-header">Зареєструйтесь</div>
                        <div class="card-body">
                            <form action="{{route('registration.buyer')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">ПІБ</label>
                                    <input type="text" class="form-control @error('pib') is-invalid @enderror" required name="pib" value="{{old('pib')}}">
                                    @error('pib')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Номер телефону</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">+38</span>
                                        <input type="text" inputmode="numeric" pattern="0\d{9}" class="form-control @error('numberReg') is-invalid @enderror" placeholder="(050) 345-67-89" name="numberReg" value="{{old('numberReg')}}" required minlength="10" maxlength="10" title="Будь ласка, введіть номер у форматі 0XXXXXXXXX">
                                        @error('numberReg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('emailReg') is-invalid @enderror" name="emailReg" value="{{old('emailReg')}}" required>
                                    @error('emailReg')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Пароль</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="7" maxlength="50">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Повторіть пароль</label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required minlength="7" maxlength="50">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column align-items-center gap-2 mt-4">
                                    <!-- Основна кнопка -->
                                    <input type="submit" class="btn btn-primary" style="width: 300px;" name="knopka" value="Зареєструватися">

                                    <!-- Кнопка Google -->
                                    <a href="{{route('registration.google')}}" class="btn btn-outline-danger" style="width: 300px;">
                                        <i class="bi bi-google"></i> Реєстрація через Google
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endauth

                    <div class="card mb-4">
                        <div class="card-header fw-bold">Замовлення</div>
                        <div class="card-body">
                            @foreach(session('basket') as $index => $tmpSession)
                                <div class="d-flex align-items-center gap-3 py-2">
                                    <!-- Фото -->
                                    <div style="width: 80px; height: 80px; flex-shrink: 0;">
                                        <img src="{{ $tmpSession['photo'] }}" alt="Фото товару" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>

                                    <!-- Назва та кількість -->
                                    <div class="flex-grow-1">
                                        <div class="ms-5">
                                            <p class="mb-1 fw-bold">{{ $tmpSession['name'] }}</p>
                                            <small>Кількість: {{ $tmpSession['kolvo'] }}</small>
                                        </div>
                                    </div>

                                    <!-- Ціна -->
                                    <div class="text-end">
                                        <span class="fw-bold">{{ $tmpSession['price'] * $tmpSession['kolvo'] }} ₴ @if(session('promoCode')) <p class="text-danger">-{{session('promoCode')['discountValue']}}%</p>  @endif</span>
                                    </div>
                                </div>
                                    <hr class="my-2">
                            @endforeach
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#myModal">Редагувати товари</button>
                        </div>
                    </div>

                        @auth('buyers')
                            <div class="card mb-4">
                                <label for="order_comment" class="card-header form-label fw-bold">
                                    Коментар до замовлення (необов’язково)
                                </label>
                                <div class="card-body">
                                    <textarea name="koment" id="koment_input" class="form-control mb-3" rows="3" required minlength="5" maxlength="500" style="resize: vertical; max-height: 200px;" placeholder="Наприклад, зателефонуйте перед доставкою або інша важлива інформація...">{{old('koment') ?? ''}}</textarea>
                                </div>
                            </div>
                            <div class="delivery-group">
                                <div class="delivery-section-title"
                                     style="font-weight: bold; background: #f1f3f5; padding: 8px 14px; border-radius: 8px; display: inline-block;">
                                    🚚 Доставка:
                                </div>
                                <div class="delivery-option">
                                    <label class="custom-radio">
                                        <input type="radio" name="delivery_method" value="nova_post" id="novaPoshtaRadio">

                                        <span class="radio-title">
                                            Нова Пошта
                                        </span>

                                        @if(session('selectCity') && session('selectWarehouses'))
                                            <div class="selected-info">
                                                <div class="subtitle">Ваша адреса доставки</div>
                                                <div class="address">
                                                    {{ session('selectCity') }}, {{ session('selectWarehouses') }}
                                                </div>
                                            </div>

                                            <!-- Кнопка олівця -->
                                            <button type="button" id="editNovaPoshta" class="edit-btn" aria-label="Редагувати">✏️</button>
                                        @endif
                                    </label>

                                    <div id="deliveryBox" class="delivery-box">
                                        <div class="delivery-header">
                                            <strong>Оберіть місто та відділення</strong>
                                        </div>
                                        @error('errorNp')
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                        @if(session('errorNp'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>{{ session('errorNp') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endif
                                        <div class="delivery-content">

                                            <!-- МІСТО -->
                                            <div class="form-section">
                                                <label class="form-label">Населений пункт</label>
                                                <div class="fake-input" id="citySelector">@if(session('selectCity')) {{session('selectCity')}}@else Вкажіть населений пункт @endif</div>
                                                <div id="citySearchBox" class="search-box @if(session('openSearchCity') || $errors->has('searchCity')) expanded @endif">
                                                    <form action="{{route('novaPost.getCities')}}" method="post">
                                                        @csrf
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="searchCity" class="form-control @error('searchCity') is-invalid @enderror" id="cityInput" placeholder="Наприклад, Київ" value="{{old('searchCity')}}">
                                                            <input type="submit" class="btn btn-outline-secondary" value="Пошук">
                                                        </div>
                                                        @error('searchCity')
                                                        <div class="text-danger small mb-2"><strong>{{ $message }}</strong></div>
                                                        @enderror
                                                    </form>
                                                    <div class="scroll-box" id="cityList">
                                                        @if(session('searchCity'))
                                                            @foreach(session('searchCity') as $tmpRef=>$tmpCity)
                                                                <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                    @csrf
                                                                    <input type="hidden" name="cityRef" value="{{$tmpRef}}">
                                                                    <input class="select-option" type="submit" name="knopkaCity" value="{{$tmpCity}}">
                                                                </form>
                                                            @endforeach
                                                        @else
                                                            <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                @csrf
                                                                <input type="hidden" name="cityRef" value="8d5a980d-391c-11dd-90d9-001a92567626">
                                                                <input class="select-option" type="submit" name="knopkaCity" value="Київ">
                                                            </form>
                                                            <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                @csrf
                                                                <input type="hidden" name="cityRef" value="db5c88e0-391c-11dd-90d9-001a92567626">
                                                                <input class="select-option" type="submit" name="knopkaCity" value="Харків">
                                                            </form>
                                                            <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                @csrf
                                                                <input type="hidden" name="cityRef" value="db5c88d0-391c-11dd-90d9-001a92567626">
                                                                <input class="select-option" type="submit" name="knopkaCity" value="Одеса">
                                                            </form>
                                                            <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                @csrf
                                                                <input type="hidden" name="cityRef" value="db5c88f5-391c-11dd-90d9-001a92567626">
                                                                <input class="select-option" type="submit" name="knopkaCity" value="Львів">
                                                            </form>
                                                            <form action="{{route('novaPost.getWarehouses')}}" method="post" class="city-select-form">
                                                                @csrf
                                                                <input type="hidden" name="cityRef" value="db5c88e5-391c-11dd-90d9-001a92567626">
                                                                <input class="select-option" type="submit" name="knopkaCity" value="Суми">
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ВІДДІЛЕННЯ -->
                                            @if(session('warehouses'))
                                                <div class="form-section">
                                                    <label class="form-label">Відділення</label>
                                                    <div class="fake-input" id="branchSelector">@if(session('selectWarehouses')) {{session('selectWarehouses')}}@else Вкажіть відділення @endif</div>
                                                    <div id="branchSearchBox" class="search-box @if(session('openSearchWarehouses')) expanded @endif">
                                                        <form action="{{route('novaPost.searchWarehouses')}}" method="post">
                                                            @csrf
                                                            <div class="input-group mb-2">
                                                                <input type="text" name="searchWarehouses" class="form-control @if($errors->has('knopkaCity')) is-invalid @elseif ($errors->has('city')) is-invalid @elseif ($errors->has('searchWarehouses')) is-invalid @endif"
                                                                id="branchInput" placeholder="Наприклад, Відділення №1" value="{{old('searchWarehouses')}}">
                                                                <input type="submit" class="btn btn-outline-secondary" value="Пошук">
                                                            </div>
                                                            @if ($errors->has('knopkaCity'))
                                                                <div class="text-danger small mb-2"><strong>{{ $errors->first('knopkaCity') }}</strong></div>
                                                            @elseif ($errors->has('city'))
                                                                <div class="text-danger small mb-2"><strong>{{ $errors->first('cityNp') }}</strong></div>
                                                            @elseif ($errors->has('searchWarehouses'))
                                                                <div class="text-danger small mb-2"><strong>{{ $errors->first('searchWarehouses') }}</strong></div>
                                                            @endif
                                                        </form>
                                                        <div class="scroll-box" id="branchList">
                                                            @foreach(session('warehouses') as $tmpWarehouses)
                                                                <form action="@if($issetNovaPost) {{route('novaPost.updateAddress', ['idNovaPost'=>auth('buyers')->user()->idNovaPost])}} @else {{route('novaPost.addAddress')}} @endif" class="warehouse-select-form" method="post">
                                                                    @csrf
                                                                    @if($issetNovaPost) @method('PATCH') @endif
                                                                    <input type="hidden" name="warehouse" value="{{$tmpWarehouses}}">
                                                                    <input class="select-option" type="submit" name="knopkaWarehouses" value="{{$tmpWarehouses}}">
                                                                </form>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="delivery-option">
                                    <input type="radio" name="delivery_method" id="pickupRadio" value="pickup">
                                    <label for="pickupRadio">Самовивіз</label>
                                </div>

                                <div class="delivery-option">
                                    <label class="custom-radio" for="addressRadio">
                                        <input type="radio" name="delivery_method" id="addressRadio" value="courier_delivery">

                                        <span class="radio-title">
                                            Курєром за адресою доставки
                                        </span>

                                        @if($address)
                                            <div class="selected-info">
                                                <div class="subtitle">Ваша адреса доставки</div>
                                                <div class="address">
                                                    {{ $address->region }}, {{ $address->city }}, {{ $address->street }}, буд. {{ $address->houseNumber }}, кв. {{ $address->apartmentNumber }}
                                                </div>
                                            </div>

                                            <button type="button" id="editAddress" class="edit-btn" aria-label="Редагувати">✏️</button>
                                        @endif
                                    </label>

                                    <!-- Сама форма адреси -->
                                    <div class="card-body" id="address-form"
                                         @if($errors->has('region') || $errors->has('city') || $errors->has('street') || $errors->has('houseNumber') || $errors->has('apartmentNumber'))
                                             data-has-errors="true"
                                         @endif>
                                        <div class="delivery-form-title" style="margin: 10px 0;">
                                            <strong>Введіть адресу доставки</strong>
                                        </div>
                                        <form action="@if(!$address) {{route('add.deliveryAddress')}} @else {{route('update.deliveryAddress', ['idAddress'=>auth('buyers')->user()->idAddress])}} @endif" method="post">
                                            @csrf
                                            @if($address) @method('PATCH') @endif
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-4">
                                                    <label class="form-label">Область</label>
                                                    <input type="text" class="form-control @error('region') is-invalid @enderror" name="region" required minlength="2" maxlength="40" value="{{ old('region') ?? $address->region ?? ''}}">
                                                    @error('region')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Місто</label>
                                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" required minlength="2" maxlength="40" value="{{ old('city') ?? $address->city ?? ''}}">
                                                    @error('city')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Вулиця</label>
                                                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" required minlength="2" maxlength="45" value="{{ old('street') ?? $address->street ?? ''}}">
                                                    @error('street')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-3">
                                                <div class="col-md-2">
                                                    <label class="form-label">Номер Будинку</label>
                                                    <input type="number" class="form-control @error('houseNumber') is-invalid @enderror" id="house" name="houseNumber" min="1" max="999" required value="{{ old('houseNumber') ?? $address->houseNumber ?? ''}}">
                                                    @error('houseNumber')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Номер Квартири</label>
                                                    <input type="number" class="form-control @error('apartmentNumber') is-invalid @enderror" id="apartment" name="apartmentNumber" required min="1" max="999" value="{{ old('apartmentNumber') ?? $address->apartmentNumber ?? ''}}">
                                                    @error('apartmentNumber')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-start">
                                                <input type="submit" name="knopka" class="btn btn-primary" value="@if(!$address)Додати@elseРедагувати@endif">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Заголовок для способу оплати -->
                            <div class="payment-group delivery-group">
                                <div class="payment-section-title"
                                     style="font-weight: bold; background: #f1f3f5; padding: 8px 14px; border-radius: 8px; display: inline-block; margin: 21px 0 0 0;">
                                    💳 Спосіб оплати:
                                </div>
                                <div class="payment-option delivery-option">
                                    <input type="radio" name="payment_method" id="cashRadio" value="cash">
                                    <label for="cashRadio">Готівкою при отриманні</label>
                                </div>
                                <div class="payment-option delivery-option">
                                    <input type="radio" name="payment_method" id="cardRadio" value="liqPay">
                                    <label for="cardRadio">Онлайн карткою Приват Банк</label>
                                </div>
                                <div class="payment-option delivery-option">
                                    <input type="radio" name="payment_method" id="googlePayRadio" value="googlePay">
                                    <label for="googlePayRadio">Google Pay</label>
                                </div>
                            </div>
                        @endauth
                </div>
            </div>


            <!-- Права колонка: підсумок замовлення -->
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 20px;">
                    @auth('buyers')
                    @if(session('promoCode'))
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <strong class="mb-0">Промокоди</strong>
                                </div>
                                <div class="px-3 pb-3">
                                    <div class="d-flex align-items-center justify-content-between p-2 border border-primary rounded">
                                        <div class="text-primary d-flex align-items-center">
                                            <i class="bi bi-check-circle me-2"></i>
                                            <span class="fw-bold">{{ session('promoCode')['code'] }}</span>
                                        </div>
                                        <form action="{{ route('promo.remove') }}" method="post" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-danger p-0" title="Видалити промокод">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{route('promo.apply')}}" method="post">
                                @csrf
                                <div class="card mb-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <strong class="mb-0">Промокоди</strong>
                                        <div id="promoToggleButtons">
                                            <a id="togglePromoBtn" class="btn btn-link text-decoration-none text-primary p-0">
                                                <i class="bi bi-plus-lg me-1"></i>Додати
                                            </a>
                                            <a id="closePromoBtn" class="btn btn-link text-decoration-none text-primary p-0 d-none">
                                                Закрити
                                            </a>
                                        </div>
                                    </div>
                                    <div id="promoCodeForm" class="px-3 pb-3 d-none">
                                        <input type="text" name="promoCode" class="form-control mb-2 @error('promoCode') is-invalid @enderror" placeholder="Введіть промокод" required>
                                        @error('promoCode')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        <input type="submit" class="btn btn-primary w-100" value="Застосувати">
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endauth

                    <form id="orderForm" action="{{route('order.confirm')}}" method="post">
                        @csrf
                    <div class="card">
                        <div class="card-header">Разом</div>
                        <div class="card-body">
                            <p>@if($kolvoBasket==1)1 товар @elseif($kolvoBasket<5){{$kolvoBasket}} товари @else {{$kolvoBasket}} товарів @endif на суму: <span class="fw-bold">{{session('totalCost')}} ₴</span></p>
                            <p>Доставка: <span class="text-muted">за тарифами перевізника</span></p>
                            @if(session('promoCode')) <p class="text-danger">Промокод одноразовий і після оплати замовлення ви більше не зможете використати його знову!</p> @endif
                            <hr>
                            <p class="fw-bold fs-5">
                                До сплати: <span id="totalPrice">{{ session('totalCost') }}</span> ₴
                            </p>
                            <input type="hidden" name="selected_delivery" id="selected_delivery" required>
                            <input type="hidden" name="selected_payment" id="selected_payment" required>
                            <input type="hidden" name="koment" id="koment">
                            <input type="submit" class="btn btn-primary w-100" value="Підтвердити замовлення" name="orderConfirm">
                            <small class="d-block mt-2 text-muted">Натискаючи, ви приймаєте умови обробки персональних даних і угоди користувача.</small>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

