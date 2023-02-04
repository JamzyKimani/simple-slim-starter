@extends('layouts.voting')

@section('pagecss')
<!-- Sweet Alert css-->
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row justify-content-center">

    <div class="col-xl-10">

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
            @if (!empty($election['election_description']))
            <div class="card-footer text-center">
                {!! $election['election_description'] !!}
            </div>
            @endif

        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
    
    @foreach ($questions as $q)
    <div class="col-xl-10">

        <div class="card overflow-hidden">
            <div class="card-header ">
                <h4 class="card-title mb-0 flex-grow-1">{{ $q['q_title'] }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>INSTRUCTIONS:</strong> {!! $q['question_instructions'] !!}
                </div>
                
                <div class="row">
                    <div class=" table-card mx-1 mt-2 mb-1">
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
                                        <div>
                                            <input type="checkbox" class="btn-check {{ $q['question_code'] }}" id="cand_{{$op['option_code']}}" value="{{ $op['option_code'] }}">
                                            <label class="btn btn-outline-secondary" for="cand_{{$op['option_code']}}">
                                                <strong><i class="ri-check-fill" style="color: #fff" ></i></strong>
                                            </label>
                                        </div>
                                    </td>
                                </tr>   
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
    @endforeach
    <div class="col-xl-10">

        <div class="card">
        <form action="{{ url( 'submit-vote' ,[ 'election_code' => $election['election_code'] ]) }}" method="POST" onsubmit="return validateSubmission()" > 
            <div class=" px-3 py-3">
                <input type="hidden" value=""  id="vote_date" name="vote_data" />
                <input type="hidden"  id="voter_code" name="voter_code" value="{{ session('voter_code') }}" />
                @csrf
                <button type="submit" class="btn btn-success"  style="width:100%"> Submit Vote </button>
            </div>
        </form>
        </div>

    </div>

</div>
<!-- end row -->    
@endsection

@section('page_scripts')
<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
function validateOnSelection(e) {
    @foreach ($questions as $q)
{{ 'var '.$q['question_code'].'_min = '.$q['q_min_selection'].';' }}
    {{ 'var '.$q['question_code'].'_max = '.$q['q_max_selection'].';' }}
    @endforeach
    
    let classname = e.target.className.split(' ')[1];
    //check how many votes have been cast for a category
    let chs = document.querySelectorAll('.'+classname);
    let count = 0;
    chs.forEach(ch => {
        if(ch.checked){ count++; }
    })

    let checked = e.target.checked;
    if (checked) {
        console.log("checked !");
        if(count > eval( classname+'_max' ) ) {
            e.target.checked = false;
            let m = 'You can only select a maximum of '+ eval( classname+'_max' ) +' candidates.';
            Swal.fire({
                icon: 'error',
                title: 'Forbidden',
                text: "You can't select more than "+ eval( classname+'_max' )+" candidate(s)",
            })
        } 
    } 
}

var checkboxes = document.querySelectorAll('input[type=checkbox]');

checkboxes.forEach(function(ch) {
    ch.addEventListener('change', validateOnSelection.bind(event));
})

function validateSubmission() {
    @foreach ($questions as $q)
{{ 'var '.$q['question_code'].'_min = '.$q['q_min_selection'].';' }}
    {{ 'var '.$q['question_code'].'_max = '.$q['q_max_selection'].';' }}
    @endforeach
    //get all checkboxes
    var checkboxes = document.querySelectorAll('input[type=checkbox]');
    //loop through them
    var vote_data = [];
    var count_data = [];
    var q = [];
    checkboxes.forEach(function(ch) {
        if(ch.checked){
            let elect_code = '{{ $election["election_code"] }}'
            let q_code = ch.className.split(' ')[1];
            let opt_code = ch.value;

            let data = {};
            data.election_code = elect_code;
            data.question_code = q_code;
            data.option_code = opt_code;
            vote_data.push(data);

            if ( typeof count_data[q_code] == 'undefined' ) {
                count_data[q_code] = 1;
            } else {
                count_data[q_code] = count_data[q_code] + 1;
            }

            if(q.indexOf(q_code) < 0) {
                q.push(q_code);
            }
        }
    })
    
    document.getElementById('vote_date').value = JSON.stringify(vote_data);

    if(vote_data.length == 0 ){
        Swal.fire({
                icon: 'error',
                title: 'Nothing Selected',
                text: "Please make your choice before clicking the submit button.",
            })
        //console.log('false 1');
        return false;
    } 
    
    if(q.length != {{ count($questions) }} ) {
        Swal.fire({
                icon: 'error',
                title: 'Nothing Selected',
                text: "Please make your selection in all the categories.",
            })
            //console.log('false 2');
        return false
     } 

    var allGood = true;
    var msg = '';
    q.forEach( x => {
        //console.log(count_data[x] );
        if( count_data[x] > eval( x+'_max' ) || count_data[x] < eval( x+'_min' ) ){
            msg = 'Please select the minimum number of candidates allowed for voting.'
            allGood = false;
        }
    })
    
    if(allGood) {
        return true;
    } else {
        Swal.fire({
                icon: 'error',
                title: 'Nothing Selected',
                text: msg,
            })
        return allGood;
    }
}
</script>
@endsection