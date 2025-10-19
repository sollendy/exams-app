<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark">
            {{-- {{ __('Dashboard') }} --}}
            @if (Auth::user()->role == 'user')
                I tuoi esami a portata di clic
            @else
                Lista esami
            @endif
        </h2>
    </x-slot>

    <div class="mx-auto w-75 my-4">
        <form action="{{ url('/dashboard') }}" method="GET">
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


    @if (Auth::user()->role == 'admin')
        <div class="container pb-1">
            <a href="{{ route('exam.create.form') }}" class="btn btn-secondary">
                &#10010; Aggiungi Esame
            </a>
        </div>
    @endif

    <div>
        <div class="container">
            @if (Auth::user()->role == 'user')
                <a class="btn btn-secondary mb-1" href="{{ url('/user-dashboard') }}">Sfoglia i tuoi esami!</a>
            @endif
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    @if (Auth::user()->role == 'user')
                        @if ($esamiDashboard->isNotEmpty())
                            <table class="table table-bordered table-hover table-striped mb-4">
                                <thead>
                                    <tr>
                                        <th>Materia</th>
                                        <th>Data Esame</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($esamiDashboard as $esame)
                                        @php
                                            $isAlreadyBooked = auth()
                                                ->user()
                                                ->exams()
                                                ->where('exam_id', $esame->id)
                                                ->exists();
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $esame->title }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                            <td>
                                                @if (!$isAlreadyBooked)
                                                    <form
                                                        action="{{ route('exam.book', ['examId' => $esame->id, 'userId' => auth()->user()->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary">Prenota
                                                            Esame</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Prenotato</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">Non ci sono esami disponibili al momento.</p>
                        @endif
                    @else
                        {{ __('Elenco esami utenti') }}
                        @if ($esamiDashboard->isNotEmpty())
                            @if (Auth::user()->role == 'supervisor')
                                <table class="table table-bordered table-hover table-striped mb-4">
                                    <thead>
                                        <tr>
                                            <th>Materia</th>
                                            <th>Data Esame</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($esamiDashboard as $esame)
                                            <tr>
                                                <td><strong>{{ $esame->title }}</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                                <td><a class="link-dark"
                                                        href="{{ route('exam.users', ['examId' => $esame->id]) }}">Utenti
                                                        Iscritti</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table class="table table-bordered table-hover table-striped mb-4">
                                    <thead>
                                        <tr>
                                            <th>Titolo Esame</th>
                                            <th>Data Esame</th>
                                            <th>Data Creazione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($esamiDashboard as $esame)
                                            <tr>
                                                <td><strong>{{ $esame->title }}</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $esame->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <p class="text-muted">Non ci sono esami disponibili al momento.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
