<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
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

main {
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.header-content .login-link {
    display: inline-block;
    padding: 20px 16px;
    background-color: #f5f5f5;
    color: blue;
    text-decoration: none;
    border-radius: 4px;
    font-size: 18px;
   
    margin-left: 70%;
 
}
.login-link{
  margin-top: -100px;
  font-weight: 2rem;
}
.header-content img{
    display: inline-block;
    background-color: #003580;
    margin-left: 80%;
    padding: 10px;
    margin-top: -10%;
}
.header-content .login-link:hover {
    background-color: #003366;
}

.header-icon {
    height: 40px; /* Adjust height as needed */
}
h1 {
    margin-bottom: 20px;
}

h2 {
    margin-top: 30px;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input, .form-group select {
    width: 100%;
    padding: 15px 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.mobile-input {
    display: flex;
    gap: 10px;
}

.add-contact-info {
    display: block;
    margin-top: 10px;
    color: #003366;
    text-decoration: none;
    font-weight: bold;
}

.add-contact-info:hover {
    text-decoration: underline;
}

.contact-info {
    margin-top: 30px;
}

.flight-info {
    margin-top: 30px;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    display: block;
    width: 25%;
    padding: 10px;
    margin-top: 5px;
    margin-left: 850px;
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}
.logo{
    background-color: #003580;
    padding-left: 100px;
}
.logo img{
          
     margin-top: -15px;
     margin-right: 2px;
 }
button:hover {
    background-color: #00509e;
}
.top-left {
    position: absolute;
    top: 170px;
    left: 200px;
    margin-top: 10px;
    
}
.step-indicator {
    background-color: #003366;
    color: white;
    padding: 10px 150px;
    border-radius: 0 10px 10px 0;
    font-size: 18px;
}
.passenger-info {
    margin-left: 30%;
    background-color: white;
    padding: 10px 30px;
}
.mobile-input {
    display: flex;
    gap: 10px;
}

.mobile-input input[type="text"] {
    flex: 1;
}

.mobile-input input[type="text"]:first-child {
    flex: 0 0 100px; /* Adjust this width as necessary */
}


</style>
<body>
    
       
    <div class="header">
        <div class="steps">
               <div class="step logo"><a href="https://www.chamwings.com"><img width="200" height="50" src="https://chamwings.com/wp-content/uploads/2023/10/company_logo_white_500_123.png" alt="Cham Wings Logo"></a></div>
               <div class="step">1. Search</div>
               <div class="step">2. Select flight</div>
               <div class="step active">3. Enter details</div>
               <div class="step">4. Add extras</div>
               <div class="step">5. Pay and confirm</div>
            </div>
    </div>

    <livewire:details-passenger/>
</body>
</html>