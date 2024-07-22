@extends('layouts.master')
@section('css')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        text-transform: uppercase;
    }
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .form-container input,
    .form-container select {
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .form-container input[type="radio"] {
        width: auto;
        margin-right: 10px;
    }
    .form-container .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .form-container .form-row .form-group {
        flex: 1;
        margin-right: 10px;
    }
    .form-container .form-row .form-group:last-child {
        margin-right: 0;
    }
    .form-container button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
    }
    .form-container button:hover {
        background-color: #45a049;
    }
    select option {
        color: blue;
    }
    .trip-type-container {
       
        padding: 8px;
        border-radius: 4px;
        color: white; /* White text for contrast */
        display: flex;
        justify-content: space-between;
    }
    .trip-back{
        background-color: #007BFF; /* Blue background */
        text-align: center;
        padding: 10px;
        width:250px;
        height: 40px;

    }
    
    .trip-type-container label {
        display: inline; /* Keep labels inline */
        margin-bottom: 0; /* Remove bottom margin */
        font-weight: normal; /* Normalize font weight */
    }
</style>
@section('title')
    استعلام عن الحجوزات
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> استعلام عن الحجوزات</h4>
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
               <livewire:search />
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
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
@endsection
