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
       <form class="s3upload" action="{{ route('pictures.store') }}" id="form" data-s3inputes="{{ json_encode($s3inputes) }}" data-s3attributes="{{ json_encode($s3attributes) }}" method="post" enctype="multipart/form-data">
        @csrf
            <!--@foreach($s3inputes as $name => $value)
                <input type="text" name="{{ $name }}" value="{{ $value }}">
            @endforeach -->
            <input type="hidden" name="storage_path" value="{{ $s3inputes['key'] }}"/>
            <input type="text" name="title"/>
            <input type="file" name="file"/>
            <input type="submit" />
       </form>
       <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
       <script type="text/javascript" src="/js/s3upload.js"></script>
    </body>
</html>
