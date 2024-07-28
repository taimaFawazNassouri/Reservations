<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #002147;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            align-items: center;
        }

        .navbar ul {
            list-style-type: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar li {
            margin-right: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 0.9em;
        }

        .navbar a:hover {
            color: #ddd;
        }

        .navbar img {
            max-height: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .progress-bar li {
            padding: 10px 15px;
            position: relative;
            display: inline-block;
            font-size: 0.9em;
        }

        .progress-bar li.current {
            background-color: #d4af37;
            color: #fff;
        }

        .progress-bar li::after {
            content: '>';
            position: absolute;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .progress-bar li:last-child::after {
            content: '';
        }

        .date-selection {
            display: flex;
            justify-content: space-between;
            overflow-x: auto;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .date {
            text-align: center;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            background-color: #f0f0f0;
            flex: 1;
            margin-right: 5px;
        }

        .date.active {
            background-color: #d4af37;
            color: #fff;
        }

        .date:last-child {
            margin-right: 0;
        }

        .flight-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .flight-table th,
        .flight-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .flight-table th {
            background-color: #f0f0f0;
        }

        .flight-info {
            text-align: center;
            position: relative;
        }

        .flight-info::before {
            content: '\2708';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2em;
            color: #666;
        }

        .economy-class {
            text-align: center;
            color: #d4af37;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="https://www.chamwings.com"><img src="images/main_logo.png" alt="Cham Wings Logo"></a></li>
            <li><a href="#">Search</a></li>
            <li class="current"><a href="#">Select flight</a></li>
            <li><a href="#">Enter details</a></li>
            <li><a href="#">Add extras</a></li>
            <li><a href="#">Pay and confirm</a></li>
        </ul>
    </div>

    <livewire:response />
</body>

</html>
