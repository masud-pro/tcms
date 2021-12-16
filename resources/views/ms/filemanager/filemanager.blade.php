
@extends('layouts.cms')

@section('title')
    File Manager
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">File Manager</h6>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="fm-main-block">
                            {{-- <h2>CE CMS File Manager</h2> --}}
                            <div id="fm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
    
@endsection




@push('scripts')

<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');

        fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
            window.opener.fmSetLink(fileUrl);
            window.close();
        });
    });
</script>
@endpush

