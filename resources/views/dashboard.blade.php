<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark">
            {{-- {{ __('Dashboard') }} --}}
            @if (Auth::user()->role == 'user')
                Il tuo sommario esami
            @else
                Lista esami
            @endif
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    {{ __("You're logged in!") }}
                    @if (Auth::user()->role == 'user')
                        @if ($esamiUtente->isNotEmpty())
                            <table class="table table-bordered table-hover table-striped mb-4">
                                <thead>
                                    <tr>
                                        <th>Titolo Esame</th>
                                        <th>Data Esame</th>
                                        <th>Voto Assegnato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($esamiUtente as $esame)
                                        <tr>
                                            <td><strong>{{ $esame->title }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                            <td>{{ $esame->vote }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">Non ci sono esami disponibili al momento.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
