<x-layout>
    <main class="py-10">
        <p>
            Bem-vindo ao seu acompanhamento de hábitos!
        </p>
        @auth
            <p>
                Bem vindo(a), {{ auth()->user()->name }}!
            </p>
        @endauth
    </main>
</x-layout>
