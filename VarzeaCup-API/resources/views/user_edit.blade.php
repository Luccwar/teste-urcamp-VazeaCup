@extends('master')

@section('content')

<div class="form-container">
    <h2 class="form-title">Editar Usuário</h2>

    @if (session()->has('message'))
        <p class="form-message">{{ session()->get('message') }}</p>
    @endif

    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post" id="editUserForm" class="user-form" onsubmit="return validateForm()">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="form-group">
            <label for="id" class="form-label">ID:</label>
            <input type="text" id="id" name="id" value="{{ $user->id }}" class="form-input" disabled>
        </div>

        <div class="form-group">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-input" required
                minlength="2" maxlength="255">
            <small class="form-error" id="name-error"></small>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-input" required>
            <small class="form-error" id="email-error"></small>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Senha: (Mínimo de 6 caracteres)</label>
            <input type="password" id="password" name="password" placeholder="Nova senha aqui" class="form-input" minlength="6" required>
            <small class="form-error" id="password-error"></small>
        </div>

        <div class="form-buttons">
            <button type="submit" class="form-button">Salvar Alterações</button>
            <a href="{{ route('users.index') }}" class="back-button">Voltar</a>
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

    // Validar Email
    const email = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email.value)) {
        emailError.textContent = 'Insira um email válido. Exemplo@dominio.extensao';
        isValid = false;
    } else {
        emailError.textContent = '';
    }

    // Validar Senha
    const password = document.getElementById('password');
    const passwordError = document.getElementById('password-error');
    if (password.value.trim().length < 6 && password.value.trim().length > 0) {
        passwordError.textContent = 'A senha deve ter no mínimo 6 caracteres.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

    return isValid;
}
</script>

@endsection
