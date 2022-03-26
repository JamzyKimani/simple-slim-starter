@extends('layouts.app')

@section('content')
     <div><p>Hello World!!! This is {{ env('APP_NAME', 'Cool App Name') }}</p></div>
@endsection