/* ========================================
   NASKAH PRIMA - MAIN JAVASCRIPT
   Mobile-First Interactive Features
   ======================================== */

(function() {
    'use strict';
    
    // ===== DOM ELEMENTS =====
    const navbar = document.getElementById('navbar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');
    const navLinks = document.querySelectorAll('.nav-link');
    const faqItems = document.querySelectorAll('.faq-item');
    
    // ===== NAVBAR SCROLL EFFECT =====
    let lastScroll = 0;
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Add shadow on scroll
        if (currentScroll > 50) {
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        } else {
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
        }
        
        lastScroll = currentScroll;
    });
    
    // ===== MOBILE MENU TOGGLE =====
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            
            // Animate hamburger icon
            const spans = mobileMenuToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translateY(8px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-8px)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        });
        
        // Close mobile menu when clicking nav link
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    navMenu.classList.remove('active');
                    const spans = mobileMenuToggle.querySelectorAll('span');
                    spans[0].style.transform = '';
                    spans[1].style.opacity = '';
                    spans[2].style.transform = '';
                }
            });
        });
    }
    
    // ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip if it's just "#"
            if (href === '#' || href === '#whatsapp') {
                return;
            }
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const navbarHeight = navbar.offsetHeight;
                const targetPosition = target.offsetTop - navbarHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ===== FAQ ACCORDION =====
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        if (question) {
            question.addEventListener('click', () => {
                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle current item
                item.classList.toggle('active');
            });
        }
    });
    
    // ===== LAZY LOADING FOR IMAGES =====
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // ===== SCROLL REVEAL ANIMATIONS =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe sections for fade-in animation
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
    
    // ===== FORM VALIDATION (if forms are added later) =====
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Basic validation
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#EF4444';
                } else {
                    input.style.borderColor = '';
                }
            });
            
            if (isValid) {
                // Form is valid, can proceed
                console.log('Form is valid');
                // Add your form submission logic here
            }
        });
    });
    
    // ===== WHATSAPP FLOAT BUTTON PULSE =====
    const whatsappFloat = document.getElementById('whatsappFloat');
    if (whatsappFloat) {
        // Hide on scroll down, show on scroll up (optional)
        let lastScrollTop = 0;
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Show button after scrolling 300px
            if (scrollTop > 300) {
                whatsappFloat.style.opacity = '1';
                whatsappFloat.style.pointerEvents = 'auto';
            } else {
                whatsappFloat.style.opacity = '0';
                whatsappFloat.style.pointerEvents = 'none';
            }
            
            lastScrollTop = scrollTop;
        }, false);
        
        // Initial state
        whatsappFloat.style.transition = 'opacity 0.3s ease';
        if (window.pageYOffset < 300) {
            whatsappFloat.style.opacity = '0';
            whatsappFloat.style.pointerEvents = 'none';
        }
    }
    
    // ===== ANALYTICS TRACKING (Google Analytics) =====
    // Track CTA button clicks
    const ctaButtons = document.querySelectorAll('.btn-primary, .btn-cta');
    ctaButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Google Analytics 4 event tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cta_click', {
                    'event_category': 'engagement',
                    'event_label': button.textContent.trim(),
                    'value': 1
                });
            }
        });
    });
    
    // Track WhatsApp button clicks
    if (whatsappFloat) {
        whatsappFloat.addEventListener('click', () => {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'whatsapp_click', {
                    'event_category': 'contact',
                    'event_label': 'floating_button',
                    'value': 1
                });
            }
        });
    }
    
    // ===== PERFORMANCE OPTIMIZATION =====
    // Defer non-critical CSS
    const deferredStyles = document.getElementById('deferred-styles');
    if (deferredStyles) {
        const replacement = document.createElement('div');
        replacement.innerHTML = deferredStyles.textContent;
        document.body.appendChild(replacement);
        deferredStyles.parentElement.removeChild(deferredStyles);
    }
    
    // ===== KEYBOARD NAVIGATION ACCESSIBILITY =====
    document.addEventListener('keydown', (e) => {
        // ESC key closes mobile menu
        if (e.key === 'Escape' && navMenu && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            if (mobileMenuToggle) {
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        }
    });
    
    // ===== CONSOLE MESSAGE =====
    console.log('%c🚀 Naskah Prima Website Loaded Successfully!', 'color: #554D89; font-size: 16px; font-weight: bold;');
    console.log('%c💼 Interested in working with us? Contact: hello@naskahprima.com', 'color: #4B5563; font-size: 12px;');
    
})();
