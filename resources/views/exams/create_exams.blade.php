{{-- @extends('layouts.app')

@section('content') --}}
<x-app-layout>
    <div class="container">
        <h2 class="mt-4">Crea un Nuovo Esame</h2>
        @if ($errors->has('exam_exists'))
            <div class="alert alert-danger">
                {{ $errors->first('exam_exists') }}
            </div>
        @endif
        <form action="{{ route('exam.create') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Titolo Esame</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="exam_date">Data Esame</label>
                <input type="date" name="exam_date" id="exam_date" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="user_id">Seleziona Studente</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">Seleziona uno studente</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->id }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-dark mt-3">Crea Esame</button>
        </form>
    </div>
</x-app-layout>
{{-- @endsection --}}
