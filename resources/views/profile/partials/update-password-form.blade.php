<section>
    <header>
        <h2 class="h4 font-medium text-dark">
            {{ __('Aggiorna password') }}
        </h2>

        <p class="mt-2 text-muted">
            {{ __('Usa una password abbastanza complessa, per sicurezza.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Password attuale') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password" />
            @if ($errors->updatePassword->has('current_password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Nuova Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password" />
            @if ($errors->updatePassword->has('password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('COnferma Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger mt-2">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-secondary">{{ __('Conferma') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-muted mb-0" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    {{ __('Salvato.') }}
                </p>
            @endif
        </div>
    </form>
</section>
