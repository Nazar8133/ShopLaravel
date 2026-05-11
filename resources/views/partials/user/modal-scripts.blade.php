@if($errors->errorKolvo->any() || session('open_modal'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const basketModal = new bootstrap.Modal(document.getElementById('myModal'));
            basketModal.show();
        });
    </script>
@endif

@if(!$isCheckoutPage && ($errors->has('email') || $errors->has('emailReg') || $errors->has('password')))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const authModal = new bootstrap.Modal(document.getElementById('authModal'));
            authModal.show();

            @if($errors->has('emailReg') || $errors->has('password'))
                document.querySelector('#register-tab').click();
            @endif
        });
    </script>
@endif
