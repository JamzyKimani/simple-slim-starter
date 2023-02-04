@extends('layouts.vertical')

@section('pagecss')
<!-- dropzone css -->
<link rel="stylesheet" href="assets/libs/dropzone/dropzone.css" type="text/css" />

@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{$election['election_title'] }} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Ballot</a></li>
                    <li class="breadcrumb-item active">{{$page_title}}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@if (!empty($message))
<div class="row mb-2 mt-2">
    <div class="alert alert-{{ $message['type'] }}" role="alert">
        {!! $message['text'] !!}
    </div>
</div>
@endif 

<div class="row g-4 mb-3">              
    <div class="col-sm-auto">
        <div>
            {{-- <a href="{{ url('list-elections', [], ['new' => true ])}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Add Ballot Question</a> --}}
            <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNewQuestion" aria-controls="offcanvasNewQuestion"><i class="ri-add-line align-bottom me-1"></i>Add Elective Post/Contest</button>
        </div>
    </div>
    
    <div class="col-sm">
        <div class="d-flex justify-content-sm-end gap-2">

        </div>
    </div>  
</div>

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
            <p class="text-muted mx-4">Click "Add Elective Post/Contest" to create a Elective Post/Contest.</p>
        </div>
    </div>
</div>
<!--end row-->
@else
<div class="row mb-5">
    <div class="accordion accordion-primary lefticon-accordion custom-accordionwithicon accordion-border-box" id="accordionlefticon">
        @foreach ($questions as $i => $q)
        <div class="accordion-item">
            <h2 class="accordion-header" id="accordionQuestion{{ ($i+1) }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_questionCollapse{{ ($i+1) }}" @if($active_q == $q['question_code'] ) aria-expanded="true" @endif aria-controls="accor_questionCollapse{{ ($i+1) }}">
                    {{ $q['q_title'] }}
                </button> 
            </h2>
            <div id="accor_questionCollapse{{ ($i+1) }}" class="accordion-collapse collapse @if($active_q == $q['question_code']) show @endif" aria-labelledby="accordionQuestion{{ ($i+1) }}" data-bs-parent="#accordionlefticon">
                <div class="accordion-body">

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center" role="tablist" aria-orientation="vertical">
                                @if ($election['enable_nominations'] == 1)
                                <a class="nav-link @if ($election['enable_nominations'] == 1)  show active @endif" id="custom-v-pills-nominations-tab-{{ $q['question_code'] }}" data-bs-toggle="pill" href="#custom-v-pills-nominations" role="tab" aria-controls="custom-v-pills-nominations" aria-selected="true">
                                    <i class="ri-mail-line d-block fs-20 mb-1"></i> Nomination Settings
                                </a> 
                                @endif
                                
                                <a class="nav-link @if ($election['enable_nominations'] == 0)  show active @endif" id="custom-v-pills-options-tab-{{ $q['question_code'] }}" data-bs-toggle="pill" href="#custom-v-pills-options-{{ $q['question_code'] }}" role="tab" aria-controls="custom-v-pills-options-{{ $q['question_code'] }}" @if ($election['enable_nominations'] == 1) aria-selected="false" @else aria-selected="true" @endif >
                                    <i class="ri-list-check-2 d-block fs-20 mb-1"></i> Options/Candidates
                                </a>
                                <a class="nav-link" id="custom-v-pills-details-tab-{{ $q['question_code'] }}" data-bs-toggle="pill" href="#custom-v-pills-details-{{ $q['question_code'] }}" role="tab" aria-controls="custom-v-pills-details-{{ $q['question_code'] }}" aria-selected="false">
                                    <i class="ri-file-edit-fill d-block fs-20 mb-1"></i>Contest Details
                                </a>
                                
                            </div>
                        </div> <!-- end col-->
                        <div class="col-lg-10">
                            <div class="tab-content text-muted mt-3 mt-lg-0">
                                <div class="tab-pane fade @if ($election['enable_nominations'] == 0) active show @endif" id="custom-v-pills-options-{{ $q['question_code'] }}" role="tabpanel" aria-labelledby="custom-v-pills-options-tab-{{ $q['question_code'] }}">
                                    <div class="row g-4 mb-3">              
                                        <div class="col-sm-auto">
                                            <div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end gap-2">
                                                <button class="btn btn-outline-success" type="button" onclick="addOption('{{ $election['election_code'] }}', '{{ $q['question_code'] }}')"><i class="ri-add-line align-bottom me-1"></i>Add Option/Candidate</button>
                                                <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#removeCandidateModal" onclick="deleteQuestion('{{ $election['election_code'] }}', '{{ $q['question_code'] }}')"><i class="ri-delete-bin-2-line align-bottom me-1"></i>Delete Elective Post/Contest</button>
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    
                                    <div class="row col-12 px-5">
                                    @if (empty($q['question_options']))
                                        <div class="mt-4 pt-2  text-center">
                                            <h4>No Options/Candidates </h4>
                                            <p class="text-muted mx-4">Click "Add Option/Candidate" to create a voter answer option.</p>
                                        </div>
                                    @else
                                        {{-- <div class="card"> --}}
                                        <div class=" table-card mt-2 mb-2">
                                            <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                <tbody>
                                                @foreach ($q['question_options'] as $op)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                      
                                                                <img src=@if (empty($op['opt_image'])) "assets/images/placeholder.png" @else "assets/app_files/{{$op['opt_image']}}" @endif alt="{{$op['opt_title']}} image" class="rounded-circle avatar-sm img-thumbnail" >
                                                                <div class="fs-14 mx-3">
                                                                    <h5 class="fs-14 my-1"><a href="#" class="text-reset">{{$op['opt_title']}}</a></h5>
                                                                    <span class="text-muted">{{$op['opt_short_description']}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width: 10%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-sm"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                                </button>
        
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editOption('{{$election['election_code'] }}', '{{ $q['question_code'] }}', '{{ $op['option_code'] }}' )"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#removeCandidateModal" onclick="deleteOption('{{$election['election_code'] }}', '{{ $q['question_code'] }}', '{{ $op['option_code'] }}' )" ><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Remove</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>   
                                                @endforeach 
                                                </tbody>
                                            </table>
                                        </div>   
                                        {{-- </div>  --}}
                                    @endif

                                    </div>

                                </div>
                                <!--end tab-pane-->
                                <div class=" tab-pane fade" id="custom-v-pills-details-{{ $q['question_code'] }}" role="tabpanel" aria-labelledby="custom-v-pills-details-tab-{{ $q['question_code'] }}">
                                <form class="mx-5" action=" {{ url('update-question', ['election_code' => $election['election_code'], 'question_code' => $q['question_code'] ]) }}" method="POST" >
                                    <div class="row my-3">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_title" class="form-label">Title</label>
                                                @csrf
                                                <input type="hidden" name="_method" value="PUT" />
                                                <input type="hidden" value="{{ $q['question_code'] }}" name="question_code" />
                                                <input type="hidden" value="{{ $election['election_code'] }}" name="q_election_code" />
                                                <input type="text" required name="q_title" value="{{ $q['q_title'] }}" class="form-control" placeholder="Enter title" >
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="q_description" class="form-label">Description</label>
                                                <textarea name="q_description"  id="create_q_description{{($i+1)}}" >{{ $q['q_description'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="q_description" class="form-label">Minimum options voters can select</label>
                                                <input type="number" required name="q_min_selection" class="form-control" value="{{ $q['q_min_selection'] }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="q_description" class="form-label">Maximum options voters can select</label>
                                                <input type="number" required name="q_max_selection" class="form-control" value="{{ $q['q_max_selection'] }}" >
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row mt-3 mb-3">
                                        <div class="col-md-12">
                                            <div class="form-check form-switch form-switch-success form-switch-lg mb-3" dir="ltr">
                                                <input type="checkbox" name="q_randomize_options" value="1" class="form-check-input" id="customSwitchsizelg" @if($q['q_randomize_options'] == 1) checked="" @endif >
                                                <label class="form-check-label" for="customSwitchsizelg">Randomize order of ballot options for each voter</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row bt-1">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-success" type="submit" >Save</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                                <!--end tab-pane-->
                                @if ($election['enable_nominations'] == 1)
                                <div class="tab-pane fade @if ($election['enable_nominations'] == 1) active show @endif" id="custom-v-pills-nominations" role="tabpanel" aria-labelledby="custom-v-pills-nominations-tab">
                                    <form class="mx-5" id="nominationDataForm" action=" {{ url('update-question', ['election_code' => $election['election_code'], 'question_code' => $q['question_code'] ]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT" />
                                        <input type="hidden" value="{{ $q['question_code'] }}" name="question_code" />
                                        <input type="hidden" value="{{ $election['election_code'] }}" name="q_election_code" />

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="q_nomination_min_supporters" class="form-label text-dark">Minimum number of candidate nomination supporters</label>
                                                    <p class="text-muted">How many nomination supporters does a prospective nominee require?</p>
                                                    <input type="number" required name="q_nomination_min_supporters"  class="form-control" @if($q['q_nomination_min_supporters'] > 0) value="{{ $q['q_nomination_min_supporters'] }}" @endif >
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="choices-text-unique-values" class="form-label text-dark">Mandatory documents required from nominee to support nomination</label>
                                                    <p class="text-muted">Write the title of the document, e.g. "National ID", and press <strong>Enter</strong>. Repeat to add up to 10 document titles.</p>
                                                    <input class="form-control" id="choices-text-unique-values" data-choices data-choices-text-unique-true data-choices-limit="10" data-choices-removeItem  type="text" name="q_nomination_supporting_docs"  value="{{ $q['q_nomination_supporting_docs'] }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="q_nomination_description_{{($i+1)}}" class="form-label text-dark">Nomination Description/Instructions</label>
                                                    <p class="text-muted">Write short description of the nomination process and/or instructions for prospective nominees on how to apply.</p>
                                                    <textarea name="q_nomination_description"  id="q_nomination_description_{{($i+1)}}" >{{ $q['q_nomination_description'] }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row  my-3">
                                        <div class="col-md-12 mx-5">
                                            <label class="form-label text-dark">Nomination Description Attachments</label>
                                            <p class="text-muted">Upload files you want to be attached and displayed with the nomination description text.</p>

                                            <form style="width:90%" id="filesForm_{{$q['question_code']}}" class="dropzone" action="{{ url('update-question', ['election_code' => $election['election_code'], 'question_code' => $q['question_code'] ]) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick"  >                                          
                                                    <h5>Drop files here or click to upload.</h5>
                                                </div>
                                            </form>
                                            
                                            <ul class="list-unstyled mb-0" id="dropzone-preview-{{$q['question_code']}}" style="width:90%">
                                                <li class="mt-2" id="dropzone-preview-list-{{$q['question_code']}}">
                                                    <!-- This is used as the file preview template -->
                                                    <div class="border rounded">
                                                        <div class="d-flex p-2">
                                                            {{-- <div class="flex-shrink-0 me-3">
                                                                <div class="dz-success-mark"><span>✔</span></div>
                                                                <div class="dz-error-mark"><span>✘</span></div>
                                                            </div> --}}
                                                            
                                                            <div class="flex-grow-1">
                                                                <div class="pt-1">
                                                                    <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                                    {{-- <p class="fs-13 text-muted mb-0" data-dz-size></p> --}}
                                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                                </div>
                                                            </div>
                                                            <div class="flex-shrink-0 ms-3">
                                                                <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- end dropzon-preview -->

                                            <ul class="list-unstyled mb-0"  style="width:90%">
                                                @foreach ($q['q_nomination_desc_attachments'] as $attach)
                                                    <li class="mt-2" >
                                                        <!-- This is used as the file preview template -->
                                                        <div class="border rounded">
                                                            <div class="d-flex p-2">                                                            
                                                                <div class="flex-grow-1">
                                                                    <div class="pt-1">
                                                                        <h5 class="fs-14 mb-1">&nbsp; {{ $attach['name'] }} </h5>
                                                                        <p class="fs-13  mb-0 mx-2" ><a href="assets/app_files/{{ $attach['file'] }}" target="_blank" ><i class="ri-eye-line align-middle ms-1"></i> View</a></p>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-3">
                                                                    <button data-bs-toggle="modal" data-bs-target="#removeCandidateModal" onclick="deleteAttachment('{{ $election['election_code'] }}','{{ $q['question_code'] }}','{{ $attach['file'] }}')" class="btn btn-sm btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>   
                                                @endforeach
                                            </ul>

                                        </div>	
                                    </div>	
                                    <div class="row bt-1">
                                        <div class="col-md-3 mx-5">
                                            <button type="button" class="btn btn-success" id="nominationDetailsFormSubmitBtn" >Save</button>
                                        </div>
                                    </div>
                                    
                                </div> 
                                <!--end tab-pane-->
                                @endif
                            </div>
                        </div> <!-- end col-->
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!--end row-->    
@endif

<!-- right offcanvas -->
<form method="POST" id="create-question-form" action="{{ url('election-ballot', ['election_code' => $election['election_code'] ] ) }}" > 
<div class="offcanvas offcanvas-end" style="min-width: 50%" tabindex="-1" id="offcanvasNewQuestion" aria-labelledby="offcanvasNewQuestionLabel">
    
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNewQuestionLabel"> Create Elective Post/Contest</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body overflow-hidden">
      
        <div data-simplebar style="height: calc(100vh - 160px);">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="q_title" class="form-label">Title</label>
                        @csrf
                        <input type="hidden" value="{{uniqid('q_')}}" name="question_code" />
                        <input type="text" required name="q_title" class="form-control" placeholder="Enter elective contest title" id="q_title">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="q_description" class="form-label">Contest Description</label>
                        <textarea name="q_description"  id="create-question-description" class="ckeditor-classic"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="q_description" class="form-label">Maximum options/candidates voters can select</label>
                        <input type="number" required name="q_min_selection" class="form-control" value="1" id="q_min_selection">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="q_description" class="form-label">Minimum options/candidates voters can select</label>
                        <input type="number" required name="q_max_selection" class="form-control" value="1" id="q_max_selection">
                    </div>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <div class="form-check form-switch form-switch-success form-switch-lg mb-3" dir="ltr">
                        <input type="checkbox" name="q_randomize_options" value="1" class="form-check-input" id="customSwitchsizelg" >
                        <label class="form-check-label" for="customSwitchsizelg">Randomize order of ballot options/candidates for each voter</label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer border p-3">
        <button type="submit" onclick="document.getElementById('create-question-form').submit" class="btn btn-success"><i class="ri-save-3-fill align-middle ms-1"></i> Save Question </button>
    </div>
   
</div>
</form>


<!-- right offcanvas -->
<form method="POST" id="create-option-form" enctype="multipart/form-data"> 
    <div class="offcanvas offcanvas-end" style="min-width: 50%" tabindex="-1" id="offcanvasOptionDetails" aria-labelledby="offcanvasOptionDetailsLabel">
        
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasOptionDetailsLabel">Candidate Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body overflow-hidden">
            <div data-simplebar style="height: calc(100vh - 160px);">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12 mb-3">
                            <label for="opt_title" class="form-label">Title/Candidate Name</label>
                            @csrf
                            <input type="hidden" id="opt_method" name="_method" value="POST" />
                            <input type="hidden" id="opt_question_code" name="opt_question_code" />
                            <input type="hidden" id="opt_election_code" name="opt_election_code" />
                            <input type="hidden" id="option_code" name="option_code" value="" />
                            <input type="text" required id="opt_title" name="opt_title" value="" class="form-control" placeholder="Enter option" >
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="opt_short_description" class="form-label">Short Description</label>
                            <textarea name="opt_short_description" id="opt_short_description" class="form-control" ></textarea>
                        </div>

                    </div>
                    <div class="col-md-4 text-center">
                        <label class="form-label">Option Image</label>
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
                            <label for="opt_long_description" class="form-label">Long Description</label>
                            <textarea name="opt_long_description"  id="opt_long_description" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer border p-3">
            <button type="submit" class="btn btn-success"><i class="ri-save-3-fill align-middle ms-1"></i> Save Option/Candidate Details </button>
        </div>
       
    </div>
</form>

<div id="removeCandidateModal" class="modal fade zoomIn" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">
            <form method="POST" id="delete-option-form" action="" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0" id="delete-modal-message">Are you sure you want to remove this candidate/option? This is irreversible.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" id="del_opt_method" name="_method" value="DELETE" />
                    <input type="hidden" id="del_params" name="delete_params" value="" />
                    <button type="submit" class="btn w-sm btn-danger" id="remove-project">Yes, Delete It!</button>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@endsection

@section('page_scripts')
<!-- ckeditor -->
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script type="text/javascript" src="assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="assets/js/pages/profile-setting.init.js"></script>

<!-- dropzone min -->
<script src="assets/libs/dropzone/dropzone-min.js"></script>
<script src="assets/js/pages/form-file-upload.init.js"></script>

<script>
    document.getElementById('nominationDetailsFormSubmitBtn').onclick = function () { document.getElementById('nominationDataForm').submit(); }

    //nomination decription attachment dropzone start
    @foreach ($questions as $i => $q)

    //========={{$i}}=================
    var previewTemplate,
    dropzone,
    dropzonePreviewNode = document.querySelector("#dropzone-preview-list-{{$q['question_code']}}");
    (dropzonePreviewNode.id = ""),
    dropzonePreviewNode &&
        ((previewTemplate = dropzonePreviewNode.parentNode.innerHTML),
        dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode),
        (dropzone = new Dropzone("#filesForm_{{$q['question_code']}}", { url: "{{ url('update-question', ['election_code' => $election['election_code'], 'question_code' => $q['question_code'] ]) }}", method: "post", previewTemplate: previewTemplate, previewsContainer: "#dropzone-preview-{{$q['question_code']}}" })))
    
    dropzone.on("sending", function(file, xhr, formData) {
        // Will send the filesize along with the file as POST data.
        formData.append("_method", 'PUT');
        formData.append("csrf_token", '{{csrf_token()}}');
        formData.append("question_code", '{{ $q['question_code'] }}');
        formData.append("q_election_code", '{{ $election['election_code'] }}');
    
        console.log(formData);
    });

    //========= end {{$i}}==============
    @endforeach
    //dropzone end

    var myOffcanvas = document.getElementById('offcanvasOptionDetails')
    var offcanvasOptionDetails = new bootstrap.Offcanvas(myOffcanvas)

    ClassicEditor
    .create( document.querySelector( '#opt_long_description' ) )
    .then( newEditor => {
        optEditor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );

    function addOption(election_code, question_code) {
        var formAction = '/elections/'+election_code+'/questions/'+question_code+'/options';
        document.getElementById('create-option-form').action = formAction;
        document.getElementById('opt_method').value = 'POST';
        document.getElementById('opt_question_code').value = '';
        document.getElementById('opt_election_code').value = '';
        document.getElementById('option_code').value = '{{uniqid("o_")}}';
        document.getElementById('opt_title').value = '';
        document.getElementById('opt_short_description').value = '';
        document.getElementById('opt-img').src = '/assets/images/placeholder.png';
        document.getElementById('opt_long_description').innerHTML = '';
        offcanvasOptionDetails.show();
    }

    function editOption(election_code, question_code, option_code) {
        var formAction = '/elections/'+election_code+'/questions/'+question_code+'/options/'+option_code;
        document.getElementById('create-option-form').action = formAction;
        document.getElementById('opt_method').value = 'PUT';
        document.getElementById('option_code').value = option_code;
        // fetch option details
        var xhr = new XMLHttpRequest(); 
        var url = '/api/elections/'+election_code+'/questions/'+question_code+'/options/'+option_code;
        console.log(url);
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var opt = JSON.parse(this.responseText);
                document.getElementById('opt_question_code').value = opt.opt_question_code;
                document.getElementById('opt_election_code').value = opt.opt_election_code;
                document.getElementById('opt_title').value = opt.opt_title;
                document.getElementById('opt_short_description').value = opt.opt_short_description;
                document.getElementById('opt-img').src = '/assets/images/placeholder.png';
                if(opt.opt_image != '' ) {
                    document.getElementById('opt-img').src = '/assets/app_files/'+opt.opt_image;
                }
                const editorData = optEditor.setData(opt.opt_long_description);
                offcanvasOptionDetails.show();
            }
        }
        xhr.send();
    }

    function deleteOption(election_code, question_code, option_code){
        var formAction = '/elections/'+election_code+'/questions/'+question_code+'/options/'+option_code;
        document.getElementById('delete-option-form').action = formAction;
        document.getElementById('del_opt_method').value = 'DELETE';
        document.getElementById('delete-modal-message').innerHTML = "Are you sure you want to remove this candidate/option? This is irreversible.";
    }

    function deleteQuestion(election_code, question_code){
        var formAction = '/elections/'+election_code+'/questions/'+question_code;
        document.getElementById('delete-option-form').action = formAction;
        document.getElementById('del_opt_method').value = 'DELETE';
        document.getElementById('delete-modal-message').innerHTML = "Are you sure you want to remove this ballot question? This is irreversible.";

    }

    function deleteAttachment(election_code, question_code, file) {
        console.log('this is triggered');
        var formAction = '/elections/'+election_code+'/file';
        document.getElementById('delete-option-form').action = formAction;
        document.getElementById('del_opt_method').value = 'DELETE';
        document.getElementById('del_params').value = '{"file_type":"nomination_description_attachment","question_code":"'+question_code+'", "file_name" : "'+file+'" }';
        document.getElementById('delete-modal-message').innerHTML = "Are you sure you want to delete this nomination description attachment?";
    }
    
    ClassicEditor
    .create( document.querySelector( '#create-question-description' ) )
    .catch( error => {
        console.error( error );
    } );
    
    @foreach ($questions as $i => $q)
    ClassicEditor
    .create( document.querySelector( '#create_q_description{{($i+1)}}' ) )
    .catch( error => {
        console.error( error );
    } );

    ClassicEditor
    .create( document.querySelector( '#q_nomination_description_{{($i+1)}}' ) )
    .catch( error => {
        console.error( error );
    } );
    @endforeach
    
   
</script>
@endsection