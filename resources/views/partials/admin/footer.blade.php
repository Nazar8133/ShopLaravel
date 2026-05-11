<footer class="text-center text-lg-start bg-body-tertiary text-muted mt-auto">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Адміністративна панель магазину годинників</span>
        </div>

        <div>
            <a href="https://facebook.com/watchshop.ua" class="me-4 text-reset" target="_blank" rel="noopener">Facebook</a>
            <a href="https://instagram.com/watchshop.ua" class="me-4 text-reset" target="_blank" rel="noopener">Instagram</a>
            <a href="https://t.me/watchshop_admin" class="me-4 text-reset" target="_blank" rel="noopener">Telegram</a>
            <a href="mailto:support@watchshop.test" class="me-4 text-reset">Підтримка</a>
        </div>
    </section>

    <section>
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Адмін-панель WatchShop</h6>
                    <p>
                        Внутрішня частина магазину для керування товарами, брендами, промокодами,
                        замовленнями та довідниками каталогу.
                    </p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Розділи</h6>
                    <p><a href="{{ route('admin.index') }}" class="text-reset">Головна</a></p>
                    <p><a href="{{ route('watch.index') }}" class="text-reset">Годинники</a></p>
                    <p><a href="{{ route('order.index') }}" class="text-reset">Замовлення</a></p>
                    <p><a href="{{ route('promoCode.index') }}" class="text-reset">Промокоди</a></p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Довідники</h6>
                    <p><a href="{{ route('brend.index') }}" class="text-reset">Бренди</a></p>
                    <p><a href="{{ route('mechanism.index') }}" class="text-reset">Типи годинників</a></p>
                    <p><a href="{{ route('style.index') }}" class="text-reset">Стилі</a></p>
                    <p><a href="{{ route('register.show') }}" class="text-reset">Працівники</a></p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Контакти офісу</h6>
                    <p>Україна, м. Київ, вул. Хрещатик, 22, офіс 304</p>
                    <p>Email: admin@watchshop.test</p>
                    <p>Служба підтримки: +38 (044) 555-12-34</p>
                    <p>Відділ замовлень: +38 (067) 555-43-21</p>
                    <p>Графік: Пн-Пт 09:00-18:00</p>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center p-4 footer-copyright">
        © 2025 Адмін-панель Магазину годинників.
        <a class="text-reset fw-bold" href="{{ route('admin.index') }}">admin.watchshop.test</a>
    </div>
</footer>
