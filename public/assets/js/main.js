(function($) {
'use strict';

// Auto-scroll services section
function initServicesScroll() {
    const servicesScroll = document.getElementById('servicesScroll');
    if (servicesScroll) {
        let scrollAmount = 0;
        const scrollSpeed = 1;
        let scrollInterval = setInterval(() => {
            if (servicesScroll.scrollLeft >= (servicesScroll.scrollWidth - servicesScroll.clientWidth)) {
                servicesScroll.scrollLeft = 0;
                scrollAmount = 0;
            } else {
                scrollAmount += scrollSpeed;
                servicesScroll.scrollLeft = scrollAmount;
            }
        }, 30);

        // Pause on hover
        servicesScroll.addEventListener('mouseenter', () => {
            clearInterval(scrollInterval);
        });

        servicesScroll.addEventListener('mouseleave', () => {
            scrollInterval = setInterval(() => {
                if (servicesScroll.scrollLeft >= (servicesScroll.scrollWidth - servicesScroll.clientWidth)) {
                    servicesScroll.scrollLeft = 0;
                    scrollAmount = 0;
                } else {
                    scrollAmount += scrollSpeed;
                    servicesScroll.scrollLeft = scrollAmount;
                }
            }, 30);
        });
    }
}

// Auto-scroll team section
function initTeamScroll() {
    const teamScroll = document.getElementById('teamScroll');
    if (teamScroll) {
        let scrollAmount = 0;
        const scrollSpeed = 1;
        let scrollInterval = setInterval(() => {
            if (teamScroll.scrollLeft >= (teamScroll.scrollWidth / 2)) {
                teamScroll.scrollLeft = 0;
                scrollAmount = 0;
            } else {
                scrollAmount += scrollSpeed;
                teamScroll.scrollLeft = scrollAmount;
            }
        }, 30);

        // Pause on hover
        teamScroll.addEventListener('mouseenter', () => {
            clearInterval(scrollInterval);
        });

        teamScroll.addEventListener('mouseleave', () => {
            scrollInterval = setInterval(() => {
                if (teamScroll.scrollLeft >= (teamScroll.scrollWidth / 2)) {
                    teamScroll.scrollLeft = 0;
                    scrollAmount = 0;
                } else {
                    scrollAmount += scrollSpeed;
                    teamScroll.scrollLeft = scrollAmount;
                }
            }, 30);
        });
    }
}

// Smooth scroll for anchor links
function initSmoothScroll() {
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
                return false;
            }
        }
    });
}

// Form validation and submission
function initFormHandling() {
    // Contact form
    $('#contactForm').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
    });

    // Event brief form
    $('#eventBriefForm').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Submitting...');
    });
}

// Alert auto-dismiss
function initAlerts() {
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                alert.remove();
            });
        }, 5000);
    });
}

// Lazy load images
function initLazyLoad() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// FAQ Accordion
function initFAQ() {
    $('.faq-question').on('click', function() {
        const icon = $(this).find('i');
        if ($(this).attr('aria-expanded') === 'true') {
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            $('.faq-question i').removeClass('fa-minus').addClass('fa-plus');
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
}

// Back to top button
function initBackToTop() {
    // Create back to top button if it doesn't exist
    if ($('.back-to-top').length === 0) {
        $('body').append('<a href="#" class="back-to-top" style="display:none;"><i class="fas fa-chevron-up"></i></a>');
    }

    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });

    $('.back-to-top').click(function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
}

// Initialize on document ready
$(document).ready(function() {
    initServicesScroll();
    initTeamScroll();
    initSmoothScroll();
    initFormHandling();
    initAlerts();
    initLazyLoad();
    initFAQ();

    // // Add animation on scroll
    // const observerOptions = {
    //     threshold: 0.1,
    //     rootMargin: '0px 0px -50px 0px'
    // };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe elements with animation class
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});

})(jQuery);
