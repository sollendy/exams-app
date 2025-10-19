<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark">
            @if (Auth::user()->role == 'user')
                I tuoi esami a portata di clic
            @else
                Lista esami
            @endif
        </h2>
    </x-slot>

    <div class="mx-auto w-75 my-4">
        <form action="{{ url('/dashboard') }}" method="GET">
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
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary rounded-pill">Azzera filtri</a>
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
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    @if (Auth::user()->role == 'user')
                        @if ($esamiDashboard->isNotEmpty())
                            <table class="table table-bordered table-hover table-striped mb-4 text-center fs-5">
                                <thead class="text-uppercase">
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
                                        <tr class="align-middle">
                                            <td class="text-uppercase">{{ $esame->title }}</td>
                                            <td class="fst-italic">
                                                {{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}</td>
                                            <td class="py-3">
                                                @if (!$isAlreadyBooked)
                                                    <form
                                                        action="{{ route('exam.book', ['examId' => $esame->id, 'userId' => auth()->user()->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="border-1 border-top-0 border-end-0 border-start-0 bg-transparent">Prenota
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
                                <table class="table table-bordered table-hover table-striped mb-4 text-center fs-5">
                                    <thead class="text-uppercase">
                                        <tr class="align-middle">
                                            <th>Materia</th>
                                            <th>Data Esame</th>
                                            <th>Utenti Prenotati</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($esamiDashboard as $esame)
                                            <tr class="align-middle">
                                                <td class="text-uppercase align-middle">{{ $esame->title }}</td>
                                                <td class="fst-italic">
                                                    {{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $esame->users_count ?? 0 }}</td>
                                                <td class="py-3"><a class="link-dark"
                                                        href="{{ route('exam.users', ['examId' => $esame->id]) }}">Utenti
                                                        Iscritti</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table class="table table-bordered table-hover table-striped mb-4 text-center fs-5">
                                    <thead class="text-uppercase">
                                        <tr class="align-middle">
                                            <th>Titolo Esame</th>
                                            <th>Data Esame</th>
                                            <th>Data Creazione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($esamiDashboard as $esame)
                                            <tr>
                                                <td class="text-uppercase align-middle">{{ $esame->title }}</td>
                                                <td class="fst-italic py-3">
                                                    {{ \Carbon\Carbon::parse($esame->exam_date)->format('d/m/Y') }}
                                                </td>
                                                <td class="align-middle">{{ $esame->created_at }}</td>
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
