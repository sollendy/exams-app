<x-app-layout>
    <div class="mx-auto w-75 my-4">
        <form action="{{ url('/user-dashboard') }}" method="GET">
            <div class="row text-center">
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="Cerca per titolo">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">Filtra</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/user-dashboard') }}" class="btn btn-secondary rounded-pill">Azzera filtri</a>
                </div>
            </div>
        </form>
    </div>

    <div>
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    @if (Auth::user()->role == 'user')
                        {{ __('Sfoglia i tuoi esami!') }}
                        @if ($esamiUtente->isNotEmpty())
                            <table class="table table-bordered table-hover table-striped mb-4 text-center fs-5">
                                <thead class="text-uppercase">
                                    <tr class="align-middle">
                                        <th>Materia</th>
                                        <th>Data Esame</th>
                                        <th>Voto Assegnato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($esamiUtente as $esame)
                                        <tr class="align-middle">
                                            <td class="text-uppercase">{{ $esame->title }}</td>
                                            <td class="fst-italic">{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                            <td class="py-3">{{ $esame->pivot->vote ?? 'Non assegnato' }}</td>
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
