<footer>
    <div class="bg-info">
        <div class="container">
            <div class="row">
            <div class="col-sm-3 col-xs-6">  
                <ul>
                    <li><h5>Company Information</h5></li>
                    <li><a href="{{route('frontend.aboutUs')}}">About Us</a></li>
                    <li><a href="{{route('frontend.corporate')}}">Corporate Info</a></li>
                    <li><a href="{{route('frontend.terms')}}">Terms of Use</a></li>
                    <li><a href="{{route('frontend.privacyPolicy')}}">Privacy Policy</a></li>
                    <li><a href="{{route('frontend.ESignActDisclosure')}}">E-Sign Act Disclosure</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6">
                <ul>
                    <li><h5>Properties & Communication</h5></li>
                    <li><a href="{{route('frontend.saleSearch')}}">For Sale</a></li>
                    <li><a href="{{route('frontend.rentSearch')}}">For Rent</a></li>
                    <li><a href="{{route('frontend.vacationSearch')}}">Timeshares / VRBO</a></li>
                    <li><a href="{{url('/forums')}}">Member Forum</a></li>
                    <li><a href="{{ route('frontend.blogs') }}">Freezylist Blog</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6">
                <ul>
                    <li><h5>Other Information</h5></li>
                    <li><a href="{{ route('frontend.index') }}">Home Page</a></li>
                    <li><a href="{{route('frontend.network.social')}}">Member Network</a></li>
                    <li><a href="{{route('frontend.network.support')}}">Professional Network</a></li>
                    <li><a href="{{route('frontend.help')}}">Help/Support</a></li>
                    <li><a href="{{route('frontend.documentPortal')}}">Document Portal</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-6">
                <ul class="contact_information">
                    <li><h5>Contact Information</h5></li>
                     <li>NARWHAL REALTY, INC</li>
                     <li>Resident Agents, Inc. 8 The</li>
                     <li> Green, STE R Dover, DE 19901</li>
                    <li>Email : <a>info@freezylist.com</a></li>
                    <li class="contact-us"><a href="{{route('frontend.contact')}}">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="bg-black">
        <div class="container">
            <div class="col-sm-12 col-xs-12">
                <span>Copyright <?=date("Y")?> © Narwhal Realty, Inc. All rights reserved.</span>
            </div>
        </div>
    </div>       
</footer>