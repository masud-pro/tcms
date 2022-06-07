@extends('layouts.cms')

@section('title')
    SMS
@endsection

@push("styles")
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
        @if ( session('delete') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- <div class="row">
            <div class="col">
                <a class="btn btn-primary mb-4" href="{{ route("course.create") }}">Add Course</a>
            </div>
            <div class="col text-right">
                <a class="btn btn-info mb-4" href="{{ route("archived.course") }}">Archived Courses</a>
            </div>
        </div> --}}

        <div class="text-right">
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">All SMS</h6>
                    </div>
                    <div class="col text-right">
                        <span class="m-0 font-weight-bold text-primary">Remaining SMS</span> - <b>{{ $remainingSMS->value }}</b>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>For</th>
                                <th>Message</th>
                                <th>Count</th>
                                <th>Send At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Course</th>
                                <th>For</th>
                                <th>Message</th>
                                <th>Count</th>
                                <th>Send At</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($smss as $sms)
                                <tr>
                                    <td>
                                        <a href="{{ $sms->course ? route("course.feeds.index",['course'=>$sms->course->id]) : "#" }}">
                                            {{ $sms->course ? $sms->course->name : "Not found" }}
                                        </a>
                                    </td>
                                    <td>{{ $sms->for }}</td>
                                    <td>{{ $sms->message }}</td>
                                    <td>{{ $sms->count }}</td>
                                    <td>{{ $sms->created_at->format("d-M-Y") }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <b>No SMS Record Found</b>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $smss->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


