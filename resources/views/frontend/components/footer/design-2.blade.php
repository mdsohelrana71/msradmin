<footer class="site-footer">
    <div class="container">
        <!-- Newsletter Section -->
        <div class="newsletter-section">
            <h2 class="newsletter-title">Get Special Offers and Savings</h2>
            <p class="newsletter-subtitle">Get all the latest information on Events, Sales and Offers.</p>
            <div class="newsletter-form">
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" class="newsletter-input" placeholder="Enter Your E-mail Address...">
                </div>
                <button class="newsletter-btn">OK</button>
            </div>
        </div>
    </div>

    <!-- Full Width Background Section -->
    <div class="footer-links-section">
        <div class="container">
            <div class="row g-4">
                <!-- Customer Service -->
                <div class="col-6 col-md-3">
                    <h4 class="footer-heading">CUSTOMER SERVICE</h4>
                    <ul class="footer-list">
                        <li><a href="#">Help & FAQs</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Shipping & Delivery</a></li>
                        <li><a href="#">Return & Refund</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>

                <!-- About Us -->
                <div class="col-6 col-md-3">
                    <h4 class="footer-heading">ABOUT US</h4>
                    <ul class="footer-list">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Our Stores</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    </ul>
                </div>

                <!-- More Information -->
                <div class="col-6 col-md-3">
                    <h4 class="footer-heading">MORE INFORMATION</h4>
                    <ul class="footer-list">
                        <li><a href="#">Affiliates</a></li>
                        <li><a href="#">Gift Cards</a></li>
                        <li><a href="#">Size Guide</a></li>
                        <li><a href="#">Refer a Friend</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="col-6 col-md-3">
                    <h4 class="footer-heading">SOCIAL MEDIA</h4>
                    <div class="footer-social">
                        <a href="#" class="footer-social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="footer-social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="footer-copyright">
                    NICK eCommerce. © {{ date('Y') }}. All Rights Reserved
                </div>
                <div class="footer-payments">
                    <i class="fab fa-cc-visa fa-2x" title="Visa"></i>
                    <i class="fab fa-paypal fa-2x" title="PayPal"></i>
                    <i class="fab fa-cc-stripe fa-2x" title="Stripe"></i>
                    <i class="fas fa-shield-alt fa-2x" title="Secure Payment"></i>
                </div>
            </div>
        </div>
    </div>
</footer>