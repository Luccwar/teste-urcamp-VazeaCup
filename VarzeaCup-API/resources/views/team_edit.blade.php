@extends('master')

@section('content')

<div class="form-container">
    <h2 class="form-title">Editar Time</h2>

    @if (session()->has('message'))
        <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    <form action="{{ route('teams.update', ['team' => $team->id]) }}" method="post" id="editTeamForm" class="team-form" onsubmit="return validateForm()">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="form-group">
            <label for="id" class="form-label">ID:</label>
            <input type="text" id="id" name="id" value="{{ $team->id }}" class="form-input" disabled>
        </div>

        <div class="form-group">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" id="name" name="name" value="{{ $team->name }}" class="form-input" required
                minlength="2" maxlength="255">
            <small class="form-error" id="name-error"></small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="form-button">Salvar Alterações</button>
            <a href="{{ route('teams.index') }}" class="back-button">Voltar</a>
        </div>
    </form>
</div>

<script>
function validateForm() {
    let isValid = true;

    // Validar Nome
    const name = document.getElementById('name');
    const nameError = document.getElementById('name-error');
    const namePattern = /^[a-zA-ZÀ-ÿ\s]+$/; // Permitindo apenas letras e espaços
    if (name.value.trim().length < 2 || name.value.trim().length > 255 || !namePattern.test(name.value)) {
        nameError.textContent = 'O nome deve ter entre 2 e 255 caracteres e conter apenas letras e espaços.';
        isValid = false;
    } else {
        nameError.textContent = '';
    }

    return isValid;
}
</script>

@endsection
