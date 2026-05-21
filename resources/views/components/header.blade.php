<header class="bg-white border-bottom border-2 flex items-center justify-between p-2">
    {{--LOGO--}}
  <a href="{{ route('habits.index') }}" class="habit-btn habit-shadow-lg px-2 py-1 bg-habit-orange">
    HT
  </a>

    {{--GitHub--}}

    <div>
        @auth
            <!-- Caso o usuário esteja autenticado exibe a opção de logout. -->
            <form  class="inline" action="{{ route('site.logout') }}" method="POST" >
                @csrf
              <button
                type="submit"
                class="bg-white habit-shadow-lg habit-btn p-2 border-2">
                    Sair
                </button>
            </form>
        @endauth

        @guest
            <!-- Caso o usuário não esteja autenticado, exibe o login. -->
        <div class="flex gap-2">
          <a href="{{ route('site.register') }}" class="p-2 habit-shadow-lg bg-white">
            Cadastrar
          </a>
          <a href="{{ route('site.login') }}" class="p-2 habit-shadow-lg bg-habit-orange">
            Logar
          </a>

        </div>

      @endguest
    </div>
</header>
