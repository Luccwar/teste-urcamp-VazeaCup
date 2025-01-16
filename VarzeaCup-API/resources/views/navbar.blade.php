<nav class="navbar">
    <div class="navbar-container">
        <!-- Nome do Site -->
        <a href="{{ url('/') }}" class="navbar-brand">Varzea Cup</a>

        <!-- Links da Navbar -->
        <div class="navbar-links">
            @guest
                <!-- Link para Login (usuário não autenticado) -->
                <a href="{{ route('login') }}" class="navbar-link">Login</a>
            @else
                <!-- Links para usuários autenticados -->
                <a href="{{ url('/') }}" class="navbar-link @if(request()->is('/')) active @endif"">Campeonato</a>
                <span class="navbar-separator">|</span>
                <a href="{{ url('/users') }}" class="navbar-link @if(request()->is('users*')) active @endif"">Usuários</a>
                <span class="navbar-separator">|</span>
                <a href="{{ url('/teams') }}" class="navbar-link @if(request()->is('teams*')) active @endif"">Times</a>
                <span class="navbar-separator">|</span>
                <a href="{{ url('/games') }}" class="navbar-link @if(request()->is('games*')) active @endif"">Jogos</a>
                <span class="navbar-separator">|</span>

                <!-- Link para Logout -->
                <form action="{{ route('logout') }}" method="POST" class="navbar-form">
                    @csrf
                    <button type="submit" class="navbar-logout">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
