<div class="container mt-5">
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <p>{{ $this->ticketAdvisory }}</p>
    <h2>Traveler Information Form</h2>
    <!-- Traveler and Contact Information Form -->
    <form wire:submit.prevent="submitDetails" id="travelerForm" class="mt-4">
        <!-- Adult Information Section -->
        <h3>Mandatory Fields *Adult 1</h3>
        <!-- Title, First Name, Last Name -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="title" class="form-label">Title *</label>
                <select wire:model="title" id="title" class="form-control" required>
                    <option value="" selected>Select your title</option>
                    <option value="MR">Mr</option>
                    <option value="MS">Ms</option>
                    <option value="MRS">Mrs</option>
                    <option value="DR">Dr</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="firstName" class="form-label">First Name *</label>
                <input wire:model="first_name" type="text" id="firstName" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="lastName" class="form-label">Last Name *</label>
                <input wire:model="last_name" type="text" id="lastName" class="form-control" required>
            </div>
        </div>

        <!-- Nationality, Date of Birth -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality *</label>
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
            <div class="col-md-6">
                <label for="dob" class="form-label">Date of Birth *</label>
                <input wire:model="date_of_birth" type="date" id="dob" class="form-control" required>
            </div>
        </div>

        <!-- Passport, Passport Issued Country, Passport Expiry -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="passport" class="form-label">Passport Number *</label>
                <input wire:model="passport_number" type="text" id="passport" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="passportCountry" class="form-label">Passport Issued Country *</label>
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
            <div class="col-md-4">
                <label for="passportExpiry" class="form-label">Passport Expiry Date *</label>
                <input wire:model="passport_expiry_date" type="date" id="passportExpiry" class="form-control" required>
            </div>
        </div>

        <!-- Contact Information Section -->
        <h3 class="mt-5">Contact Information Mandatory Fields *</h3>

        <!-- City, Country of Residence -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="city" class="form-label">City *</label>
                <input wire:model="city" type="text" id="city" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="countryResidence" class="form-label">Country of Residence *</label>
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

        <!-- Email Address, Document Upload -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email Address *</label>
                <input wire:model="email" type="email" id="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="documentUpload" class="form-label">Upload Document (File/Image)</label>
                <input wire:model="document_path" type="file" id="documentUpload" class="form-control" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png">
            </div>
        </div>

        <!-- Mobile, Country Code, Phone, Mobile During Travel, Country Code, Phone -->
        <div class="row mb-3">
            <label for="mobile" class="form-label">Mobile *</label>
            <div class="col-md-2">
                <label for="countryCodePhone" class="form-label">Country Code (Phone)</label>
                <input wire:model="country_code_phone" type="text" id="countryCodePhone" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input wire:model="phone" type="tel" id="phone" class="form-control">
            </div>
        </div>


        <!-- Phone, Phone (During Travel) -->
        <div class="row mb-3">
            <label for="mobileDuringTravel" class="form-label">Mobile During Travel *</label>
            <div class="col-md-2">
                <label for="countryCodeTravel" class="form-label">Country Code (Travel)</label>
                <input wire:model="country_code_travel" type="text" id="countryCodeTravel" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="phoneTravel" class="form-label">Phone (During Travel)</label>
                <input wire:model="phone_travel" type="tel" id="phoneTravel" class="form-control">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary w-50">Continue to Extras</button>
        </div>
    </form>
</div>
