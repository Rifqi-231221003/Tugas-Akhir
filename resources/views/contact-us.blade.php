@extends('layouts.app')

@section('title', 'Contact Us - Exachanger | Get in Touch')

@section('meta_description', 'Contact the Exachanger team for questions about digital currency exchange services, support, or partnerships. We are ready to assist you 24/7.')

@section('meta_keywords', 'contact us, customer support, Exachanger contact, digital currency exchange, get in touch')

@section('canonical', url('/contact-us'))

@push('styles')
    <style>
        /* ========================================== */
        /* CONTACT US PAGE SPECIFIC STYLES */
        /* ========================================== */
        .page-header {
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid #e0e8f0;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* ========================================== */
        /* PROPORTIONAL HEIGHT & SPACING */
        /* ========================================== */
        
        /* Make both sections same height */
        .contact-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: stretch;
        }

        /* Form container - takes full height */
        .form-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .form-container h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 0.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4f79a7;
            display: inline-block;
        }

        .form-container > p {
            font-size: 0.85rem;
            margin-bottom: 20px;
            color: #888;
        }

        .form-container .contact-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
        }

        .form-container .contact-form .form-group:last-of-type {
            flex: 1;
        }

        /* Info container - takes full height */
        .info-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .info-container h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 0.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4f79a7;
            display: inline-block;
        }

        .info-container > p {
            font-size: 0.85rem;
            margin-bottom: 20px;
            color: #888;
        }

        .info-container .contact-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
        }

        .form-group label .required {
            color: #e74c3c;
            margin-left: 3px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4f79a7;
            box-shadow: 0 0 0 3px rgba(79, 121, 167, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
            height: calc(100% - 30px);
        }

        .btn-submit {
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 5px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 121, 167, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Info Items */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #4f79a7;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .info-content h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 3px 0;
        }

        .info-content p {
            margin: 0;
            color: #555;
            line-height: 1.4;
            font-size: 0.85rem;
        }

        .info-content a {
            color: #4f79a7;
            text-decoration: none;
        }

        .info-content a:hover {
            text-decoration: underline;
        }

        /* Map Container */
        .map-container {
            flex: 1;
            margin-top: 15px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e8f0;
            background: #e8f0f8;
            min-height: 180px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            min-height: 180px;
            border: 0;
            display: block;
        }

        /* Map Placeholder (if no API key) */
        .map-placeholder {
            width: 100%;
            height: 100%;
            min-height: 180px;
            background: #e8f0f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #4f79a7;
            font-size: 0.85rem;
            gap: 8px;
        }

        .map-placeholder i {
            font-size: 2rem;
            opacity: 0.6;
        }

        .map-placeholder a {
            color: #4f79a7;
            text-decoration: none;
            font-weight: 500;
        }

        /* ========================================== */
        /* MOBILE RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
            }
            
            .page-header h1 {
                font-size: 1.8rem;
            }
            
            .page-header p {
                font-size: 0.9rem;
                padding: 0 15px;
            }
            
            .contact-container {
                margin: 30px auto;
                padding: 0 15px;
            }
            
            .contact-card {
                padding: 20px;
            }
            
            .contact-section {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .form-container h2,
            .info-container h2 {
                font-size: 1.3rem;
            }
            
            .form-container .contact-form,
            .info-container .contact-info {
                padding: 20px;
            }
            
            .btn-submit {
                padding: 12px;
            }
            
            .map-container {
                min-height: 200px;
            }
            
            .map-placeholder {
                min-height: 200px;
                padding: 30px;
            }
        }

        @media (max-width: 480px) {
            .info-item {
                gap: 10px;
                margin-bottom: 14px;
                padding-bottom: 12px;
            }
            
            .info-icon {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .info-content h4 {
                font-size: 0.85rem;
            }
            
            .info-content p {
                font-size: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We're here to help and answer any questions you might have</p>
        </div>
    </section>

    <div class="contact-container">
        <div class="contact-card">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0" style="margin-left: 15px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- One Section: Form + Info Side by Side -->
            <div class="contact-section">
                <!-- Left: Contact Form -->
                <div class="form-container">
                    <h2>Leave us a message!</h2>
                    <p>Fill out the form below and we'll get back to you soon.</p>
                    
                    <form class="contact-form" method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Nama <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Your full name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject <span class="required">*</span></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="Message subject">
                        </div>

                        <div class="form-group">
                            <label for="message">Message <span class="required">*</span></label>
                            <textarea id="message" name="message" required placeholder="Write your message here...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i> Send Message
                        </button>
                    </form>
                </div>

                <!-- Right: Contact Information -->
                <div class="info-container">
                    <h2>Get in Touch</h2>
                    <p>Reach out to us through any of these channels.</p>
                    
                    <div class="contact-info">
                        <!-- WhatsApp -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fab fa-whatsapp fa-fw"></i>
                            </div>
                            <div class="info-content">
                                <h4>WhatsApp</h4>
                                <p><a href="https://wa.me/6288296973558" target="_blank">+62 882 9697 3558</a></p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope fa-fw"></i>
                            </div>
                            <div class="info-content">
                                <h4>Email</h4>
                                <p><a href="mailto:admin@exachanger.com">admin@exachanger.com</a></p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt fa-fw"></i>
                            </div>
                            <div class="info-content">
                                <h4>Address</h4>
                                <p style="color: #666666">Perum Green Semanggi Mangrove F1-29 Cluster Osbornia, Wonorejo, Rungkut, Surabaya, East Java, Indonesia</p>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="map-container">
                            <!-- Gunakan iframe Google Maps (tanpa API key) -->
                            <iframe 
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d18962.112449039403!2d112.80620372611556!3d-7.305785900735023!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f1211e97e3d1%3A0xe39bb38ea3eebd80!2sGreen%20semanggi%20mangrove!5e1!3m2!1sen!2sid!4v1777266547726!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('contactForm')?.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';
        });
    </script>
@endpush