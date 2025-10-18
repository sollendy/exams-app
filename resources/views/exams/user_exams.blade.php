<x-app-layout>
    <div class="mx-auto w-75 my-4">
        <form action="{{ url('/user-dashboard') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="Cerca per titolo">
                </div>
                <div class="col-md-4">
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark w-100">Filtra</button>
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
                            <table class="table table-bordered table-hover table-striped mb-4">
                                <thead>
                                    <tr>
                                        <th>Materia</th>
                                        <th>Data Esame</th>
                                        <th>Voto Assegnato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($esamiUtente as $esame)
                                        <tr>
                                            <td><strong>{{ $esame->title }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                            <td>{{ $esame->pivot->vote ?? 'Non assegnato' }}</td>
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
