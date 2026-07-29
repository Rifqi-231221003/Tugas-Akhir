<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: EXACHANGER -->
            <div class="col-md-5">
                <h5>EXACHANGER</h5>
                <p style="color: #ccc; line-height: 1.5;">
                    Exachanger will soon launch a mobile app you can download below 🚀
                </p>
                <button class="btn btn-sm btn-outline-light" onclick="alert('Coming soon!')">
                    <i class="fab fa-apple me-1"></i> iOS
                </button>
                <button class="btn btn-sm btn-outline-light ms-2" onclick="alert('Coming soon!')">
                    <i class="fab fa-android me-1"></i> Android
                </button>
            </div>

            <!-- Kolom 2: QUICK LINKS -->
            <div class="col-md-3">
                <h5>QUICK LINKS</h5>
                <ul style="list-style: none; padding-left: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('exchange.rate') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Exchange Rate</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('contact.show') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Contact Us</a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('privacy.policy') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: CONTACT US -->
            <div class="col-md-4">
                <h5>CONTACT US</h5>
                <div class="contact-info">
                    <!-- WhatsApp -->
                    <p style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-whatsapp" style="width: 25px; color: #4f79a7; flex-shrink: 0;"></i> 
                        <span>+62 882 9697 3558</span>
                    </p>
                    
                    <!-- Email -->
                    <p style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="far fa-envelope" style="width: 25px; color: #4f79a7; flex-shrink: 0;"></i> 
                        <span>admin@exachanger.com</span>
                    </p>
                    
                    <!-- Address -->
                    <p style="margin-bottom: 8px; display: flex; align-items: flex-start; gap: 8px;">
                        <i class="fas fa-map-marker-alt" style="width: 25px; color: #4f79a7; flex-shrink: 0; margin-top: 3px;"></i> 
                        <span>Perum Green Semanggi Mangrove F1-29 Cluster Osbornia, Surabaya, East Java, Indonesia</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright (ukuran tetap kecil) -->
        <div class="copyright" style="text-align: center; padding-top: 30px; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1);">
            <p style="margin-bottom: 0; font-size: 0.7rem; color: #888;">
                © 2026 PT. Vepay Multipayment Internasional | All rights reserved.
            </p>
        </div>
    </div>
</footer>

<!-- WhatsApp Chat Button -->
<a href="https://wa.me/6288296973558?text=Hello%20Exachanger%2C%20I%20have%20a%20question%20I%27d%20like%20to%20ask." 
   class="chat-float" target="_blank" style="position: fixed; bottom: 20px; right: 20px; background: #25D366; color: white; width: 55px; height: 55px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 1000; transition: transform 0.3s;">
    <i class="fab fa-whatsapp"></i>
</a>

<style>
    /* Footer styling */
    .footer {
        background: #1a2a3a;
        padding: 50px 0 20px;
        color: #ccc;
    }
    
    .footer h5 {
        color: white;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 20px;
        letter-spacing: 0.5px;
    }
    
    /* Perbesar semua teks di footer (kecuali copyright) */
    .footer p:not(.copyright p),
    .footer li a,
    .contact-info p span,
    .contact-info p {
        font-size: 0.95rem !important;
        color: #ccc;
    }
    
    /* Tombol iOS Android */
    .footer .btn-outline-light {
        font-size: 0.85rem !important;
        padding: 6px 14px;
    }
    
    /* Hover effect for links */
    .footer ul li a:hover {
        color: white !important;
    }
    
    /* Hover effect for WhatsApp button */
    .chat-float:hover {
        transform: scale(1.05);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer {
            text-align: center;
        }
        
        .footer .col-md-5, 
        .footer .col-md-3, 
        .footer .col-md-4 {
            margin-bottom: 30px;
            width: 100%;
        }
        
        .footer .col-md-4:last-child {
            margin-bottom: 0;
        }
        
        .footer ul {
            padding-left: 0;
        }
        
        .contact-info p {
            justify-content: center;
            text-align: left;
            display: flex !important;
        }
        
        .chat-float {
            width: 45px;
            height: 45px;
            font-size: 24px;
            bottom: 15px;
            right: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .footer {
            padding: 40px 0 15px;
        }
        
        .footer h5 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        
        .footer p:not(.copyright p),
        .footer li a,
        .contact-info p span,
        .contact-info p {
            font-size: 0.85rem !important;
        }
        
        .footer .btn-outline-light {
            font-size: 0.75rem !important;
            padding: 5px 10px;
        }
        
        /* Copyright tetap kecil di HP juga */
        .copyright p {
            font-size: 0.65rem !important;
        }
    }
</style>