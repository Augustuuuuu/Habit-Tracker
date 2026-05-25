<x-layout>
  <main class="max-w-5xl mx-auto py-10 px-4 min-h-[80vh] w-full">
    <x-navbar/>
    @session('success')
    <div class="flex">
      <p class="bg-green-100 border-2 border-green-400 text-green-700 p-3 mb-4">
        {{session('success')}}
      </p>
    </div>
    @endsession


    <x-title>
        Configurar Hábitos
    </x-title>

    <ul class="flex flex-col gap-2 mt-2">
        @forelse($habits as $item)
        <li class="flex gap-2 items-center justify-between w-full">
          <div class="habit-shadow-lg p-2 bg-[#FFDAAC] w-full">
              <p class="font-bold text-l">
                {{ $item->name }}
              </p>
          </div>
              <a href="{{ route('habits.edit', $item) }}"
                 class="bg-white habit-shadow-lg text-white p-2 hover:opacity-50 cursor-pointer">
                <x-icons.edit/>
              </a>
              <form action="{{route('habits.destroy', $item)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 habit-shadow-lg text-white p-2 hover:opacity-50 cursor-pointer">
                  <x-icons.trash/>
                </button>
              </form>

        </li>

        @empty
          <p>
            Nenhum hábito cadastrado.
          </p>
          <a href="{{route('habits.create')}}" class="bg-white p-2 border-2">
            Cadastre um novo hábito agora.
          </a>
        @endforelse
      </ul>

  </main>
</x-layout>

