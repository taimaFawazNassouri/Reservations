<div id="search_flight_tab1" class="search_flight_tab" >

    <ul class="tabs--small tabs--tabled flightSelOpts">
        <li class="is-tab-active"><a href="javascript:void(0)" wire:click.prevent="$set('tripType','round-trip')"  onclick="updateSearchFlight('frm_round_trip', this)">ROUND TRIP</a></li>
        <li><a href="javascript:void(0)" wire:click.prevent="$set('tripType','one-way')" onclick="updateSearchFlight('frm_oneway_trip', this)">One Way</a></li>
        <!--<li><a href="https://reservations.chamwings.com/ibe/public/showReservation.action?hdnParamData=EN^MC^USD" target="_blank">Multi-City</a></li>-->
        <!--<li><a href="#">Multi-City</a></li>-->
    </ul>
    <div class="tabs--small-content">
        <div class="formwrap">
           <form wire:submit.prevent="submitted" id="search_flight" name="search_flight">
                <table class="formtable table--bordered" id="tbl_srch_flights">
                    <tr>
                       <td>From<span class="required">*</span>
                            <select name="selFromLoc" class="field--location" onchange="updateSelectText(this)">
                                <option value=''>--</option>
                                <option value='DAM'>Damascus International Airport (DAM)</option>
                                <option value='LTK'>Latakia Bassel Al-Assad International Airport (LTK)</option>
                                <option value='ALP'>Aleppo International Airport (ALP)</option>
                                <option value='BGW'>Baghdad International Airport (BGW)</option>
                                <option value='BSR'>Basra International Airport (BSR)</option>
                                <option value='BEY'>Beirut Rafic Hariri International Airport (BEY)</option>
                                <option value='BEN'>Benghazi Benina International Airport (BEN)</option>
                                <option value='EBL'>Erbil International Airport (EBL)</option>
                                <option value='KAC'>Kamishly Airport (KAC)</option>
                                <option value='KRT'>Khartoum International Airport (KRT)</option>
                                <option value='KWI'>Kuwait International Airport (KWI)</option>
                                <option value='MCT'>Muscat International Airport (MCT)</option>
                                <option value='NJF'>Al Najaf International Airport (NJF)</option>
                                <option value='IKA'>Tehran International Airport (IKA)</option>
                                <option value='SHJ'>Sharjah International Airport (SHJ)</option>
                                <option value='SVO'>Moscow Sheremetyevo International Airport (SVO)</option>
                                <option value='EVN'>Yerevan - Zvartnots International Airport (EVN)</option>
                                <option value='AUH'>Abu Dhabi International Airport (AUH)</option>
                                <option value='KHI'>Karachi - Jinnah International Airport (KHI)</option>
                            </select>
                        </td>
                        <td>To<span class="required">*</span>
                            <select wire:model="to" class="field--location" onchange="updateSelectText(this)">
                                <option value=''>--</option>
                                <option value='DAM'>Damascus International Airport (DAM)</option>
                                <option value='LTK'>Latakia Bassel Al-Assad International Airport (LTK)</option>
                                <option value='ALP'>Aleppo International Airport (ALP)</option>
                                <option value='BGW'>Baghdad International Airport (BGW)</option>
                                <option value='BSR'>Basra International Airport (BSR)</option>
                                <option value='BEY'>Beirut Rafic Hariri International Airport (BEY)</option>
                                <option value='BEN'>Benghazi Benina International Airport (BEN)</option>
                                <option value='EBL'>Erbil International Airport (EBL)</option>
                                <option value='KAC'>Kamishly Airport (KAC)</option>
                                <option value='KRT'>Khartoum International Airport (KRT)</option>
                                <option value='KWI'>Kuwait International Airport (KWI)</option>
                                <option value='MCT'>Muscat International Airport (MCT)</option>
                                <option value='NJF'>Al Najaf International Airport (NJF)</option>
                                <option value='IKA'>Tehran International Airport (IKA)</option>
                                <option value='SHJ'>Sharjah International Airport (SHJ)</option>
                                <option value='SVO'>Moscow Sheremetyevo International Airport (SVO)</option>
                                <option value='EVN'>Yerevan - Zvartnots International Airport (EVN)</option>
                                <option value='AUH'>Abu Dhabi International Airport (AUH)</option>
                                <option value='KHI'>Karachi - Jinnah International Airport (KHI)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>DEPART DATE<span class="required">*</span><input type="text" readonly class="field--calender" id="depart-date" wire:model="selDepartureDate" placeholder="dd/mm/yyyy">                        
                        <td><span id="return_date_title">Return DATE</span><span id="is_required_star" class="required">*</span><input type="text" readonly class="field--calender" id="return-date" wire:model="elReturnDate" placeholder="dd/mm/yyyy">                        
                    </tr>
                    <tr>
                        <td>
                           Adults                                         
                           <label class="cover--select">
                               <select id="adults" wire:model="adults">
                                   <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </label>
                        </td>
                        <td>
                            Children                                                                 
                            <label class="cover--select">
                                <select wire:model="children">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                    <td>
                        Infants                                                
                        <label class="cover--select">
                            <select id="infants" wire:model="infants">                       
                            </select>
                        </label>
                    </td>
                    <td>
                        Class
                        <label class="cover--select">
                            <select name="selCOS">
                                <option value="Y">Economy Class</option>
                                <option value="C">Business Class</option>
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        Origin                                                
                        <label class="cover--select">
                            <select name="selOrigin">
                                <option value="AFG">Afghanistan</option>
                                <option value="ALA">Åland Islands</option>
                                <option value="ALB">Albania</option>
                                <option value="DZA">Algeria</option>
                                <option value="ASM">American Samoa</option>
                                <option value="AND">Andorra</option>
                                <option value="AGO">Angola</option>
                                <option value="AIA">Anguilla</option>
                                <option value="ATA">Antarctica</option>
                                <option value="ATG">Antigua and Barbuda</option>
                                <option value="ARG">Argentina</option>
                                <option value="ARM">Armenia</option>
                                <option value="ABW">Aruba</option>
                                <option value="AUS">Australia</option>
                                <option value="AUT">Austria</option>
                                <option value="AZE">Azerbaijan</option>
                                <option value="BHS">Bahamas</option>
                                <option value="BHR">Bahrain</option>
                                <option value="BGD">Bangladesh</option>
                                <option value="BRB">Barbados</option>
                                <option value="BLR">Belarus</option>
                                <option value="BEL">Belgium</option>
                                <option value="BLZ">Belize</option>
                                <option value="BEN">Benin</option>
                                <option value="BMU">Bermuda</option>
                                <option value="BTN">Bhutan</option>
                                <option value="BOL">Bolivia, Plurinational State of</option>
                                <option value="BES">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BIH">Bosnia and Herzegovina</option>
                                <option value="BWA">Botswana</option>
                                <option value="BVT">Bouvet Island</option>
                                <option value="BRA">Brazil</option>
                                <option value="IOT">British Indian Ocean Territory</option>
                                <option value="BRN">Brunei Darussalam</option>
                                <option value="BGR">Bulgaria</option>
                                <option value="BFA">Burkina Faso</option>
                                <option value="BDI">Burundi</option>
                                <option value="KHM">Cambodia</option>
                                <option value="CMR">Cameroon</option>
                                <option value="CAN">Canada</option>
                                <option value="CPV">Cape Verde</option>
                                <option value="CYM">Cayman Islands</option>
                                <option value="CAF">Central African Republic</option>
                                <option value="TCD">Chad</option>
                                <option value="CHL">Chile</option>
                                <option value="CHN">China</option>
                                <option value="CXR">Christmas Island</option>
                                <option value="CCK">Cocos (Keeling) Islands</option>
                                <option value="COL">Colombia</option>
                                <option value="COM">Comoros</option>
                                <option value="COG">Congo</option>
                                <option value="COD">Congo, the Democratic Republic of the</option>
                                <option value="COK">Cook Islands</option>
                                <option value="CRI">Costa Rica</option>
                                <option value="CIV">Côte d'Ivoire</option>
                                <option value="HRV">Croatia</option>
                                <option value="CUB">Cuba</option>
                                <option value="CUW">Curaçao</option>
                                <option value="CYP">Cyprus</option>
                                <option value="CZE">Czech Republic</option>
                                <option value="DNK">Denmark</option>
                                <option value="DJI">Djibouti</option>
                                <option value="DMA">Dominica</option>
                                <option value="DOM">Dominican Republic</option>
                                <option value="ECU">Ecuador</option>
                                <option value="EGY">Egypt</option>
                                <option value="SLV">El Salvador</option>
                                <option value="GNQ">Equatorial Guinea</option>
                                <option value="ERI">Eritrea</option>
                                <option value="EST">Estonia</option>
                                <option value="ETH">Ethiopia</option>
                                <option value="FLK">Falkland Islands (Malvinas)</option>
                                <option value="FRO">Faroe Islands</option>
                                <option value="FJI">Fiji</option>
                                <option value="FIN">Finland</option>
                                <option value="FRA">France</option>
                                <option value="GUF">French Guiana</option>
                                <option value="PYF">French Polynesia</option>
                                <option value="ATF">French Southern Territories</option>
                                <option value="GAB">Gabon</option>
                                <option value="GMB">Gambia</option>
                                <option value="GEO">Georgia</option>
                                <option value="DEU">Germany</option>
                                <option value="GHA">Ghana</option>
                                <option value="GIB">Gibraltar</option>
                                <option value="GRC">Greece</option>
                                <option value="GRL">Greenland</option>
                                <option value="GRD">Grenada</option>
                                <option value="GLP">Guadeloupe</option>
                                <option value="GUM">Guam</option>
                                <option value="GTM">Guatemala</option>
                                <option value="GGY">Guernsey</option>
                                <option value="GIN">Guinea</option>
                                <option value="GNB">Guinea-Bissau</option>
                                <option value="GUY">Guyana</option>
                                <option value="HTI">Haiti</option>
                                <option value="HMD">Heard Island and McDonald Islands</option>
                                <option value="VAT">Holy See (Vatican City State)</option>
                                <option value="HND">Honduras</option>
                                <option value="HKG">Hong Kong</option>
                                <option value="HUN">Hungary</option>
                                <option value="ISL">Iceland</option>
                                <option value="IND">India</option>
                                <option value="IDN">Indonesia</option>
                                <option value="IRN">Iran, Islamic Republic of</option>
                                <option value="IRQ">Iraq</option>
                                <option value="IRL">Ireland</option>
                                <option value="IMN">Isle of Man</option>
                                <option value="ITA">Italy</option>
                                <option value="JAM">Jamaica</option>
                                <option value="JPN">Japan</option>
                                <option value="JEY">Jersey</option>
                                <option value="JOR">Jordan</option>
                                <option value="KAZ">Kazakhstan</option>
                                <option value="KEN">Kenya</option>
                                <option value="KIR">Kiribati</option>
                                <option value="PRK">Korea, Democratic People's Republic of</option>
                                <option value="KOR">Korea, Republic of</option>
                                <option value="KWT">Kuwait</option>
                                <option value="KGZ">Kyrgyzstan</option>
                                <option value="LAO">Lao People's Democratic Republic</option>
                                <option value="LVA">Latvia</option>
                                <option value="LBN">Lebanon</option>
                                <option value="LSO">Lesotho</option>
                                <option value="LBR">Liberia</option>
                                <option value="LBY">Libya</option>
                                <option value="LIE">Liechtenstein</option>
                                <option value="LTU">Lithuania</option>
                                <option value="LUX">Luxembourg</option>
                                <option value="MAC">Macao</option>
                                <option value="MKD">Macedonia, the former Yugoslav Republic of</option>
                                <option value="MDG">Madagascar</option>
                                <option value="MWI">Malawi</option>
                                <option value="MYS">Malaysia</option>
                                <option value="MDV">Maldives</option>
                                <option value="MLI">Mali</option>
                                <option value="MLT">Malta</option>
                                <option value="MHL">Marshall Islands</option>
                                <option value="MTQ">Martinique</option>
                                <option value="MRT">Mauritania</option>
                                <option value="MUS">Mauritius</option>
                                <option value="MYT">Mayotte</option>
                                <option value="MEX">Mexico</option>
                                <option value="FSM">Micronesia, Federated States of</option>
                                <option value="MDA">Moldova, Republic of</option>
                                <option value="MCO">Monaco</option>
                                <option value="MNG">Mongolia</option>
                                <option value="MNE">Montenegro</option>
                                <option value="MSR">Montserrat</option>
                                <option value="MAR">Morocco</option>
                                <option value="MOZ">Mozambique</option>
                                <option value="MMR">Myanmar</option>
                                <option value="NAM">Namibia</option>
                                <option value="NRU">Nauru</option>
                                <option value="NPL">Nepal</option>
                                <option value="NLD">Netherlands</option>
                                <option value="NCL">New Caledonia</option>
                                <option value="NZL">New Zealand</option>
                                <option value="NIC">Nicaragua</option>
                                <option value="NER">Niger</option>
                                <option value="NGA">Nigeria</option>
                                <option value="NIU">Niue</option>
                                <option value="NFK">Norfolk Island</option>
                                <option value="MNP">Northern Mariana Islands</option>
                                <option value="NOR">Norway</option>
                                <option value="OMN">Oman</option>
                                <option value="PAK">Pakistan</option>
                                <option value="PLW">Palau</option>
                                <option value="PSE">Palestinian Territory, Occupied</option>
                                <option value="PAN">Panama</option>
                                <option value="PNG">Papua New Guinea</option>
                                <option value="PRY">Paraguay</option>
                                <option value="PER">Peru</option>
                                <option value="PHL">Philippines</option>
                                <option value="PCN">Pitcairn</option>
                                <option value="POL">Poland</option>
                                <option value="PRT">Portugal</option>
                                <option value="PRI">Puerto Rico</option>
                                <option value="QAT">Qatar</option>
                                <option value="REU">Réunion</option>
                                <option value="ROU">Romania</option>
                                <option value="RUS">Russian Federation</option>
                                <option value="RWA">Rwanda</option>
                                <option value="BLM">Saint Barthélemy</option>
                                <option value="SHN">Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="KNA">Saint Kitts and Nevis</option>
                                <option value="LCA">Saint Lucia</option>
                                <option value="MAF">Saint Martin (French part)</option>
                                <option value="SPM">Saint Pierre and Miquelon</option>
                                <option value="VCT">Saint Vincent and the Grenadines</option>
                                <option value="WSM">Samoa</option>
                                <option value="SMR">San Marino</option>
                                <option value="STP">Sao Tome and Principe</option>
                                <option value="SAU">Saudi Arabia</option>
                                <option value="SEN">Senegal</option>
                                <option value="SRB">Serbia</option>
                                <option value="SYC">Seychelles</option>
                                <option value="SLE">Sierra Leone</option>
                                <option value="SGP">Singapore</option>
                                <option value="SXM">Sint Maarten (Dutch part)</option>
                                <option value="SVK">Slovakia</option>
                                <option value="SVN">Slovenia</option>
                                <option value="SLB">Solomon Islands</option>
                                <option value="SOM">Somalia</option>
                                <option value="ZAF">South Africa</option>
                                <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                <option value="SSD">South Sudan</option>
                                <option value="ESP">Spain</option>
                                <option value="LKA">Sri Lanka</option>
                                <option value="SDN">Sudan</option>
                                <option value="SUR">Suriname</option>
                                <option value="SJM">Svalbard and Jan Mayen</option>
                                <option value="SWZ">Swaziland</option>
                                <option value="SWE">Sweden</option>
                                <option value="CHE">Switzerland</option>
                                <option value="SYR" selected>Syrian Arab Republic</option>
                                <option value="TWN">Taiwan, Province of China</option>
                                <option value="TJK">Tajikistan</option>
                                <option value="TZA">Tanzania, United Republic of</option>
                                <option value="THA">Thailand</option>
                                <option value="TLS">Timor-Leste</option>
                                <option value="TGO">Togo</option>
                                <option value="TKL">Tokelau</option>
                                <option value="TON">Tonga</option>
                                <option value="TTO">Trinidad and Tobago</option>
                                <option value="TUN">Tunisia</option>
                                <option value="TUR">Turkey</option>
                                <option value="TKM">Turkmenistan</option>
                                <option value="TCA">Turks and Caicos Islands</option>
                                <option value="TUV">Tuvalu</option>
                                <option value="UGA">Uganda</option>
                                <option value="UKR">Ukraine</option>
                                <option value="ARE">United Arab Emirates</option>
                                <option value="GBR">United Kingdom</option>
                                <option value="USA">United States</option>
                                <option value="UMI">United States Minor Outlying Islands</option>
                                <option value="URY">Uruguay</option>
                                <option value="UZB">Uzbekistan</option>
                                <option value="VUT">Vanuatu</option>
                                <option value="VEN">Venezuela, Bolivarian Republic of</option>
                                <option value="VNM">Viet Nam</option>
                                <option value="VGB">Virgin Islands, British</option>
                                <option value="VIR">Virgin Islands, U.S.</option>
                                <option value="WLF">Wallis and Futuna</option>
                                <option value="ESH">Western Sahara</option>
                                <option value="YEM">Yemen</option>
                                <option value="ZMB">Zambia</option>
                                <option value="ZWE">Zimbabwe</option>
                            </select>
                        </label>
                    </td>
                    <td>
                        Currency
                        <label class="cover--select">
                            <select name="selCurrency">
                                                                                          
                                <option value="AED" >AED</option>
                                                                                            
                                <option value="EUR" >EUR</option>
                                                                                            
                                <option value="KWD" >KWD</option>
                                                                                            
                                <option value="OMR" >OMR</option>
                                                                                            
                                <option value="RUB" >RUB</option>
                                                                                            
                                <option value="SAR" >SAR</option>
                                                                                            
                                <option value="SDG" >SDG</option>
                                                                                            
                                <option value="SYP" selected>SYP</option>
                                                                                            
                                <option value="QAR" >QAR</option>
                                                                                            
                                <option value="USD" >USD</option>
                                 
                            </select>
                        </label> 
                      
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:45px;padding:10px;background:#AE8A3B;">
                        <div class="agreement-container">
                            <label>
                                <span style="cursor: pointer;display:inline-block;margin-left:30px;width:90%;height:25px;vertical-align: middle;margin-top: -3px;line-height: 1.5;">I declare that I have accepted the Terms and Regulations below.</span>
                                <input type="checkbox" id="isAgree" name="isAgree">
                                <span class="checkmark"></span>
                            </label>
                            <br><br>
                            <div style="text-align:left;">
                                <dfn> ⓘ Agreement Details                                                    
                                    <object class="dfn-tooltip" style="background: white;">
                                        <p style="text-align:center;padding: 0 32px 0 0;font-size: small;"><b>Agreement Details</b></p>
                                        <p style="text-align:left; padding:16px;font-size: x-small;">
                                            • All information provided is upon traveler responsibility.<br>
                                            • All reservations through the website are subject to the terms and conditions related to the process of re-fund or modifying the ticket.<br>
                                            • The company has the right to ascertain the nationality of the traveler when opening the boarding gate.<br>
                                            • The company has the right to cancel any reservation if the information entered by the traveler is incorrect.<br>
                                            • All information entered will only be used within the scope of the reservation process.<br>
                                            • Cash On Hold should be paid from the country of issuance.<br>
                                            • All Reservations which are booked from Syria are subjective to Central Bank of Syria authority and regulations.<br>
                                            • Reservation made through web, not valid to issue in Iran or Pakistan.<br> 
                                        </p>
                                    </object>
                                </dfn>
                            </div>
                        </div>
                    </td> 
                    </tr>     
                    <tr>
                        <td colspan="2" style="height:0;">
                            <span style="color:red" id="error1"></span><span style="color:red" id="error"></span><span style="color:red" id="con_error"></span>
                        </td>
                    </tr>
                    <tr class="srchFlightRes">
                        <td colspan="2"></td>
                    </tr>
                    <tr class="last">
                        <td colspan="2">
                            <input type="hidden" name="chkReturnTrip" value="true"/>
                            <!--<input type="hidden" name="selCurrency" value="USD"/>-->
                            <input type="hidden" name="selLanguage" value="en"/>
                            <input type="submit" value="Submit" onclick="return validate();">
                        </td>
                    </tr>
                 </table>
            </form>
        </div>
    </div>
</div>
