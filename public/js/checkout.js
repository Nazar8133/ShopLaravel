(function () {
    'use strict';

    const config = window.checkoutConfig || {};
    const errors = config.errors || {};
    const storage = window.sessionStorage;

    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
    const byId = (id) => document.getElementById(id);
    const hasErrorNp = () => Boolean(errors.errorNp || errors.searchCity || errors.searchWarehouses);
    const setOpenDeliveryBox = () => storage.setItem('openDeliveryBox', 'true');
    const toggleClass = (element, className, force) => element?.classList.toggle(className, force);
    const show = (element) => element?.classList.remove('d-none');
    const hide = (element) => element?.classList.add('d-none');

    document.addEventListener('DOMContentLoaded', initCheckout);

    function initCheckout() {
        rememberScrollAfterFormSubmit();
        initNovaPostDelivery();
        initAddressForm();
        initExclusiveAddressInputs();
        initToggleForms();
        initBuyerEditForm();
        initPromoCodeState();
        bindRadioValue('input[name="delivery_method"]', byId('selected_delivery'));
        bindRadioValue('input[name="payment_method"]', byId('selected_payment'));
        bindTextareaValue(byId('koment_input'), byId('koment'));
        initGooglePaySubmit();
    }

    function rememberScrollAfterFormSubmit() {
        window.addEventListener('beforeunload', () => {
            if (storage.getItem('formSubmitted') === 'true') {
                storage.setItem('scrollPosition', String(window.scrollY));
                return;
            }

            storage.removeItem('scrollPosition');
        });

        $$('form').forEach((form) => {
            form.addEventListener('submit', () => storage.setItem('formSubmitted', 'true'));
        });

        window.addEventListener('load', () => {
            if (storage.getItem('formSubmitted') !== 'true') {
                return;
            }

            const scrollY = storage.getItem('scrollPosition');
            if (scrollY !== null) {
                window.scrollTo(0, Number.parseInt(scrollY, 10));
            }

            storage.removeItem('formSubmitted');
        });

        $$('a').forEach((link) => {
            link.addEventListener('click', () => storage.removeItem('scrollPosition'));
        });
    }

    function initNovaPostDelivery() {
        const deliveryBox = byId('deliveryBox');
        const citySelector = byId('citySelector');
        const citySearchBox = byId('citySearchBox');
        const branchSelector = byId('branchSelector');
        const branchSearchBox = byId('branchSearchBox');
        const deliveryRadios = $$('input[name="delivery_method"]');

        if (hasErrorNp() && !storage.getItem('selectedDelivery')) {
            storage.setItem('selectedDelivery', 'novaPoshtaRadio');
        }

        restoreSelectedDelivery(deliveryBox);
        restoreNovaSearchState(deliveryBox, citySearchBox, branchSearchBox);

        $$('.city-option, .branch-option').forEach((item) => {
            item.addEventListener('click', setOpenDeliveryBox);
        });

        deliveryRadios.forEach((radio) => {
            radio.addEventListener('change', () => {
                storage.setItem('selectedDelivery', radio.id);
                updateNovaBoxVisibility(radio.id, deliveryBox);
                collapseSearchBoxes(citySearchBox, branchSearchBox);
            });
        });

        byId('editNovaPoshta')?.addEventListener('click', (event) => {
            event.preventDefault();
            deliveryBox?.classList.toggle('expanded');
        });

        bindSearchBoxToggle(citySelector, citySearchBox, branchSearchBox, 'city');
        bindSearchBoxToggle(branchSelector, branchSearchBox, citySearchBox, 'branch');

        setTimeout(() => storage.removeItem('openDeliveryBox'), 1000);
    }

    function restoreSelectedDelivery(deliveryBox) {
        const savedDelivery = storage.getItem('selectedDelivery');
        if (!savedDelivery) {
            return;
        }

        const selectedRadio = byId(savedDelivery);
        if (!selectedRadio) {
            return;
        }

        selectedRadio.checked = true;

        if (savedDelivery === 'novaPoshtaRadio') {
            updateNovaBoxVisibility(savedDelivery, deliveryBox);
        }
    }

    function restoreNovaSearchState(deliveryBox, citySearchBox, branchSearchBox) {
        if (storage.getItem('openDeliveryBox') === 'true' || hasErrorNp()) {
            deliveryBox?.classList.add('expanded');
        }

        if (errors.searchCity) {
            expandOnly(citySearchBox, branchSearchBox);
            setOpenDeliveryBox();
        } else if (errors.searchWarehouses) {
            expandOnly(branchSearchBox, citySearchBox);
            setOpenDeliveryBox();
        } else if (errors.errorNp) {
            const lastOpen = storage.getItem('lastSearchBox');
            toggleClass(citySearchBox, 'expanded', lastOpen === 'city');
            toggleClass(branchSearchBox, 'expanded', lastOpen === 'branch');
            setOpenDeliveryBox();
        }

        if (citySearchBox?.classList.contains('expanded') || branchSearchBox?.classList.contains('expanded')) {
            deliveryBox?.classList.add('expanded');
        }
    }

    function bindSearchBoxToggle(trigger, targetBox, otherBox, name) {
        trigger?.addEventListener('click', (event) => {
            event.preventDefault();
            storage.setItem('lastSearchBox', name);
            setOpenDeliveryBox();
            targetBox?.classList.toggle('expanded');
            otherBox?.classList.remove('expanded');
        });
    }

    function updateNovaBoxVisibility(selectedDeliveryId, deliveryBox) {
        const shouldOpen = selectedDeliveryId === 'novaPoshtaRadio' && !isNovaCompleted();
        toggleClass(deliveryBox, 'expanded', shouldOpen);
    }

    function isNovaCompleted() {
        const city = String(config.novaPost?.city || '').trim();
        const warehouse = String(config.novaPost?.warehouse || '').trim();
        return city !== '' && warehouse !== '';
    }

    function collapseSearchBoxes(...boxes) {
        boxes.forEach((box) => box?.classList.remove('expanded'));
    }

    function expandOnly(targetBox, otherBox) {
        targetBox?.classList.add('expanded');
        otherBox?.classList.remove('expanded');
    }

    function initAddressForm() {
        const addressRadio = byId('addressRadio');
        const addressForm = byId('address-form');
        if (!addressRadio || !addressForm) {
            return;
        }

        const hasAddress = Boolean(addressRadio.closest('.delivery-option')?.querySelector('.selected-info'));
        const setAddressFormVisible = (visible) => toggleClass(addressForm, 'address-form--visible', visible);

        setAddressFormVisible(!hasAddress && addressRadio.checked);

        $$('input[name="delivery_method"]').forEach((option) => {
            option.addEventListener('change', () => {
                if (!hasAddress) {
                    setAddressFormVisible(option === addressRadio && addressRadio.checked);
                }
            });
        });

        byId('editAddress')?.addEventListener('click', (event) => {
            event.preventDefault();
            addressForm.classList.toggle('address-form--visible');
        });
    }

    function initExclusiveAddressInputs() {
        const house = byId('house');
        const apartment = byId('apartment');
        if (!house || !apartment) {
            return;
        }

        const valueOf = (input) => String(input.value || '').trim();
        const refreshLocks = () => {
            const hasHouse = valueOf(house) !== '';
            const hasApartment = valueOf(apartment) !== '';
            apartment.disabled = hasHouse && !hasApartment;
            house.disabled = hasApartment && !hasHouse;
        };

        const bindExclusiveInput = (active, passive) => {
            active.addEventListener('input', () => {
                if (valueOf(active) !== '') {
                    passive.value = '';
                    passive.disabled = true;
                    return;
                }

                if (valueOf(passive) === '') {
                    passive.disabled = false;
                }
            });
        };

        bindExclusiveInput(house, apartment);
        bindExclusiveInput(apartment, house);
        refreshLocks();
    }

    function initToggleForms() {
        bindToggleForm('togglePromoBtn', 'closePromoBtn', 'promoCodeForm');
        bindToggleForm('toggleContactBtn', 'collapseContactBtn', 'contactForm', 'userFullName');
    }

    function bindToggleForm(showBtnId, hideBtnId, formId, extraHideId = null, extraShowId = null) {
        const showBtn = byId(showBtnId);
        const hideBtn = byId(hideBtnId);
        const form = byId(formId);
        const extraHide = extraHideId ? byId(extraHideId) : null;
        const extraShow = extraShowId ? byId(extraShowId) : null;

        showBtn?.addEventListener('click', (event) => {
            event.preventDefault();
            show(form);
            hide(showBtn);
            show(hideBtn);
            hide(extraHide);
        });

        hideBtn?.addEventListener('click', (event) => {
            event.preventDefault();
            hide(form);
            show(showBtn);
            hide(hideBtn);
            show(extraHide);
            show(extraShow);
        });
    }

    function initBuyerEditForm() {
        const editBtn = byId('toggle-edit-btn');
        const editForm = byId('edit-user-form');
        if (!editBtn || !editForm) {
            return;
        }

        const setOpen = (open) => {
            toggleClass(editForm, 'd-none', !open);
            editBtn.textContent = open ? 'Закрити' : 'Змінити';
            editBtn.classList.toggle('btn-outline-danger', open);
            editBtn.classList.toggle('btn-outline-primary', !open);
        };

        editBtn.addEventListener('click', () => setOpen(editForm.classList.contains('d-none')));

        if (editForm.dataset.hasErrors === 'true') {
            setOpen(true);
        }
    }

    function initPromoCodeState() {
        const promoForm = byId('promoCodeForm');
        const toggleBtn = byId('togglePromoBtn');
        const closeBtn = byId('closePromoBtn');

        if (config.hasPromoCode) {
            hide(promoForm);
            hide(toggleBtn);
            hide(closeBtn);
        }

        if (errors.promoCode) {
            show(promoForm);
            hide(toggleBtn);
            show(closeBtn);
        }
    }

    function bindRadioValue(selector, hiddenInput) {
        if (!hiddenInput) {
            return;
        }

        $$(selector).forEach((radio) => {
            radio.addEventListener('change', () => {
                hiddenInput.value = radio.value;
            });

            if (radio.checked) {
                hiddenInput.value = radio.value;
            }
        });
    }

    function bindTextareaValue(textarea, hiddenInput) {
        if (!textarea || !hiddenInput) {
            return;
        }

        const sync = () => {
            hiddenInput.value = textarea.value;
        };

        textarea.addEventListener('input', sync);
        sync();
    }

    function initGooglePaySubmit() {
        const form = byId('orderForm');
        if (!form) {
            return;
        }

        form.addEventListener('submit', (event) => {
            const selectedPayment = $('input[name="payment_method"]:checked');
            if (selectedPayment?.value !== 'googlePay') {
                return;
            }

            event.preventDefault();

            if (!window.google?.payments?.api) {
                console.error('Google Pay API is not loaded.');
                return;
            }

            getGooglePaymentsClient()
                .loadPaymentData(getGooglePaymentDataRequest())
                .then((paymentData) => {
                    console.log('Google Pay Response:', paymentData);
                    appendHiddenInput(form, 'googlePayToken', paymentData.paymentMethodData.tokenizationData.token);
                    form.submit();
                })
                .catch((error) => console.error('Google Pay Error:', error));
        });
    }

    let paymentsClient = null;

    function getGooglePaymentsClient() {
        if (paymentsClient === null) {
            paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' });
        }

        return paymentsClient;
    }

    function getGooglePaymentDataRequest() {
        return {
            apiVersion: 2,
            apiVersionMinor: 0,
            allowedPaymentMethods: [{
                type: 'CARD',
                parameters: {
                    allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                    allowedCardNetworks: ['VISA', 'MASTERCARD'],
                },
                tokenizationSpecification: {
                    type: 'PAYMENT_GATEWAY',
                    parameters: {
                        gateway: 'example',
                        gatewayMerchantId: 'exampleMerchantId',
                    },
                },
            }],
            transactionInfo: {
                countryCode: 'UA',
                currencyCode: 'UAH',
                totalPriceStatus: 'FINAL',
                totalPrice: byId('totalPrice')?.innerText || '0',
            },
            merchantInfo: {
                merchantName: 'Demo Merchant',
            },
        };
    }

    function appendHiddenInput(form, name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
})();
