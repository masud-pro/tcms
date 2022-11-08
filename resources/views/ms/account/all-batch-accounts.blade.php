@extends('layouts.cms')

@section('title')
    Accounts
@endsection

@push("styles")
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        @if ( session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ( session('failed') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('failed') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <ul>
            <li><b>We have made managing payemnts much more easier than ever.</b></li>
            <li><b>Just click on the button and you're done.</b></li>
            <li><b>To re-authorize users based on their payments, just click on "Re-authorize Users" below after checking all the users.</b></li>
        </ul>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 pt-2">
                        <h6 class="m-0 font-weight-bold text-primary">Account for {{ \Carbon\Carbon::today()->format('M-Y') }} </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm pointer" onclick = "clickpdf()" >
                            <i class="fa-solid fa-file-pdf"></i> Download as PDF
                        </a>
                    </div>
                </div>
                
            </div>
            <div class="card-body">

                @livewire('account.all-batch-accounts')

                <div class="text-right mt-3">
                    <a href="{{ route("dashboard") }}">Go Back</a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel">Update and Re-authorize?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <ul>
                <li>Update will just update the accounts</li>
                <li>Update with re-authorize will update the accounts and give <b>access to the students to the course materials based on their payment status.</b></li>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="updateButton">Update</button>
            <button type="button" class="btn btn-primary" id="updateReauthButton">Update and Re-authorize</button>
        </div>
    </div>
    </div>
</div>
    
@endsection


@push('scripts')
    
    <!-- Page level custom scripts -->
    <script>           
            $("#updateButton").click(function(){
                $("#updateForm").submit();
            });
            $("#updateReauthButton").click(function(){
                $("input#reauth_all").val("1");
                $("#updateForm").submit();
            });
        
    </script>
@endpush
