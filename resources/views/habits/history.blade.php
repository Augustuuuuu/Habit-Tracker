<x-layout>
  <main class="max-w-5xl mx-auto py-10 px-4 min-h-[80vh] w-full">

    {{--nAVBAR--}}

    <x-navbar/>
    <x-title>
      Histórico
    </x-title>


    {{--YEAR SELECTION--}}

    <div class="my-4">
      @foreach($avaiableYears as $year)
        <a href="{{route('habits.history', $year)}}"
           class="habit-btn habit-shadow-lg p-2 inline-block
      {{ $selectedYear == $year ? 'bg-habit-orange' : '' }}"
        >
          {{ $year }}
        </a>
      @endforeach
    </div>

    {{--HISTÓRICO--}}
    @forelse($habits as $habit)
      <x-contribution :$habit :year="$selectedYear"/>
    @empty
      <div>
        <p class="text-black">
          Nenhum hábito para exibir histórico.
        </p>
        <a href="{{ route('habits.create') }}" class="underline ">
          Crie um novo hábito
        </a>
      </div>
    @endforelse

  </main>
</x-layout>
