@extends('master')

@section('content')

    <div class="form-container">
        <h2 class="form-title">Login</h2>

        @if (session()->has('message'))
            <p class="form-message">{{ session()->get('message') }}</p>
        @endif

        <form action="{{ route('login') }}" method="post" id="loginForm" class="user-form" onsubmit="return validateLoginForm()">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" placeholder="Insira o email" class="form-input" required>
                <small class="form-error" id="email-error"></small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Insira a senha" class="form-input" required minlength="6">
                <small class="form-error" id="password-error"></small>
            </div>

            <div class="form-buttons">
                <button type="submit" class="form-button">Entrar</button>
            </div>
        </form>
    </div>

    <script>
    function validateLoginForm() {
        let isValid = true;

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
        if (password.value.trim().length < 6) {
            passwordError.textContent = 'A senha deve ter no mínimo 6 caracteres.';
            isValid = false;
        } else {
            passwordError.textContent = '';
        }

        return isValid;
    }
    </script>

@endsection
