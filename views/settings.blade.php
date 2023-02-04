@extends('layouts.vertical')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-n4 mx-n4 ribbon-box right">
            <div class="bg-soft-success">
                <div class="card-body pb-0 px-4">
                    @if (!empty($message))
                    <div class="ribbon ribbon-{{$message['type']}} ribbon-shape">{{$message['text']}}</div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="row align-items-center g-3">
                                <div class="col-md-auto">
                                    <div class="avatar-md">
                                        <div class="avatar-title bg-white rounded-circle">
                                            <img src="assets/images/svg/ballot.svg" alt="" class="avatar-xs">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div>
                                        <h4 class="fw-bold">{{ $election['election_title'] }}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <div>Start Date : <span class="fw-medium">{{ date('d M, Y (H:i)', strtotime($election['election_start_date'])) }}</span></div>
                                            <div class="vr"></div>
                                            <div>Due Date : <span class="fw-medium">{{ date('d M, Y (H:i)', strtotime($election['election_end_date'])) }}</span></div>
                                            <div class="vr"></div>
                                            @if ( time() < strtotime($election['election_start_date']) )
                                                <div class="badge rounded-pill bg-warning fs-12">Pre-Election</div>
                                            @elseif( time() > strtotime($election['election_start_date']) && time() < strtotime($election['election_end_date']) )
                                                <div class="badge rounded-pill bg-success fs-12">Ongoing</div>
                                            @else
                                                <div class="badge rounded-pill bg-danger fs-12">Closed</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div class="hstack gap-1 flex-wrap">
                                
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if($setting_form == "general-settings") active @endif fw-semibold" data-bs-toggle="tab" href="#general-settings" role="tab">
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($setting_form == "date-settings") active @endif fw-semibold" data-bs-toggle="tab" href="#date-settings" role="tab">
                                Dates
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($setting_form == "nomination-settings") active @endif fw-semibold" data-bs-toggle="tab" href="#nomination-settings" role="tab">
                                Nominations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($setting_form == "messages-setting") active @endif fw-semibold" data-bs-toggle="tab" href="#messages-setting" role="tab">
                                Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#delete-election" role="tab">
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<div class="row">
    <div class="col-lg-12">
        <div class="tab-content text-muted">
            <div class="tab-pane fade @if($setting_form == "general-settings") show active  @endif" id="general-settings" role="tabpanel">
                <div class="card">
                <form method="POST" action="{{ url('update-election', [ 'election_code' => $election['election_code'] ]) }}" enctype="multipart/form-data">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="ri-settings-5-line align-middle me-1 lh-1"></i> General Settings</h6>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="election_title" class="form-label">Election Title</label>
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT" />
                                    <input type="hidden" name="setting_form" value="general-settings" />
                                    <input type="text" required name="election_title" class="form-control" value="{{ $election['election_title'] }}" placeholder="Enter title" id="election_title">
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="election_description" class="form-label">Description</label>
                                    <textarea name="election_description" class="ckeditor-classic">{{ $election['election_description'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 ">
                                <label class="form-label" style="width:100%">Election Logo <span class="text-dark">(click camera icon to upload)</span></label>
                                <div class="profile-user position-relative d-inline-block mx-auto mt-2 mb-4">
                                    <img id="opt-img" src=@if(empty($election['election_logo'])) "assets/images/placeholder.png" @else "assets/app_files/{{ $election[ 'election_logo' ] }}" @endif class="avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" name="election_logo" type="file" class="profile-img-file-input">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="hstack gap-2">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade @if($setting_form == "date-settings") show active @endif" id="date-settings" role="tabpanel">
                <div class="card">
                    <form method="POST" action="{{ url('update-election', ['election_code' => $election['election_code'] ]) }}" >
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="setting_form" value="date-settings" />
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="ri-calendar-2-line align-middle me-1 lh-1"></i> Election Dates</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="election_start_date" class="form-label">Start Date</label>
                                    <input id="election_start_date" name="election_start_date" type="text" value="{{ date('Y-m-d H:i', strtotime($election['election_start_date'])) }}" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                </div>
                            </div>
                       
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="election_end_date" class="form-label">End Date</label>
                                    <input id="election_end_date" name="election_end_date" type="text" value="{{ date('Y-m-d H:i', strtotime($election['election_end_date'])) }}" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="election_timezone" class="form-label">Timezone</label>
                                <select class="form-select" data-choices data-choices-sorting="true" id="election_timezone" name="election_timezone">
                                    <option selected>Choose...</option>
                                    <option selected value="Africa/Nairobi">Nairobi (GMT+3)</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="hstack gap-2">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade @if($setting_form == "nomination-settings") show active @endif" id="nomination-settings" role="tabpanel">
                <div class="card">
                    <form method="POST" action="{{ url('update-election', ['election_code' => $election['election_code'] ]) }}" >
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="setting_form" value="nomination-settings" />
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="ri-calendar-2-line align-middle me-1 lh-1"></i> Nomination Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch form-switch-success form-switch-lg" dir="ltr">
                                        <input value="1" type="checkbox" name="enable_nominations" @if ($election['enable_nominations'] == 1) checked="" @endif  onchange="nominationSwitchForm(this)" class="form-check-input" id="enable-nomination-switch" >
                                        <label class="form-check-label" for="enable-nomination-switch">Enable candidate nomination process in this election</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nomination-options @if ($election['enable_nominations'] == 0) d-none @endif">
                            <div class="row">
                                <div class="col-md-12 my-3">
                                    <div class="alert alert-info alert-border-left alert-dismissible fade show" role="alert">
                                        <i class="ri-information-line me-3 align-middle fs-16"></i><strong>Nomination Process Type</strong><br>
                                        You need to select between the <strong>manual</strong> or <strong>online</strong> nomination process for the election. <br><br>

                                        <strong>Manual</strong> - a prospective candidate collects nomination signatures offline on a form and uploads the signed nomination form, with voter signatures, into the system.<br><br>
                                        <strong>Online</strong> - a prospective candidate puts themselves up for nomination on the system and other voters get to support his nomination online on the nomination portal. 

                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-4 mb-3" >
                                    <label for="nomination_process_type" class="form-label">Nomination Process Type</label>
                                    <select class="form-select" id="nomination_process_type" required name="nomination_process_type" aria-label=".form-select-sm example">
                                        <option @if ( empty($election['nomination_process_type']) ) selected=""  @endif>Select Nomination Type</option>
                                        <option value="MANUAL" @if ($election['nomination_process_type'] == 'MANUAL') selected=""  @endif>Manual Nomination</option>
                                        <option value="ONLINE" @if ($election['nomination_process_type'] == 'ONLINE') selected=""  @endif>Online Nomination</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="election_start_date" class="form-label">Start Date</label>
                                        <input id="election_start_date" name="nomination_start_date" type="text" @if( !empty($election['nomination_start_date']) ) value="{{ date('Y-m-d H:i', strtotime($election['nomination_start_date'])) }}" @endif class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="election_end_date" class="form-label">End Date</label>
                                        <input id="election_end_date" name="nomination_end_date" type="text" @if( !empty($election['nomination_start_date']) ) value="{{ date('Y-m-d H:i', strtotime($election['nomination_end_date'])) }}" @endif class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="nomination-options @if ($election['enable_nominations'] == 0) d-none @endif">
                        <div class="card-footer" >
                            <div class="hstack gap-2">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade @if($setting_form == "messages-setting") show active @endif" id="messages-setting" role="tabpanel">
                <div class="card">
                    <form method="POST" action="{{ url('update-election' , ['election_code' => $election['election_code'] ]) }}" >
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="setting_form" value="messages-setting" />
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="ri-chat-quote-line align-middle me-1 lh-1"></i> Election Messages</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label for="login_instructions" class="form-label text-dark">Login Instructions</label>
                                    <p class="text-muted mb-1">Instructions to voters that appears on the election login page. Details on the credentials to use.</p>
                                    <textarea id="login_instructions" name="login_instructions" type="text" class="form-control" >{{ $election['login_instructions'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label for="vote_confirmation_msg" class="form-label text-dark">Vote Confirmation Message</label>
                                    <p class="text-muted mb-1">This is the message a voter sees after successfully submitting their vote.</p>
                                    <textarea id="vote_confirmation_msg" placeholder="{{ env('VOTE_CONFIRMATION', "Your vote was received. Thank you for voting in this election!") }}" name="vote_confirmation_msg" type="text" class="form-control" >{{ $election['vote_confirmation_msg'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label for="after_election_message" class="form-label text-dark">After Election Message</label>
                                    <p class="text-muted mb-1">This is the text that your voters will see when they visit your election after it has ended. You can use this field to post the winners of the election.</p>
                                    <textarea id="after_election_message" placeholder="{{ env('ELECTION_CLOSED_MSG', "Voting for this election is closed.") }}"  name="after_election_message" type="text" class="form-control" >{{ $election['after_election_message'] }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="hstack gap-2">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end card-->
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade" id="delete-election" role="tabpanel">
                <div class="card border card-border-danger">
                    <!-- <form method="POST" action="{{ url('update-election') }}" > -->
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="setting_form" value="delete-election" />
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="ri-delete-bin-line align-middle me-1 lh-1"></i> Delete Election </h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Are you sure you want to delete this election? This action is not reversible. Please contact support if you need to make a change to an election that has already launched.</p>

                    </div>
                    <div class="card-footer">
                        <div class="hstack gap-2">
                            <button type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            
            </div>
            <!-- end tab pane -->
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection

@section('page_scripts')
<!-- ckeditor -->
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script type="text/javascript" src="assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="assets/js/pages/profile-setting.init.js"></script>

<script>
    ClassicEditor
    .create( document.querySelector( '.ckeditor-classic' ) )
    .catch( error => {
        console.error( error );
    } );

    flatpickr("#election_start_date", {enableTime: true});
    flatpickr("#election_end_date", {enableTime: true});

    function nominationSwitchForm(e){
       var divs = document.querySelectorAll('.nomination-options'); 
       
       if(e.checked){
           divs.forEach(function(div) {
                div.className = 'nomination-options';
           });
           console.log(divs);
            console.log(e)
       } else {
            divs.forEach(function(div) {
                div.className = 'nomination-options d-none';
           });
           console.log('false');
           console.log(divs);
            console.log(e)
       }
    }
    
</script>
@endsection
