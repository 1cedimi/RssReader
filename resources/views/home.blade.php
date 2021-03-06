@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">

    <div class="col-md-8">
 
      <div class="card">
        <div class="card-header mt-3">
          10  most frequent words
        </div>
        <div class="card-body">
          <ol>
          @foreach($result as $word => $quantity) 
            <li>) <b>{{$word}}</b> (appeared<b> {{$quantity}}</b> times)</li>
          @endforeach
          </ol>
        </div>      
      </div>
    </div>

    <div class="col-md-12">
      <div class="justify-content-md-center breadcrumb mt-5">
        <h1>RSS Feed</h1>
      </div>     

      @foreach($entries as $data)      
      <div class="card mt-3">
        <div class="card-header">
          {!!$data->getElementsByTagName("title")->item(0)->nodeValue!!}
        </div>
        <div class="card-body">
          <label>Author:</label> {!!$data->getElementsByTagName("name")->item(0)->nodeValue!!}
          {!!$data->getElementsByTagName("summary")->item(0)->nodeValue!!}
          <a target="_blank" href="{{$data->getElementsByTagName('link')->item(0)->getAttribute('href')}}">Continue</a>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</div>
@endsection
