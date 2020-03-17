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
        <h1>{{$picture->title}}</h1>
        <img src="{{route('pictures.show', $picture->id)}}"/>
        <form href="{{ route('pictures.destroy', $picture->id) }}"  method="POST">
            @csrf
            <input type="hidden" name="_method" value="DELETE"/>
            <input type="submit" value="delete" />
        </form>
    </body>
</html>
