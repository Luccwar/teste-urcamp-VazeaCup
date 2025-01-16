@extends('master')

@section('content')

<div class="form-container">
    <h2 class="form-title">Criar Time</h2>

    @if (session()->has('message'))
        <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    <form action="{{ route('teams.store') }}" method="post" id="createTeamForm" class="user-form" onsubmit="return validateTeamForm()">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" id="name" name="name" placeholder="Insira o nome do time" class="form-input" required 
                minlength="2" maxlength="255">
            <small class="form-error" id="name-error"></small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="form-button">Enviar</button>
            <a href="{{ route('teams.index') }}" class="back-button">Voltar</a>
        </div>
    </form>
</div>

<script>
function validateTeamForm() {
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
