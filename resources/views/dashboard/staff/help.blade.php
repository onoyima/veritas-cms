@extends('layouts.staff')

@section('content')
<style>
    /* Custom Cursor Styling */
    .cms-demo-area {
        cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23114629" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"></path><path d="M13 13l6 6"></path></svg>'), auto;
    }

    /* Animation Keyframes */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(17, 70, 41, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(17, 70, 41, 0); }
        100% { box-shadow: 0 0 0 0 rgba(17, 70, 41, 0); }
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Element Styles */
    .feature-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: #114629;
    }

    .feature-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(17, 70, 41, 0.1);
        color: #114629;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon-wrapper {
        background: #114629;
        color: white;
        animation: pulse-ring 2s infinite;
    }

    .demo-cursor {
        position: absolute;
        width: 20px;
        height: 20px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23114629'%3E%3Cpath d='M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        pointer-events: none;
        z-index: 100;
        transition: all 0.5s ease-out;
    }

    .demo-click-effect {
        position: absolute;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #114629;
        opacity: 0;
        transform: scale(0.5);
        pointer-events: none;
    }

    .animate-click {
        animation: click-ripple 0.6s ease-out forwards;
    }

    @keyframes click-ripple {
        0% { opacity: 1; transform: scale(0.5); }
        100% { opacity: 0; transform: scale(1.5); }
    }

    .hero-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(17,70,41,0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .step-badge {
        width: 30px;
        height: 30px;
        background: #114629;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    /* Staggered Animation for List Items */
    .animate-stagger > * {
        opacity: 0;
        animation: slideInUp 0.5s ease-out forwards;
    }
    .animate-stagger > *:nth-child(1) { animation-delay: 0.1s; }
    .animate-stagger > *:nth-child(2) { animation-delay: 0.2s; }
    .animate-stagger > *:nth-child(3) { animation-delay: 0.3s; }
    .animate-stagger > *:nth-child(4) { animation-delay: 0.4s; }

</style>

<div class="container-fluid px-4 pb-5">
    <!-- Hero Header -->
    <div class="hero-section p-5 mb-5 mt-4 text-center">
        <h1 class="display-4 fw-bold text-dark mb-3" style="font-family: 'Instrument Sans', sans-serif;">Master the Veritas CMS</h1>
        <p class="lead text-muted mb-4" style="max-width: 700px; margin: 0 auto;">
            Your complete guide to managing the university website content. Learn how to edit pages, publish news, manage personnel, and more with our intuitive tools.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#interactive-demo" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                <i class="fas fa-play me-2"></i> Watch Demo
            </a>
            <a href="#quick-start" class="btn btn-outline-dark btn-lg px-4 rounded-pill">
                <i class="fas fa-rocket me-2"></i> Quick Start
            </a>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="row g-4 mb-5 animate-stagger">
        <div class="col-md-4">
            <div class="card feature-card h-100 p-4 border-0 bg-white shadow-sm rounded-4">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-edit fa-xl"></i>
                </div>
                <h4 class="fw-bold mb-3">Content Editing</h4>
                <p class="text-muted">Easily update page content using our block-based editor. No coding knowledge required—just point, click, and type.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 p-4 border-0 bg-white shadow-sm rounded-4">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-newspaper fa-xl"></i>
                </div>
                <h4 class="fw-bold mb-3">News & Events</h4>
                <p class="text-muted">Keep the community informed. Publish latest news articles and schedule upcoming university events with ease.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 p-4 border-0 bg-white shadow-sm rounded-4">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-users fa-xl"></i>
                </div>
                <h4 class="fw-bold mb-3">Staff Directory</h4>
                <p class="text-muted">Manage personnel profiles, roles, and department assignments to keep the directory up-to-date.</p>
            </div>
        </div>
    </div>

    <!-- Interactive Demo Section -->
    <div id="interactive-demo" class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-laptop-code me-2"></i> Interactive Walkthrough</h5>
            <span class="badge bg-success bg-opacity-25 text-success border border-success">Live Preview</span>
        </div>
        <div class="card-body p-0 position-relative bg-light cms-demo-area" style="height: 500px;">
            <!-- Simulated Interface -->
            <div class="d-flex h-100">
                <!-- Simulated Sidebar -->
                <div class="bg-dark text-white p-3" style="width: 250px; opacity: 0.9;">
                    <div class="mb-4 text-uppercase small text-white-50 fw-bold">Menu</div>
                    <div class="d-flex align-items-center mb-3 text-warning">
                        <i class="fas fa-gauge me-2"></i> Dashboard
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-file-lines me-2"></i> Pages
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-newspaper me-2"></i> News
                    </div>
                </div>
                
                <!-- Simulated Content -->
                <div class="flex-grow-1 p-4">
                    <div class="bg-white rounded shadow-sm p-4 mb-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">News Management</h4>
                            <button class="btn btn-success btn-sm demo-target-1">
                                <i class="fas fa-plus me-1"></i> Add New
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr><th>Title</th><th>Date</th><th>Action</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>University Rankings 2024</td>
                                        <td>Oct 12, 2024</td>
                                        <td><button class="btn btn-outline-primary btn-sm demo-target-2"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>New Science Block Opening</td>
                                        <td>Oct 10, 2024</td>
                                        <td><button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animated Cursor Overlay -->
            <div id="demoCursor" class="demo-cursor" style="top: 50%; left: 50%;"></div>
            <div id="clickEffect" class="demo-click-effect"></div>

            <!-- Demo Explanation Overlay -->
            <div id="demoTooltip" class="position-absolute bg-dark text-white p-3 rounded shadow-lg" style="bottom: 20px; right: 20px; max-width: 300px; transition: all 0.3s ease;">
                <h6 class="text-warning mb-1"><i class="fas fa-info-circle me-1"></i> Quick Tour</h6>
                <p class="small mb-0" id="demoText">Welcome to the CMS! Let's show you how to manage content.</p>
            </div>
        </div>
    </div>

    <!-- Quick Start Guide (Accordion) -->
    <div id="quick-start" class="row justify-content-center">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4 text-center">Frequently Asked Questions</h3>
            <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden bg-white" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <span class="step-badge">1</span> How do I get access to edit the website?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Access is role-based. If you see a "No Access" message, you need to contact the ICT Department. They will assign you a specific role (e.g., Editor, Author) based on your department's needs.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <span class="step-badge">2</span> Can I edit any page on the website?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            <strong>Super Admins</strong> can edit all pages. <strong>Editors</strong> generally have access to most content. Some roles are restricted to specific sections (e.g., a "News Editor" can only post news).
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <span class="step-badge">3</span> How do I upload images or documents?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            When editing a page or news article, look for the "Upload Image" or "Attachment" fields. Click "Choose File" to select a file from your computer. Supported formats include JPG, PNG, and PDF.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support Box -->
            <div class="bg-primary bg-opacity-10 rounded-4 p-4 mt-5 text-center border border-primary border-opacity-25">
                <h4 class="fw-bold text-primary mb-2">Still need help?</h4>
                <p class="text-dark mb-4">The ICT Department is here to assist you with any technical issues or access requests.</p>
                <a href="mailto:ict@veritas.edu.ng" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-envelope me-2"></i> Contact ICT Support
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Demo Animation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cursor = document.getElementById('demoCursor');
        const clickEffect = document.getElementById('clickEffect');
        const tooltipText = document.getElementById('demoText');
        const demoArea = document.querySelector('.cms-demo-area');
        
        // Define animation steps
        const steps = [
            { x: '10%', y: '50%', text: "Navigate using the sidebar menu on the left." },
            { x: '80%', y: '20%', text: "Click 'Add New' to create content." },
            { x: '80%', y: '20%', click: true, text: "Clicking opens the editor..." },
            { x: '85%', y: '55%', text: "Or click the Edit icon to update existing items." },
            { x: '85%', y: '55%', click: true, text: "Updating is instant and secure." }
        ];

        let currentStep = 0;

        function runAnimation() {
            if (currentStep >= steps.length) {
                currentStep = 0; // Loop
            }

            const step = steps[currentStep];
            
            // Move cursor
            cursor.style.left = step.x;
            cursor.style.top = step.y;
            tooltipText.textContent = step.text;

            // Handle Click Effect
            if (step.click) {
                setTimeout(() => {
                    clickEffect.style.left = step.x;
                    clickEffect.style.top = step.y;
                    clickEffect.classList.remove('animate-click');
                    void clickEffect.offsetWidth; // Trigger reflow
                    clickEffect.classList.add('animate-click');
                }, 500); // Wait for cursor to arrive
            }

            currentStep++;
            setTimeout(runAnimation, 2500); // Wait before next step
        }

        // Start animation loop
        setTimeout(runAnimation, 1000);
    });
</script>
@endsection
