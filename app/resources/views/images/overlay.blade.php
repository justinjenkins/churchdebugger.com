@extends('layouts.single')

    @section('content')
            <div style="width: 1080px; height: 720px; margin: auto; box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important; background-image: url('/default_image.jpg');">
            <img src="/images/{{$image->imageid}}/overlay.png" />
            </div>
    @endsection
