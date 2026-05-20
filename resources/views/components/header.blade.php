<header class="bg-white border-bottom border-2 flex items-center justify-between p-2">
    {{--LOGO--}}
    <div>
        logo
    </div>

    {{--GitHub--}}

    <div>
        github

        @auth
            <!-- Caso o usuário esteja autenticado exibe a opção de logout. -->
            <form  class="inline" action="{{ route('site.logout') }}" method="POST" >
                @csrf
                <button type="submit" class="bg-white p-2 border-2">
                    Sair
                </button>
            </form>
        @endauth

        @guest
            <!-- Caso o usuário não esteja autenticado, exibe o login. -->
        <a href="{{ route('login') }}" class="bg-white p-2 border-2">
                Login
            </a>
        @endguest
    </div>
</header>
