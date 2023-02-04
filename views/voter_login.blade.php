@extends('layouts.voting')

@section('content')
<div class="row justify-content-center">

    <div class="col-xl-6">

        <div class="card overflow-hidden">
            <div class="card-header p-2">
                <div class="text-center">
                    <img src=@if(empty($election['election_logo'])) "assets/images/placeholder.png" @else "assets/app_files/{{ $election[ 'election_logo' ] }}" @endif  alt="" height="80">
                    {{-- <h3 class="mt-4 fw-semibold">We're currently offline</h3>
                    <p class="text-muted mb-4 fs-14">We can't show you this images because you aren't connected to the internet. When you’re back online refresh the page or hit the button below</p>
                    <button class="btn btn-success btn-border" onClick="window.location.href=window.location.href"><i class="ri-refresh-line align-bottom"></i> Refresh</button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3 class="fw-semibold">{{ $election['election_title'] }}</h3>
                </div>
            </div>
            <div class="card-footer"> 
                @if (!empty($election['login_instructions']))
                <div class="mb-2 mt-2">
                    <div class="alert alert-info" role="alert">
                        {!! $election['login_instructions'] !!}
                    </div>
                </div>
                @endif 

                @if (!empty($message))
                <div class=" mb-2 mt-2">
                    <div class="alert alert-{{ $message['type'] }}" role="alert">
                        {!! $message['text'] !!}
                    </div>
                </div>
                @endif 

                <div class="p-2 mt-1">
                    <form action="{{ $form_action }}" method="POST">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            @csrf
                        </div>

                        <div class="mb-3">
                            {{-- <div class="float-end">
                                <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                            </div> --}}
                            <label class="form-label" for="password-input">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" name="password" class="form-control pe-5" placeholder="Enter password" id="password-input" required>
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                        </div>


                    </form>
                </div>
            </div>
            
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->    
@endsection