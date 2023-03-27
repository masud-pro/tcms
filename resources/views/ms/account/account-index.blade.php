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

        <ul class="list-unstyled">
            <li><b>- If someone's payment is not showing then see whether is the student is <a href="{{ route("user.index") }}">active</a>, then press regenerate.</b></li>
            <li><b>- If you've made a lots of mistakes, press of newly generate payments to generate payments newly.</b></li>
        </ul>

        <form method="POST" class="d-inline" action="{{ route("account.sms-report",['parent'=>"father"]) }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ request()->course->id }}">
            <input type="submit" onclick="return confirm('Are you sure you want to send account report to father')" 
                class="btn btn-primary mb-4" value="Send Account Report To Father">
        </form>

        <form method="POST" class="d-inline" action="{{ route("account.sms-report",['parent'=>"mother"]) }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ request()->course->id }}">
            <input type="submit" onclick="return confirm('Are you sure you want to send account report to mother')" 
                class="btn btn-primary mb-4" value="Send Account Report To Mother">
        </form>

        <form class="d-inline" action="{{ route("account.regenerate",['course' => request()->course]) }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-primary mb-4" onclick="return confirm('Are you sure you want to re generate?')" value="Regenerate Payments">
        </form>
        <form class="d-inline" action="{{ route("account.regenerate.new",['course' => request()->course]) }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-primary mb-4" onclick="return confirm('Are you sure you want to newly regenerate?')" value="Newly Generate Payments">
        </form>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Account for {{ \Carbon\Carbon::today()->format('M-Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <form id="updateForm" action="{{ route("account.change") }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Authorization</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Account</th>
                                    <th>Authorization</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $account->user ? $account->user->id : "Not Found" }}</td>
                                        <td>{{ $account->user ? $account->user->name : "Not Found" }}</td>
                                        <td>
                                            <input type="hidden" name="ids[]" value="{{ $account->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input {{ $account->status == "Paid" ? "checked" : "" }}  name="status[]" value="{{ $account->id }}" type="checkbox" class="custom-control-input" id="customCheck{{ $account->id }}">
                                                <label class="custom-control-label" for="customCheck{{ $account->id }}">Paid</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="canBeAuthorizedUsers[]" value="{{ $account->user->id }}">
                                                <input {{ $course->user->where('id',$account->user_id)->first()?->pivot->is_active == 1 ? "checked" : "" }}  name="is_active[]" value="{{ $account->user->id }}" type="checkbox" class="custom-control-input" id="is_active{{ $account->id }}">
                                                <label class="custom-control-label" for="is_active{{ $account->id }}">Paid</label>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($account->status == "Paid")
                                                <span class="badge badge-success">Paid</span>
                                            @elseif ($account->status == "Unpaid")
                                                <span class="badge badge-danger">Unpaid</span>
                                            @elseif ($account->status == "Pending")
                                                <span class="badge badge-secondary">Pending</span>
                                                
                                                <a href="{{ route("account.mark-unpaid",['account'=>$account->id]) }}" class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Are you sure you want to mark this payment as unpaid?')">
                                                    Mark Unpaid
                                                </a>   
                                            @endif
                                        </td>
                                        <td>{{ $account->user ? $account->user->email : "Not Found" }}</td>
                                        <td>{{ $account->paid_amount ?? "Not Found" }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="course" value="{{ request()->course->id }}">
                        <input type="hidden" name="reauth" value="0" id="reauth">
                        {{-- <input type="submit" class="btn btn-primary" value="Update"> --}}
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
                            Update
                        </button>
                    </form>

                    <div class="text-right">
                        <a href="{{ route("course.feeds.index",['course'=>request()->course]) }}">Go Back</a>
                    </div>
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
                <li>Updating will re authorize the users, &check; will get access and others not</li>
                {{-- <li>Update with re-authorize will update the accounts and give <b>access to the students to the course materials based on their payment status.</b></li> --}}
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="updateButton">Update</button>
            {{-- <button type="button" class="btn btn-primary" id="updateReauthButton">Update and Re-authorize</button> --}}
        </div>
    </div>
    </div>
</div>
    
@endsection


@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset("assets") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("assets") }}/js/demo/datatables-demo.js"></script>
    <script>
        $(document).ready(function() {    
            $("#updateButton").click(function(){
                $("#updateForm").submit();
            });
            $("#updateReauthButton").click(function(){
                $("input#reauth").val("1");
                $("#updateForm").submit();
            });
        });
    </script>
@endpush
