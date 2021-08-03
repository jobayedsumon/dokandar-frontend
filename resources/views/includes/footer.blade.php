<footer class="mainfooter" role="contentinfo">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <!--Column1-->
                    <div class="footer-pad">
                        <img src="{{ asset('images/logos/logo_user.png') }}" class="img img-fluid" width="50px" />
                        <p class="text-sm">Dokandar is a trusted online shopping in Baipyl | Cash on Delivery | Home Delivery |</p>
                        <br>
                        <p class="text-xs">Address:
                            Baipyl, Savar, Dhaka. <br>
                            Phone:
                            01687388839 <br>
                            Email:
                            Info@dokandar.xyz</p>
                        <br>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <!--Column1-->
                    <div class="footer-pad">
                        <h4 class="mb-2">OUR POLICY</h4>
                        <ul class="list-unstyled">
                            <li><a href="#">Seller Policy</a></li>
                            <li><a href="#">Return Policy</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <!--Column1-->
                    <div class="footer-pad">
                        <h4 class="mb-2">MY ACCOUNT</h4>
                        <ul class="list-unstyled">
                            @auth
                                <li><a href="{{ route('logout') }}">Logout</a></li>
                            @endauth
                            @guest
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                @endguest



                            <li><a href="{{ route('my-account') }}">Order History</a></li>
                            <li><a href="{{ route('my-account') }}">Addresses</a></li>

                            <li>
                                <a href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <h4 class="mb-2">Follow Us</h4>
                    <ul class="social-network social-circle">
                        <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="icoInstagram" title="instagram"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" class="icoTwitter" title="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="icoYoutube" title="youtube"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 copy">
                    <p class="text-center">&copy; Copyright {{ date('Y') }} - Dokandar.  All rights reserved.</p>
                    <p style="font-size: 10px" class="text-center"> Developed By - <a target="_blank" style="font-size: 10px" href="http://jobayedsumon.tech">Jobayed Sumon</a></p>
                </div>
            </div>


        </div>
    </div>
</footer>
