@extends('layouts.vertical')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{$election['election_title'] }} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Election</a></li>
                    <li class="breadcrumb-item active">{{$page_title}}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-4 col-lg-6">
        <div class="card card-body">
            <div class="avatar-sm mb-3">
                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                    <i class="ri-search-eye-line"></i>
                </div>
            </div>
            <h4 class="card-title">Preview the Election</h4>
            <p class="card-text text-muted">Check out how the election will look to voters and submit a dummy vote - votes in the preview do not count towards the final tally of the election.</p>
            <p class="card-text text-muted">Credentials for the preview are:</p>
            <p class="card-text text-muted">Username:  <span class="text-dark">test</span></p>
            <p class="card-text text-muted">Password:  <span class="text-dark">test</span></p>
            @if (count($questions) < 1)
                <div class=" mb-2 mt-2">
                    <div class="alert alert-danger" role="alert">
                        The election must have at least one election question/elective post set up. <strong><a href="{{ url('election-ballot', ['election_code' => $election['election_code']]) }}" >Click here</a></strong> to set up the ballot.
                    </div>
                </div>
            @else
            <a href="{{ url( 'show-voter-login', [ 'election_code' => $election['election_code'] ])}}" target="_blank" class="btn btn-success"><i class="ri-eye-fill align-bottom me-1"></i> Preview</a>
            @endif
            
        </div>
    </div>
</div>
@endsection

@section('page_scripts')


@endsection