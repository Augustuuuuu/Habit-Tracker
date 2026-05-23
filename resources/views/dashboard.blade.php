<x-layout>
  <main class="py-10 min-h-[calc(100vh-160px)]">
    <x-navbar/>


    @session('success')
      <div class="flex">
        <p class="bg-green-100 border-2 border-green-400 text-green-700 p-3 mb-4">
          {{session('success')}}
        </p>
      </div>
    @endsession

      <div>
        <h2 class="text-xl mt-8 mb-2">
          {{date('d/m/Y')}}
        </h2>
        <ul class="flex flex-col gap-2">
          @forelse($habits as $item)
            <li class="habit-shadow-lg p-2 bg-[#FFDAAC]">
              <div class="flex gap-2 items-center">
                <input type="checkbox" class="w-5 h-5 {{$item->is_completed ? 'checked': ''}}" disabled>

                <p class="font-bold text-l">
                  {{ $item->name }}
                </p>

              </div>
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
      </div>
    </main>
</x-layout>
