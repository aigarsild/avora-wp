/**
 * Simple Navigation JavaScript
 * Minimal functionality for mobile menu and scroll effects
 */

class SimpleNavigation {
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
        this.handleScroll();
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
        
        // Simple scroll events for header background
        window.addEventListener('scroll', () => {
            this.handleScroll();
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
    }
    
    closeMobileMenu() {
        this.isMenuOpen = false;
        this.mobileToggle.classList.remove('active');
        this.mobileNav.classList.remove('active');
        this.mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    handleScroll() {
        if (!this.header) return;
        
        const scrollY = window.scrollY;
        
        if (scrollY > 50) {
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

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new SimpleNavigation();
});