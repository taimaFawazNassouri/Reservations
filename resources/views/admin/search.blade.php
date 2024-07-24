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
            color: white;
            /* White text for contrast */
            display: flex;
            justify-content: space-between;
        }

       .trip-back button.active {
        background-color: #007bff;
        color: white;
        }

        .trip-type-container label {
            display: inline;
            /* Keep labels inline */
            margin-bottom: 0;
            /* Remove bottom margin */
            font-weight: normal;
            /* Normalize font weight */
        }
        .dropdown-content {
        display: block; /* Ensure dropdown content is visible when condition is met */
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border: 1px solid #ddd;
        border-radius: 4px;
        }

/* Dropdown links */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Styles for selected details */
.selected-details {
    margin-top: 10px;
      }
       .checkbox{
           margin-right: -270px;
           margin-top: -270px;
        }
        .checklabel{
          margin-top: -35px;
          margin-right: 30px;
        }
        
    </style>
@endsection

@section('title')
    استعلام عن الحجوزات
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> استعلام عن الحجوزات</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right float-left pt-0 pr-0">
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
    window.addEventListener('hideForm', () => {
    console.log('hideForm event received');
    isVisible = false;
    });
   
    document.addEventListener('DOMContentLoaded', function () {
    const adultsSelect = document.getElementById('adults');
    const infantsSelect = document.getElementById('infants');

    function updateInfantsOptions(maxInfants) {
        // Clear existing options
        infantsSelect.innerHTML = '';

        // Add new options based on maxInfants
        for (let i = 0; i <= maxInfants; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            infantsSelect.appendChild(option);
        }
    }

    // Initialize options on page load
    updateInfantsOptions(adultsSelect.value);

    // Update options when adults value changes
    adultsSelect.addEventListener('change', function () {
        updateInfantsOptions(adultsSelect.value);
    });
    });

    document.addEventListener('DOMContentLoaded', function () {
      

        const oneWayButton = document.getElementById('one-way');
        const roundTripButton = document.getElementById('round-trip');
        const returnDateGroup = document.getElementById('return_date');

        const toggleReturnDate = () => {
            if (oneWayButton.classList.contains('active')) {
                returnDateGroup.style.display = 'none';
            } else {
                returnDateGroup.style.display = 'block';
            }
        };

        oneWayButton.addEventListener('click', () => {
            oneWayButton.classList.add('active');
            roundTripButton.classList.remove('active');
            toggleReturnDate();
        });

        roundTripButton.addEventListener('click', () => {
            roundTripButton.classList.add('active');
            oneWayButton.classList.remove('active');
            toggleReturnDate();
        });

        // Initialize the display based on the initial state
        toggleReturnDate();
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
