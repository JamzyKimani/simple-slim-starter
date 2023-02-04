@extends('layouts.horizontal')

@section('content')

    @include('menus.nominations')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                @if (!empty($message))
                <div class="row mb-2 mt-2">
                    <div class="alert alert-{{ $message['type'] }}" role="alert">
                        {!! $message['text'] !!}
                    </div>
                </div>
                @endif 

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{ $page_title }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Elections</a></li>
                                    <li class="breadcrumb-item active">{{ $page_title }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- <div class="row"> --}}
                <form method="POST" action="{{ url('submit-nomination-application', [ 'election_code' => $election['election_code'], 'question_code' => $question['question_code'] ]) }}" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header px-4">
                            <h4 class="card-title mb-0">Candidate Application Form</h4>
                        </div>
                        @if(!empty($question['q_nomination_description']))
                        <div class="card-header px-4">
                            
                            <h5 class="fs-15">INSTRUCTIONS</h5>
                            {!! $question['q_nomination_description'] !!}

                            <div class="row g-3 mt-2">
                                @foreach ($attachments as $a)
                                
                                <div class="col-xxl-4 col-lg-6">
                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-file-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="assets/app_files/{{ $a['file'] }}" target="_blank" class="text-body text-truncate d-block">{{ $a['name'] }}</a></h5>
                                                <div>ATTACHMENT</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <a type="button" href="assets/app_files/{{ $a['file'] }}" target="_blank" class="btn btn-icon text-muted btn-sm fs-18"><i class="ri-download-2-line"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                    
                                @endforeach
                            </div>
                            
                        </div>
                        @endif
                        <div class="card-body px-4">
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <div class="col-md-12 mb-3">
                                        <label for="opt_title" class="form-label">Candidate Name</label>
                                        @csrf
                                        <input type="hidden" id="opt_method" name="_method" value="POST" />
                                        <input type="hidden" id="opt_question_code" name="opt_question_code" value="{{ $question['question_code'] }}" />
                                        <input type="hidden" id="opt_election_code" name="opt_election_code" value="{{ $election['election_code'] }}" />
                                        <input type="hidden" id="option_code" name="option_code" value="{{ uniqid('o_') }}" />
                                        <input type="text" required id="opt_title" name="opt_title" value="" class="form-control" placeholder="Enter your name" >
                                    </div>
            
                                    <div class="col-md-12 mb-3">
                                        <label for="opt_short_description" class="form-label">Title/Short description</label>
                                        <textarea name="opt_short_description" id="opt_short_description" class="form-control" ></textarea>
                                    </div>
            
                                </div>
                                <div class="col-md-4 text-center">
                                    <label class="form-label" style="width:100%">Candidate Image</label>
                                    <div class="profile-user position-relative d-inline-block mx-auto mt-2 mb-4">
                                        <img id="opt-img" src="assets/images/placeholder.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" name="opt_image" type="file" class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="opt_long_description" class="form-label">Candidate Bio / Long Description</label>
                                        <textarea name="opt_long_description"  id="opt_long_description" ></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row my-3">
                                <h5 class="fs-15">MANDATORY NOMINATION SUPPORTING DOCUMENTS</h5>
                                <p class="text-muted">Upload the following required documents needed for the application process. </p>
                            </div>
                            <div class="row g-3">
                                @foreach ($application_files as $f)
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload {{ $f }}</label>
                                        <input class="form-control" type="file" name="supporting_documents[]" required="" >
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer px-4">
                            <div class="hstack gap-2">
                                <button type="submit" class="btn btn-success">Submit Application</button>
                            </div>
                        </div>
                    </div> 
                
                </form>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME', 'Election System') }}.
                    </div>
                    <div class="col-sm-6">
                        <!--<div class="text-sm-end d-none d-sm-block">
                            Design &amp; Develop by 
                        </div>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
@endsection

@section('customjs')
<script>
    ClassicEditor
    .create( document.querySelector( '#opt_long_description' ) )
    .then( newEditor => {
        optEditor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );
</script>
@endsection











