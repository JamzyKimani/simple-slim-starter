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
                <!-- end page title -->
                @if($hide_my_nomination_area === true)

                    @if (empty($questions))
                        <div class="row justify-content-center mb-5">
                            <div class="col-md-8 col-lg-6 col-xl-5 text-center">
                                <div class="avatar-lg mx-auto mt-2">
                                    <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                        <i class="ri-list-check-2"></i>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <h4>No Elective Post/Contests </h4>
                                    <p class="text-muted mx-4">No elective posts have been set up for nomination. Contact your election administrator for further assistance.</p>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    @else
                        <!-- end row -->
                        <div class="row">          
                            @foreach ($questions as $q)
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-0">Nominations for {{ $q['q_title'] }}</h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                                
                                                <li class="list-inline-item">
                                                    
                                                    <a class="align-middle minimize-card" data-bs-toggle="collapse" href="#collapseexample-{{ $q['question_code'] }}" role="button" aria-expanded="true" aria-controls="collapseExample2">
                                                        <i class="mdi mdi-plus align-middle plus"></i>
                                                        <i class="mdi mdi-minus align-middle minus"></i>
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body collapse show" id="collapseexample-{{ $q['question_code'] }}" style="">
                                    @if ($q['has_nominees'] == false)
                                    <div class="row g-4 mb-3">
                            
                                        <div class="col-sm-auto">
                                            <div>
                                                <a type="button" class="btn btn-success" href="{{ url( 'nomination-application' , [ 'election_code' => $election['election_code'], 'question_code' => $q['question_code'] ] ) }}" ><i class="ri-pages-line align-bottom me-1"></i> Apply for Nomination</a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end gap-2">
                        
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row justify-content-center mb-5">
                                        <div class="col-md-8 col-lg-6 col-xl-5 text-center">
                                            <div class="avatar-lg mx-auto mt-2">
                                                <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                                    <i class="ri-question-fill"></i>
                                                </div>
                                            </div>
                                            <div class="mt-4 pt-2">
                                                <h4>No One has Applied for Nomination </h4>
                                                <p class="text-muted mx-4">If you want to nominate yourself as a candidate for this elections click the <strong>"Apply for Nomination"</strong> button above.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                    @else 
                                    <div class="row g-4 mb-3">
                            
                                        <div class="col-sm-auto">
                                            <div>
                                                <a type="button" class="btn btn-success" href="{{ url( 'nomination-application' , [ 'election_code' => $election['election_code'], 'question_code' => $q['question_code'] ] ) }}" ><i class="ri-pages-line align-bottom me-1"></i> Apply for Nomination</a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end gap-2">
                        
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
                                                <h5 class="mb-0 pb-1 text-decoration-underline">Using Grid Markup</h5>
                                            </div> --}}
                                            <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-1">

                                                @foreach ($q['question_options'] as $op)

                                                <div class="col">
                                                    <div class="card card-body border card-border-info">
                                                        <div class="d-flex mb-4 align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <img src=@if (empty($op['opt_image'])) "assets/images/placeholder.png" @else "assets/app_files/{{$op['opt_image']}}" @endif alt="{{$op['opt_title']}} image" class="avatar-sm rounded-circle" />
                                                            </div>
                                                            <div class="flex-grow-1 ms-2">
                                                                <h5 class="card-title mb-1">{{$op['opt_title']}}</h5>
                                                                <p class="text-muted mb-0">{{$op['opt_short_description']}}</p>
                                                            </div>
                                                        </div>
                                                        {{-- <h6 class="mb-1">$15,548</h6>
                                                        <p class="card-text text-muted">Expense Account</p> --}}
                                                        @if ($op['opt_approval_stage'] == 0)
                                                            {{-- Stage 0: online nominations candidate pending online seconders --}}
                                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm">Support Candidate Nomination</a>
                                                        @elseif ($op['opt_approval_stage'] == 1)
                                                            {{-- 
                                                                Stage 1: online/manual nominations candidate pending verification by admin
                                                                If online nominations it means candidate nomination has gained the minimum number of supporters
                                                                Manual applications automatically go to this stage
                                                            --}}
                                                            <div class="alert alert-warning"> Candidate is waiting verification by election administrator </div>
                                                        @elseif ($op['opt_approval_stage'] == 100)
                                                            {{-- 
                                                                Stage 100: online/manual nominations candidate is verified by admin and will appear on the ballot
                                                            --}}
                                                            <div class="alert alert-success"> Nomination Successful! Candidate can vie for the election. </div>
                                                        @endif
                                                        
                                                    </div>
                                                </div><!-- end col --> 
                                      
                                                @endforeach
                                            </div><!-- end row -->
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                
                                    @endif
                                </div>
                            </div>
                                
                            @endforeach
                        </div>
                        <!-- end row -->
                    @endif
                @else
                <!--my nominations section -->
                    
                @endif
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




