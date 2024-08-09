<div class="container">
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if($this->ticketAdvisory)
    <p>
        Details:
        - Flight Number: {{$this->goingTrip->FlightNumber}}
        - Departure: {{$this->goingTrip->DepartureDateTime}} from {{$this->goingTrip->DepartureAirport}}
        - Arrival: {{ $this->goingTrip->ArrivalDateTime }} at {{  $this->goingTrip->ArrivalAirport }}}";
    </p>
    @endif
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
    