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
                                            Запам'ятати мене
                                        </label>
                                    </div>
                                    <div>
                                        <a href="{{route('buyers.password.request')}}" class="btn btn-link text-decoration-none text-primary p-0">Забули пароль?</a>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">Увійти</button>
                            <a href="{{route('login.google')}}" class="btn btn-outline-danger w-100">
                                <i class="bi bi-google me-2"></i> Увійти через Google аккаунт
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
