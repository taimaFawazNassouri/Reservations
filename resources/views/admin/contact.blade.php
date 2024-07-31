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
    <div class="container">
        <main>
                <div class="header-content">
                        <h1>Enter Passenger Details</h1>
                        <a href="#" class="login-link">Login</a>
                        <img width="200" height="50" src="https://chamwings.com/wp-content/uploads/2023/10/company_logo_white_500_123.png" alt="Icon" class="header-icon">
                    </div>
            <form wire:submit.prevent="submitDetails" id="passenger-form">
                    <div class="top-left">
                            <div class="step-indicator">Adult 1</div>
                    </div>
                <div class="passenger-info">
                    <div class="section-header">
                        <h2>Adult 1</h2>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <select wire:model="title" id="title" class="form-control" required>
                                    <option value=""  selected>Select your title</option>
                                    <option value="MR">Mr</option>
                                    <option value="MS">Ms</option>
                                    <option value="MRS">Mrs</option>
                                    <option value="DR">Dr</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="first-name">First Name *</label>
                            <input wire:model="first_name" type="text" id="first-name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name *</label>
                            <input wire:model="last_name" type="text" id="last-name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nationality">Nationality *</label>
                            <select wire:model="nationality" id="nationality" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option value="United States" data-code="+1">United States</option>
                                    <option value="Canada" data-code="+1">Canada</option>
                                    <option value="United Kingdom" data-code="+44">United Kingdom</option>
                                    <option value="Australia" data-code="+61">Australia</option>
                                    <option value="India" data-code="+91">India</option>
                                    <option value="Germany" data-code="+49">Germany</option>
                                    <option value="France" data-code="+33">France</option>
                                    <option value="Japan" data-code="+81">Japan</option>
                                    <option value="Brazil" data-code="+55">Brazil</option>
                                    <option value="China" data-code="+86">China</option>
                                    <option value="Mexico" data-code="+52">Mexico</option>
                                    <option value="Italy" data-code="+39">Italy</option>
                                    <option value="South Africa" data-code="+27">South Africa</option>
                                    <option value="Russia" data-code="+7">Russia</option>
                                    <option value="South Korea" data-code="+82">South Korea</option>
                                    <option value="Turkey" data-code="+90">Turkey</option>
                                    <option value="Saudi Arabia" data-code="+966">Saudi Arabia</option>
                                    <option value="United Arab Emirates" data-code="+971">United Arab Emirates</option>
                                    <option value="Argentina" data-code="+54">Argentina</option>
                                    <option value="Indonesia" data-code="+62">Indonesia</option>
                                        <!-- Add more countries as needed -->
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth *</label>
                            <input wire:model="date_of_birth" type="date" id="dob" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="passport">Passport *</label>
                            <input wire:model="passport_number" type="text" id="passport" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="passport-issued-country">Passport Issued Country *</label>
                            <select wire:model="passport_issued_country" id="passportCountry" class="form-control" required>
                                    <option value="" disabled selected></option>
                                    <option value="United States" data-code="+1">United States</option>
                                    <option value="Canada" data-code="+1">Canada</option>
                                    <option value="United Kingdom" data-code="+44">United Kingdom</option>
                                    <option value="Australia" data-code="+61">Australia</option>
                                    <option value="India" data-code="+91">India</option>
                                    <option value="Germany" data-code="+49">Germany</option>
                                    <option value="France" data-code="+33">France</option>
                                    <option value="Japan" data-code="+81">Japan</option>
                                    <option value="Brazil" data-code="+55">Brazil</option>
                                    <option value="China" data-code="+86">China</option>
                                    <option value="Mexico" data-code="+52">Mexico</option>
                                    <option value="Italy" data-code="+39">Italy</option>
                                    <option value="South Africa" data-code="+27">South Africa</option>
                                    <option value="Russia" data-code="+7">Russia</option>
                                    <option value="South Korea" data-code="+82">South Korea</option>
                                    <option value="Turkey" data-code="+90">Turkey</option>
                                    <option value="Saudi Arabia" data-code="+966">Saudi Arabia</option>
                                    <option value="United Arab Emirates" data-code="+971">United Arab Emirates</option>
                                    <option value="Argentina" data-code="+54">Argentina</option>
                                    <option value="Indonesia" data-code="+62">Indonesia</option>
                                        <!-- Add more countries as needed -->
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="passport-expiry">Passport Expiry *</label>
                            <input wire:model="passport_expiry_date" type="date" id="passportExpiry" class="form-control" required>
                        </div>
                    </div>
                    <a href="#" class="add-contact-info">Add Contact Info</a>
                </div>
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <label>
                        <input type="checkbox" checked>
                        Adult 1 will be the contact person for this journey
                    </label>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input wire:model="city" type="text" id="city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="residence">Country of Residence *</label>
                            <select wire:model="country_of_residence" id="countryResidence" class="form-control" required>
                                    <option value="" disabled selected>Select your country</option>
                                    <option value="United States" data-code="+1">United States</option>
                                    <option value="Canada" data-code="+1">Canada</option>
                                    <option value="United Kingdom" data-code="+44">United Kingdom</option>
                                    <option value="Australia" data-code="+61">Australia</option>
                                    <option value="India" data-code="+91">India</option>
                                    <option value="Germany" data-code="+49">Germany</option>
                                    <option value="France" data-code="+33">France</option>
                                    <option value="Japan" data-code="+81">Japan</option>
                                    <option value="Brazil" data-code="+55">Brazil</option>
                                    <option value="China" data-code="+86">China</option>
                                    <option value="Mexico" data-code="+52">Mexico</option>
                                    <option value="Italy" data-code="+39">Italy</option>
                                    <option value="South Africa" data-code="+27">South Africa</option>
                                    <option value="Russia" data-code="+7">Russia</option>
                                    <option value="South Korea" data-code="+82">South Korea</option>
                                    <option value="Turkey" data-code="+90">Turkey</option>
                                    <option value="Saudi Arabia" data-code="+966">Saudi Arabia</option>
                                    <option value="United Arab Emirates" data-code="+971">United Arab Emirates</option>
                                    <option value="Argentina" data-code="+54">Argentina</option>
                                    <option value="Indonesia" data-code="+62">Indonesia</option>
                                    <!-- Add more countries as needed -->
                                </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input wire:model="email" type="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="documentUpload" class="form-label">Upload Document (File/Image)</label>
                            <input wire:model="document_path" type="file" id="documentUpload" class="form-control" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="mobile">Mobile *</label>
                            <div class="mobile-input">
                                <input wire:model="country_code_phone" type="text" id="countryCodePhone" class="form-control">
                                <input wire:model="phone" type="tel" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile-travel">Mobile During Travel *</label>
                            <div class="mobile-input">
                                <input wire:model="country_code_travel" type="text" id="countryCodeTravel" class="form-control">
                                <input wire:model="phone_travel" type="tel" id="phoneTravel" class="form-control">
                            </div>
                        </div>
                    </div>
                    <label>
                        <input type="checkbox" checked>
                        I will keep the same mobile number during travel
                    </label>
                </div>
                <button type="submit">Continue to Extras</button>
            </form>
        </main>
        
    </div>
</body>
</html>