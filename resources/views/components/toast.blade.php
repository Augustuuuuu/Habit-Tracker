@php
  $type = session()->has('success') ? 'success'
      : (session()->has('error') ? 'error'
      : 'warning');

  $message = session($type);
  $styles = [
      'success' => 'bg-green-100 border-green-400 text-green-700',
      'error' => 'bg-red-100 border-red-400 text-red-700',
      'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
  ];
@endphp
<div
  id="toast"
  class="absolute top-25 right-5 border-2 p-3 mb-4 flex gap-2 items-center
           transition-all duration-500 ease-in-out opacity-100 translate-x-0
           {{ $styles[$type] }}"
>
  <x-dynamic-component :component="'icons.' . $type" class="mt-4"/>

  <p>
    {{ $message }}
  </p>
</div>

