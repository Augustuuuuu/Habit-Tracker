<h1>

Welome to the home page.

</h1>
<p>
 Olá, {{$name}}!
</p>
<p>
Seus hábitos são:
</p>
<ul>
    @foreach($habits as $item)
        <li>
            {{$item}}
        </li>
    @endforeach
</ul>

@auth
    <p>
        Você está logado como!
    </p>
@endauth
@guest
    <p>
        Você não está logado!
    </p>
@endguest