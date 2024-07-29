<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Selection</title>
    <link rel="shortcut icon" type="image/ico" href="https://chamwings.com/wp-content/themes/chamwings/images/favicon.ico" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            background-color: #ccc;
            color: white;
            height: 60px;
            text-align: center;
            justify-content: center;
            align-items: center;

         
        }
        .steps {
            display: flex;
            justify-content: center;
            height: 100%;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        .step {
            flex: 1;
            text-align: center;
            padding-top: 20px;
            font-size: 18px;
            color: white;
        }
        .step.active {
            background-color: #AE8A3B;
            font-weight: bold;
            color: white;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            color: #003580;
        }
        .flight-selection {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .flight-selection div {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            text-align: center;
            background-color: #fff;
            margin: 0 5px;
        }
        .flight-selection div.active {
            background-color: #e9ecef;
            border: 2px solid #003580;
        }
        .flight-details {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #fff;
        }
        .flight-details h3 {
            margin-top: 0;
            background-color: #003580;
            color: white;
            padding: 10px;
            text-align: left;
            margin-bottom: 20px;
        }
        .flight-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .flight-details table th, .flight-details table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .flight-details table th {
            background-color: #f0f0f0;
        }
        .flag-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
        }
        .flag-container img {
            margin-left: 10px;
        }
        .price {
            color: #003580;
            font-weight: bold;
        }
        .logo{
            background-color: #003580;
            padding-left: 100px;
        }
    </style>
</head>
<body>

    <div class="header">
  

        <div class="steps">
           <div class="step logo"><a href="https://www.chamwings.com"><img src="{{asset('images/main_logo(1).png')}}" alt="Cham Wings Logo"></a></div>
           <div class="step">1. Search</div>
           <div class="step active">2. Select flight</div>
           <div class="step">3. Enter details</div>
           <div class="step">4. Add extras</div>
           <div class="step">5. Pay and confirm</div>
        </div>
    </div>

    <livewire:response />
</body>

</html>
