<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-dark font-weight-semibold">
            {{ __('Modifica profilo') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-sm space-y-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
