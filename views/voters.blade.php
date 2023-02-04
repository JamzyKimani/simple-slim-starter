@extends('layouts.vertical')

@section('pagecss')
<!-- Sweet Alert css-->
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')
 <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Voters List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Election</a></li>
                    <li class="breadcrumb-item active">Voters List</li>
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

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0">Add, Edit & Remove Voters</h4>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-3 align-items-center my-n2">
                            <button class="btn btn-md btn-success"  data-bs-toggle="modal" data-bs-target="#votersImportModal" ><i class="ri-upload-cloud-2-fill align-bottom me-1"></i> Bulk Upload Voters</button>
                            @if (!empty($voters))
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-sm"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" target="_blank" href="{{ url('download-voter-list', [ 'election_code' => $election['election_code']] )}}"><i class="ri-download-cloud-2-fill align-bottom me-2 text-muted"></i> Download Voters List</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#removeAllVotersModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete All Voters </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <button class="btn btn-success" type="button" onclick="addVoter('{{$election['election_code']}}')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasVoterDetails" aria-controls="offcanvasVoterDetails"><i class="ri-add-line align-bottom me-1"></i>Add Voter</button>
                                @if (!empty($voters))
                                <button class="btn btn-soft-danger" onClick="deleteMultiple('{{$election['election_code']}}')"><i class="ri-delete-bin-2-line"></i> Delete</button>   
                                @endif
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (empty($voters))
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-8 col-lg-6 col-xl-5 text-center">
                            <div class="avatar-lg mx-auto mt-2">
                                <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                    <i class="ri-list-check-2"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-2">
                                <h4>No Voters Registered </h4>
                                <p class="text-muted mx-4">Click "Add Voter" to create a voter or click "Bulk Upload Voters" to upload voters in bulk.</p>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                    @else
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="all">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="name">Name</th>
                                    <th class="sort" data-sort="username">Username</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="phone">Phone</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($voters as $v)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $v['voter_code'] }}">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">{{ $v['voter_code'] }}</a></td>
                                    <td class="name">{{ $v['voter_name'] }}</td>
                                    <td class="username">{{ $v['voter_username'] }}</td>
                                    <td class="email">{{ $v['voter_email'] }}</td>
                                    <td class="phone">+{{ $v['voter_phone'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success edit-item-btn" onclick="editVoter('{{ $v['voter_election_code'] }}', '{{ $v['voter_code'] }}')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasVoterDetails" aria-controls="offcanvasVoterDetails" >Edit</button>
                                    </td>
                                </tr>    
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0"> We did not find any voters for you search.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0)">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0)">
                                Next
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<!-- right offcanvas -->
<form method="POST" id="voter-details-form" enctype="multipart/form-data" action=""> 
    <div class="offcanvas offcanvas-end" style="min-width: 30%" tabindex="-1" id="offcanvasVoterDetails" aria-labelledby="offcanvasVoterDetailsLabel">
        
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasVoterDetailsLabel">Voter Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body overflow-hidden">
            <div data-simplebar style="height: calc(100vh - 160px);">
                @csrf
                <input type="hidden" name="new_user_type" value="SINGLE" />
                <input type="hidden" id="voter_method" name="_method" value="POST" />
                <input type="hidden" id="voter_code" name="voter_code" value="" />

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="voter_name" class="form-label">Voter Name</label>
                        <input type="text" name="voter_name" id="voter_name" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="voter_username" class="form-label">Voter Username</label>
                        <input type="text" name="voter_username" id="voter_username" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="voter_password" class="form-label">Voter Password</label>
                        <input type="text" name="voter_password" id="voter_password" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="voter_email" class="form-label">Email</label>
                        <input type="text" name="voter_email" id="voter_email" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="voter_phone" class="form-label">Phone</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">+</span>
                            <input type="number" class="form-control" placeholder="start with contry code" id="voter_phone" name="voter_phone" aria-label="Phone Number" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
                    
                </div>
            </div>
        </div>
        <div class="offcanvas-footer border p-3">
            
            <button type="submit" class="btn btn-success"><i class="ri-save-3-fill align-middle ms-1"></i> Save Voter Details </button>
        </div>
       
    </div>
</form>

<div id="removeAllVotersModal" class="modal fade zoomIn" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">
            <form method="POST" id="delete-voter-form" action="" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0" id="delete-modal-message">This is permanent and will erase <strong>ALL</strong> voters in this election. Please confirm</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    @csrf
                    <input type="hidden" id="del_voter_method" name="_method" value="DELETE" />
                    <input type="hidden" id="voter_codes" name="voter_codes" value="ALL" />
                    <button type="submit" class="btn w-sm btn-danger" id="remove-project">Yes, Delete all voters!</button>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!---Modal--->
<div class="modal fade" id="votersImportModal" tabindex="-1" aria-labelledby="votersImportModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="votersImportModalLabel">How To Import Voters in Bulk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form enctype="multipart/form-data" action="" method="POST" > 
                <div class="d-flex mt-2 mb-3">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <p class="text-muted mb-0"><a href="assets/VOTERS_UPLOAD_TEMPLATE.csv"><strong>Click here</strong> </a> to download the voter upload template and add the details of one voter per row. <code>The columns in your spreadsheet must exactly match the import template or the import will fail.</code></p>
                    </div>
                </div>
                <div class="d-flex mt-2 mb-3">
                    <div class="flex-shrink-0">
                        <i class="ri-checkbox-circle-fill text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-2 ">
                        <p class="text-muted mb-0">Once you fill out the template, upload it below and click "Upload Voters". </p>
                    </div>
                </div>
                
                <div class="col-md-12 mt-2 mb-3"> 
                    @csrf
                    <input type="hidden" name="new_user_type" value="BULK" />
                    <input type="hidden" id="voter_batch_code" name="voter_batch_code" value="{{ vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4) ) }}" />
                    <input id="bulk-upload-template" name="upload_template" required accept=".csv" type="file" class="form-control">
                </div> 
               
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                <button type="submit" class="btn btn-primary ">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!---Modal End -->
@endsection

@section('page_scripts')
<script src="assets/js/plugins.js"></script>
    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/libs/list.js/list.min.js"></script>
    <script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- listjs init -->
    <script src="assets/js/pages/listjs.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
    var myOffcanvas = document.getElementById('offcanvasVoterDetails');
    var offcanvasOptionDetails = new bootstrap.Offcanvas(myOffcanvas);

    function addVoter(election_code) {
        var formAction = '/elections/'+election_code+'/voters';

        document.getElementById('voter-details-form').action = formAction;
        document.getElementById('voter_method').value = 'POST';
        document.getElementById('voter_username').value = '';
        document.getElementById('voter_password').value = '';
        document.getElementById('voter_email').value = '';
        document.getElementById('voter_code').value = {{ uniqid('v_') }};
        document.getElementById('voter_name').value = '';
        document.getElementById('voter_phone').value = '';

        offcanvasOptionDetails.show();
    }

    function editVoter(election_code, voter_code) {
        var formAction = '/elections/'+election_code+'/voters/'+voter_code;

        document.getElementById('voter-details-form').action = formAction;
        document.getElementById('voter_method').value = 'PUT';
        // fetch option details
        var xhr = new XMLHttpRequest(); 
        var url = '/api/elections/'+election_code+'/voters/'+voter_code;
        console.log(url);
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var v = JSON.parse(this.responseText);
                console.log(v);
                document.getElementById('voter_username').value = v.voter_username;
                document.getElementById('voter_password').value = v.voter_password;
                document.getElementById('voter_email').value = v.voter_email;
                document.getElementById('voter_code').value = v.voter_code;
                document.getElementById('voter_name').value = v.voter_name;
                document.getElementById('voter_phone').value = v.voter_phone;
                offcanvasOptionDetails.show();
            }
        }
        xhr.send();

        offcanvasOptionDetails.show();
    }
    </script>
@endsection