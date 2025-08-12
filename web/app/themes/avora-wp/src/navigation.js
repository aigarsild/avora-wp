/**
 * Modern Responsive Navigation JavaScript
 * Handles mobile menu, scroll effects, and accessibility
 */

class ModernNavigation {
    constructor() {
        this.mobileToggle = document.getElementById('mobileToggle');
        this.mobileNav = document.getElementById('mobileNav');
        this.mobileOverlay = document.getElementById('mobileOverlay');
        this.header = document.querySelector('.modern-header');
        this.isMenuOpen = false;
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.handleScrollEffects();
        this.setActiveNavItem();
    }
    
    bindEvents() {
        // Mobile menu toggle
        if (this.mobileToggle) {
            this.mobileToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobileMenu();
            });
        }
        
        // Overlay click to close
        if (this.mobileOverlay) {
            this.mobileOverlay.addEventListener('click', () => {
                this.closeMobileMenu();
            });
        }
        
        // Close menu on mobile nav link click
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-menu a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMobileMenu();
            });
        });
        
        // Escape key to close menu
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isMenuOpen) {
                this.closeMobileMenu();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && this.isMenuOpen) {
                this.closeMobileMenu();
            }
        });
        
        // Scroll events for header effects
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                this.handleScrollEffects();
            }, 10);
        });
    }
    
    toggleMobileMenu() {
        if (this.isMenuOpen) {
            this.closeMobileMenu();
        } else {
            this.openMobileMenu();
        }
    }
    
    openMobileMenu() {
        this.isMenuOpen = true;
        this.mobileToggle.classList.add('active');
        this.mobileNav.classList.add('active');
        this.mobileOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus management for accessibility
        this.trapFocus();
        
        // Animate menu items
        this.animateMenuItems();
    }
    
    closeMobileMenu() {
        this.isMenuOpen = false;
        this.mobileToggle.classList.remove('active');
        this.mobileNav.classList.remove('active');
        this.mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
        
        // Return focus to toggle button
        this.mobileToggle.focus();
    }
    
    trapFocus() {
        const focusableElements = this.mobileNav.querySelectorAll(
            'a, button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
        );
        
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];
        
        this.mobileNav.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        lastFocusable.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        firstFocusable.focus();
                        e.preventDefault();
                    }
                }
            }
        });
        
        // Focus first element
        setTimeout(() => firstFocusable?.focus(), 100);
    }
    
    animateMenuItems() {
        const menuItems = this.mobileNav.querySelectorAll('.mobile-nav-menu li');
        menuItems.forEach((item, index) => {
            item.style.transform = 'translateX(50px)';
            item.style.opacity = '0';
            
            setTimeout(() => {
                item.style.transition = 'all 0.4s cubic-bezier(0.4, 0.0, 0.2, 1)';
                item.style.transform = 'translateX(0)';
                item.style.opacity = '1';
            }, 100 + (index * 50));
        });
    }
    
    handleScrollEffects() {
        if (!this.header) return;
        
        const scrollY = window.scrollY;
        
        if (scrollY > 100) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
    }
    
    setActiveNavItem() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-menu a');
        
        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            const listItem = link.closest('li');
            
            if (listItem) {
                listItem.classList.remove('active');
                
                if (linkPath === currentPath || 
                    (currentPath !== '/' && linkPath !== '/' && currentPath.includes(linkPath))) {
                    listItem.classList.add('active');
                }
            }
        });
    }
}

// Smooth scrolling for anchor links
function initSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                
                const headerHeight = document.querySelector('.modern-header')?.offsetHeight || 0;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Enhanced loading effects
function initLoadingEffects() {
    // Fade in navigation items
    const navItems = document.querySelectorAll('.nav-menu li');
    navItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s cubic-bezier(0.4, 0.0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
}

// Performance optimization for scroll events
function throttle(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ModernNavigation();
    initSmoothScrolling();
    initLoadingEffects();
});

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Pause any animations when page is hidden
        const nav = document.querySelector('.mobile-navigation.active');
        if (nav) {
            nav.style.animationPlayState = 'paused';
        }
    } else {
        // Resume animations when page is visible
        const nav = document.querySelector('.mobile-navigation.active');
        if (nav) {
            nav.style.animationPlayState = 'running';
        }
    }
});

// Export for external use
window.ModernNavigation = ModernNavigation;
