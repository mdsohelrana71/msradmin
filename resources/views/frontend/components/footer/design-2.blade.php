<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ $footer['logo'] ?? asset('frontend/images/logo.png') }}" alt="{{ config('app.name') }}">
                        </a>
                    </div>
                    <ul>
                        {{-- @if ($settings->site_address)
                            <li>Address: {{ $settings->site_address }}</li>
                        @endif --}}
                        @if ($settings->site_phone)
                            <li>Phone: {{ $settings->site_phone }}</li>
                        @endif
                        @if ($settings->site_email)
                            <li>Email: {{ $settings->site_email }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">About Our Shop</a></li>
                        <li><a href="#">Secure Shopping</a></li>
                        <li><a href="#">Delivery Information</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Our Sitemap</a></li>
                    </ul>
                    <ul>
                        <li><a href="#">Who We Are</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Innovation</a></li>
                        <li><a href="#">Testimonials</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>

                    <form action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletterForm">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your mail" required>
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>

                    <div id="newsletterMessage"></div>

                    <div class="footer__widget__social">
                        @if ($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        @if ($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif

                        @if ($settings->twitter_url)
                            <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                        @endif

                        @if ($settings->linkedin_url)
                            <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p>
                            {{ $settings->site_name }}. &copy; {{ date('Y') }}. All Rights Reserved
                        </p>
                    </div>

                    <div class="footer__copyright__payment">
                        <img src="{{ asset('frontend/images/payment-item.png') }}" alt="Payment Methods">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>