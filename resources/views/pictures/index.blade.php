<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <ul>
            @foreach($pictures as $pict)
            <li>
                <p>
                   <a href="{{ route('pictures.show', $pict->id) }}">
                        {{ $pict->title }}
                        <img src="{{ route('pictures.show', $pict->id) }}"/>
                    </a>
                </p>
            </li>
            @endforeach
        </ul>
    </body>
</html>
