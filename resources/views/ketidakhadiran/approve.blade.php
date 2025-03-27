@extends('layouts.admin')

@section('title', 'Penyetujuan Ketidakhadiran')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center my-4">{{ $pageTitle }}</h1>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let ketidakhadirans = @json($ketidakhadirans); // Convert PHP to JSON
            let all = @json($all);
            console.log("Filtered Ketidakhadiran with lower level:", ketidakhadirans);
            console.log("All Ketidakhadiran", all);
        });
    </script>
@endpush
