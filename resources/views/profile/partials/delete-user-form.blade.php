<section class="mb-4">
    <header>
        <h2 class="h4 fw-medium text-dark">
            {{ __('Elimina Account') }}
        </h2>

        <p class="mt-2 text-muted">
            {{ __('Una volta eliminato il tuo profilo, tutte le risorse e i dati in esso contenuti saranno cancellati in modo definitivo.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-danger">{{ __('Cancella Profilo') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="h4 fw-medium text-dark">
                {{ __('Sicuro di voler eliminare il tuo profilo?') }}
            </h2>

            <p class="mt-2 text-muted">
                {{ __('Una volta eliminato il tuo profilo, tutte le risorse e i dati in esso contenuti saranno cancellati in modo permanente. Inserisci la tua password per confermare che desideri eliminare definitivamente il tuo profilo.') }}
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="visually-hidden" />

                <x-text-input id="password" name="password" type="password" class="form-control mt-2 w-75"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="btn btn-secondary">
                    {{ __('Annulla') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 btn btn-danger">
                    {{ __('Conferma Eliminazione') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
