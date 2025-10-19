<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark">
            Utenti iscritti all'esame di: {{ $exam->title }} del {{ \Carbon\Carbon::parse($exam->exam_date)->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Lista degli utenti che partecipano all'esame</h5>

                @if ($users->isNotEmpty())
                    <table class="table table-bordered table-striped table-hover text-center fs-5">
                        <thead class="text-uppercase">
                            <tr class="align-middle">
                                <th>Nome Utente</th>
                                <th>Email</th>
                                <th>Voto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="align-middle">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="py-3">
                                        <form
                                            action="{{ route('exam.assign.vote', ['userId' => $user->id, 'examId' => $exam->id]) }}"
                                            class="d-flex" method="POST">
                                            @csrf
                                            @method('PUT')

                                            @if ($user->pivot->vote)
                                                <span class="mx-auto">{{ $user->pivot->vote }}</span>
                                            @else
                                                <input type="number" name="vote" class="form-control"
                                                    placeholder="Voto" min="18" max="30" required>
                                                <button type="submit" class="btn btn-secondary ms-1 text-nowrap">Assegna Voto</button>
                                            @endif
                                        </form>
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
                    <p class="text-muted">Non ci sono utenti associati a questo esame.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
