@extends('layouts.voting')

@section('content')
<div class="row justify-content-center">

    <div class="col-xl-6">

        <div class="card overflow-hidden">
            <div class="card-header p-1">
                <div class="text-center">
                    <img src=@if(empty($election['election_logo'])) "assets/images/svg/ballot.svg" @else "assets/app_files/{{ $election[ 'election_logo' ] }}" @endif  alt="" height="80">
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3 class="fw-semibold">{{ $election['election_title'] }}</h3>
                </div>
            </div>
            <div class="card-footer"> 
                <div class="text-center">
                    @if (!empty($message))
                    <div class=" mb-2 mt-2">
                        <div class="alert alert-{{ $message['type'] }}" role="alert">
                            {!! $message['text'] !!}
                        </div>
                    </div>
                    @endif 
                    
                </div>
            </div>
            
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->    
@endsection