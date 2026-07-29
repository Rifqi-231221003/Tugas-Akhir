@extends('layouts.app')

@section('title', 'Privacy Policy - Exachanger | Data Protection & Information Security')

@section('meta_description', 'Read Exachanger privacy policy to understand how we collect, use, and protect your personal information when using our digital currency exchange services. Your privacy matters to us.')

@section('meta_keywords', 'privacy policy, data protection, personal information, digital currency privacy, Exachanger privacy')

@section('canonical', url('/privacy-policy'))

@push('styles')
    <style>
        /* ========================================== */
        /* PRIVACY POLICY PAGE SPECIFIC STYLES */
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

        .privacy-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .privacy-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid #e0e8f0;
        }

        .privacy-card h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4f79a7;
            display: inline-block;
        }

        .privacy-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #4f79a7;
            margin-top: 1.2rem;
            margin-bottom: 0.8rem;
        }

        .privacy-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .privacy-card p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 1rem;
        }

        .privacy-card ul, .privacy-card ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .privacy-card li {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .privacy-card .definition-list {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .privacy-card .definition-item {
            margin-bottom: 15px;
        }

        .privacy-card .definition-term {
            font-weight: 700;
            color: #4f79a7;
            font-size: 1rem;
        }

        .privacy-card .definition-desc {
            color: #555;
            font-size: 0.95rem;
            margin-top: 5px;
            margin-left: 15px;
        }

        .privacy-card .last-updated {
            font-size: 0.9rem;
            color: #888;
            text-align: right;
            margin-bottom: 20px;
            font-style: italic;
        }

        .privacy-card .contact-box {
            background: #e8f4fd;
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            border-left: 5px solid #4f79a7;
        }

        .privacy-card .contact-box p {
            margin-bottom: 0.5rem;
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
            
            .privacy-container {
                margin: 30px auto;
                padding: 0 15px;
            }
            
            .privacy-card {
                padding: 20px;
            }
            
            .privacy-card h2 {
                font-size: 1.3rem;
            }
            
            .privacy-card h3 {
                font-size: 1.1rem;
            }
            
            .privacy-card h4 {
                font-size: 1rem;
            }
            
            .privacy-card p, 
            .privacy-card li,
            .privacy-card .definition-desc {
                font-size: 0.85rem;
            }
            
            .privacy-card .definition-term {
                font-size: 0.9rem;
            }
            
            .privacy-card .definition-list {
                padding: 15px;
            }
            
            .privacy-card .definition-desc {
                margin-left: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Privacy Policy</h1>
            <p>How we collect, use, and protect your personal information</p>
        </div>
    </section>

    <div class="privacy-container">
        <div class="privacy-card">
            <div class="last-updated">
                Last updated: April 19, 2026
            </div>

            <p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p>

            <p>We use Your Personal Data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</p>

            <h2>Interpretation and Definitions</h2>

            <h3>Interpretation</h3>
            <p>The words whose initial letters are capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>

            <h3>Definitions</h3>
            <p>For the purposes of this Privacy Policy:</p>

            <div class="definition-list">
                <div class="definition-item">
                    <div class="definition-term">Account</div>
                    <div class="definition-desc">means a unique account created for You to access our Service or parts of our Service.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Affiliate</div>
                    <div class="definition-desc">means an entity that controls, is controlled by, or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Application</div>
                    <div class="definition-desc">refers to Exachanger, the software program provided by the Company.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Company</div>
                    <div class="definition-desc">(referred to as either "the Company", "We", "Us" or "Our" in this Privacy Policy) refers to Vepay Multipayment International Inc., Perum Green Semanggi Mangrove F1-29 Cluster Osbornia, Surabaya.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Cookies</div>
                    <div class="definition-desc">are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Country</div>
                    <div class="definition-desc">refers to: Indonesia</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Device</div>
                    <div class="definition-desc">means any device that can access the Service such as a computer, a cell phone or a digital tablet.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Personal Data</div>
                    <div class="definition-desc">is any information that relates to an identified or identifiable individual. We use "Personal Data" and "Personal Information" interchangeably unless a law uses a specific term.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Service</div>
                    <div class="definition-desc">refers to the Application or the Website or both.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Service Provider</div>
                    <div class="definition-desc">means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Usage Data</div>
                    <div class="definition-desc">refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">Website</div>
                    <div class="definition-desc">refers to Exachanger, accessible from https://exachanger.com.</div>
                </div>
                <div class="definition-item">
                    <div class="definition-term">You</div>
                    <div class="definition-desc">means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</div>
                </div>
            </div>

            <h2>Collecting and Using Your Personal Data</h2>

            <h3>Types of Data Collected</h3>

            <h4>Personal Data</h4>
            <p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p>
            <ul>
                <li>Email address</li>
                <li>First name and last name</li>
                <li>Phone number</li>
                <li>Address, State, Province, ZIP/Postal code, City</li>
            </ul>

            <h4>Usage Data</h4>
            <p>Usage Data is collected automatically when using the Service.</p>
            <p>Usage Data may include information such as Your Device's Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>
            <p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device's unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p>

            <h4>Information Collected while Using the Application</h4>
            <p>While using Our Application, in order to provide features of Our Application, We may collect, with Your prior permission:</p>
            <ul>
                <li>Pictures and other information from your Device's camera and photo library</li>
            </ul>
            <p>We use this information to provide features of Our Service, to improve and customize Our Service. The information may be uploaded to the Company's servers and/or a Service Provider's server or it may be simply stored on Your device.</p>
            <p>You can enable or disable access to this information at any time, through Your Device settings.</p>

            <h4>Tracking Technologies and Cookies</h4>
            <p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies We use include beacons, tags, and scripts to collect and track information and to improve and analyze Our Service.</p>
            <p>Cookies can be "Persistent" or "Session" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser.</p>
            <p>We use both Session and Persistent Cookies for the purposes set out below:</p>
            <ul>
                <li><strong>Necessary / Essential Cookies:</strong> These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features.</li>
                <li><strong>Cookies Policy / Notice Acceptance Cookies:</strong> These Cookies identify if users have accepted the use of cookies on the Website.</li>
                <li><strong>Functionality Cookies:</strong> These Cookies allow Us to remember choices You make when You use the Website, such as remembering your login details or language preference.</li>
            </ul>

            <h3>Use of Your Personal Data</h3>
            <p>The Company may use Personal Data for the following purposes:</p>
            <ul>
                <li>To provide and maintain our Service, including to monitor the usage of our Service.</li>
                <li>To manage Your Account: to manage Your registration as a user of the Service.</li>
                <li>For the performance of a contract: the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased.</li>
                <li>To contact You: by email, telephone calls, SMS, or other equivalent forms of electronic communication.</li>
                <li>To provide You with news, special offers, and general information about other goods, services and events which We offer.</li>
                <li>To manage Your requests: To attend and manage Your requests to Us.</li>
                <li>For business transfers: We may use Your Personal Data to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets.</li>
                <li>For other purposes: such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service.</li>
            </ul>

            <h3>Retention of Your Personal Data</h3>
            <p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our legal agreements and policies.</p>

            <h3>Transfer of Your Personal Data</h3>
            <p>Your information, including Personal Data, is processed at the Company's operating offices and in any other places where the parties involved in the processing are located. The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy.</p>

            <h3>Delete Your Personal Data</h3>
            <p>You have the right to delete or request that We assist in deleting the Personal Data that We have collected about You. You may update, amend, or delete Your information at any time by signing in to Your Account, if you have one, and visiting the account settings section.</p>

            <h3>Disclosure of Your Personal Data</h3>
            <p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>
            <ul>
                <li>Comply with a legal obligation</li>
                <li>Protect and defend the rights or property of the Company</li>
                <li>Prevent or investigate possible wrongdoing in connection with the Service</li>
                <li>Protect the personal safety of Users of the Service or the public</li>
                <li>Protect against legal liability</li>
            </ul>

            <h3>Security of Your Personal Data</h3>
            <p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially reasonable means to protect Your Personal Data, We cannot guarantee its absolute security.</p>

            <h2>Children's Privacy</h2>
            <p>Our Service does not address anyone under the age of 16. We do not knowingly collect personally identifiable information from anyone under the age of 16. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us.</p>

            <h2>Links to Other Websites</h2>
            <p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party's site. We strongly advise You to review the Privacy Policy of every site You visit.</p>

            <h2>Changes to this Privacy Policy</h2>
            <p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes.</p>

            <div class="contact-box">
                <h3 style="margin-top: 0; color: #2c3e50;">Contact Us</h3>
                <p>If you have any questions about this Privacy Policy, You can contact us:</p>
                <p><i class="fas fa-envelope me-2"></i> By email: <a href="mailto:admin@exachanger.com">admin@exachanger.com</a></p>
                <p><i class="fas fa-globe me-2"></i> By visiting this page on our website: <a href="https://exachanger.com">https://exachanger.com</a></p>
                <p><i class="fab fa-whatsapp me-2"></i> By phone: +62 88296973558</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Additional scripts if needed
    </script>
@endpush