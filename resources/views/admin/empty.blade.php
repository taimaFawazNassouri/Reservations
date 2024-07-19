@extends('admin.layouts.master')

@section('css')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <style>
        .error {
            color: red;
            display: none;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title my-auto mb-0">Reservation</h4>
                <span class="text-muted tx-13 mt-1 mb-0 mr-2">/Numper Reservation</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <livewire:empty-page />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function validateInput() {
            const inputField = document.getElementById('inputField');
            const errorMessage = document.getElementById('error-message');
            const pattern = /^[A-Za-z0-9]{6}$/;
            if (!pattern.test(inputField.value)) {
                errorMessage.style.display = 'block';
                inputField.classList.add('is-invalid');
            } else {
                errorMessage.style.display = 'none';
                inputField.classList.remove('is-invalid');

            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputField = document.getElementById('inputField');
            inputField.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('Dashboard/js/select2.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/js/advanced-form-elements.js') }}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('Dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('Dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
