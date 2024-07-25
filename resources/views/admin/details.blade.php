@extends('layouts.master')
@section('css')

@section('title')
    استعلام عن الحجوزات
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> استعلام عن تفاصيل الحجز</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                {{-- <li class="breadcrumb-item active">Page Title</li> --}}
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <livewire:details-passenger/>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    document.getElementById('countryResidence').addEventListener('change', function() {
        var selectedCountry = this.options[this.selectedIndex];
        var countryCode = selectedCountry.getAttribute('data-code');
        var countryCode2 = selectedCountry.getAttribute('data-code');

        document.getElementById('countryCodeTravel').value = countryCode;
        document.getElementById('countryCodePhone').value = countryCode2;


    });
   
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
@endsection
