<section>
    <header>
        <h2 class="h4 font-medium text-dark">
            {{ __('Informazioni sul profilo') }}
        </h2>

        <p class="mt-2 text-muted">
            {{ __("Aggiorna le informazioni del tuo profilo e l'indirizzo email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if ($errors->has('name'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('name') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if ($errors->has('email'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('email') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Il tuo indirizzo email non è ancora verificato.') }}

                        <button form="send-verification" class="btn btn-link p-0">
                            {{ __('Clicca qui per inviare nuovamente l\'email di verifica.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('Un nuovo link di verifica è stato inviato al tuo indirizzo email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-secondary">{{ __('Salva') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="text-muted mb-0" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    {{ __('Salvato.') }}
                </p>
            @endif
        </div>
    </form>
</section>
