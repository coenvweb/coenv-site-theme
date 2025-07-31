/**
 * Responsive Grid Layout JavaScript
 * Handles dropdown navigation and mobile menu functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Dropdown Navigation Functionality
    const dropdownParents = document.querySelectorAll('.has-dropdown > a');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    // Search Functionality
    const searchToggle = document.querySelector('.search-toggle');
    const searchOverlay = document.querySelector('.search-overlay');
    const searchClose = document.querySelector('.search-close');
    const searchField = document.querySelector('.search-field');
    
    // Handle search toggle
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function() {
            openSearchOverlay();
        });
        
        // Handle search close
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                closeSearchOverlay();
            });
        }
        
        // Close search on overlay click
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearchOverlay();
            }
        });
        
        // Handle escape key for search
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.getAttribute('aria-hidden') === 'false') {
                closeSearchOverlay();
            }
        });
        
        function openSearchOverlay() {
            searchOverlay.setAttribute('aria-hidden', 'false');
            searchToggle.setAttribute('aria-expanded', 'true');
            document.body.classList.add('search-open');
            
            // Focus the search field
            if (searchField) {
                setTimeout(function() {
                    searchField.focus();
                }, 100);
            }
        }
        
        function closeSearchOverlay() {
            searchOverlay.setAttribute('aria-hidden', 'true');
            searchToggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('search-open');
            
            // Return focus to search toggle
            searchToggle.focus();
        }
    }
    
    // Handle dropdown clicks
    dropdownParents.forEach(function(parent) {
        const dropdown = parent.nextElementSibling;
        let isOpen = false;
        
        // Toggle dropdown on click
        parent.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDropdown();
        });
        
        // Handle keyboard navigation
        parent.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'Enter':
                case ' ': // Space key
                    e.preventDefault();
                    toggleDropdown();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    if (!isOpen) {
                        toggleDropdown();
                    }
                    focusFirstDropdownItem();
                    break;
                case 'Escape':
                    if (isOpen) {
                        toggleDropdown();
                        parent.focus();
                    }
                    break;
            }
        });
        
        // Handle dropdown item navigation
        if (dropdown) {
            const dropdownItems = dropdown.querySelectorAll('a');
            
            dropdownItems.forEach(function(item, index) {
                item.addEventListener('keydown', function(e) {
                    switch(e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            if (index < dropdownItems.length - 1) {
                                dropdownItems[index + 1].focus();
                            } else {
                                dropdownItems[0].focus(); // Loop to first
                            }
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            if (index > 0) {
                                dropdownItems[index - 1].focus();
                            } else {
                                parent.focus(); // Go back to parent
                            }
                            break;
                        case 'Escape':
                            e.preventDefault();
                            toggleDropdown();
                            parent.focus();
                            break;
                        case 'Tab':
                            // Allow natural tab behavior but close dropdown if tabbing away
                            if (e.shiftKey && index === 0) {
                                // Shift+Tab on first item, go to parent
                                setTimeout(function() {
                                    if (!dropdown.contains(document.activeElement)) {
                                        toggleDropdown();
                                    }
                                }, 1);
                            } else if (!e.shiftKey && index === dropdownItems.length - 1) {
                                // Tab on last item, close dropdown
                                setTimeout(function() {
                                    if (!dropdown.contains(document.activeElement)) {
                                        toggleDropdown();
                                    }
                                }, 1);
                            }
                            break;
                    }
                });
            });
        }
        
        function toggleDropdown() {
            isOpen = !isOpen;
            parent.setAttribute('aria-expanded', isOpen);
            parent.parentElement.classList.toggle('open', isOpen);
            
            if (dropdown) {
                dropdown.style.display = isOpen ? 'block' : 'none';
            }
        }
        
        function focusFirstDropdownItem() {
            if (dropdown) {
                const firstItem = dropdown.querySelector('a');
                if (firstItem) {
                    firstItem.focus();
                }
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (isOpen && !parent.parentElement.contains(e.target)) {
                toggleDropdown();
            }
        });
    });
    
    // Mobile Menu Functionality
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            const isActive = navMenu.classList.contains('active');
            navMenu.classList.toggle('active');
            
            // Update aria attributes
            mobileMenuToggle.setAttribute('aria-expanded', !isActive);
            
            // Animate hamburger icon
            mobileMenuToggle.classList.toggle('active');
            
            // Focus management
            if (!isActive) {
                // Menu is opening - focus first menu item
                const firstMenuItem = navMenu.querySelector('a');
                if (firstMenuItem) {
                    firstMenuItem.focus();
                }
            }
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuToggle.classList.remove('active');
            }
        });
        
        // Handle escape key for mobile menu
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuToggle.classList.remove('active');
                mobileMenuToggle.focus();
            }
        });
    }
    
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const target = document.querySelector(href);
            
            if (target && href !== '#') {
                e.preventDefault();
                
                // Close mobile menu if open
                if (navMenu && navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenuToggle.classList.remove('active');
                }
                
                // Smooth scroll to target
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Focus the target for screen readers
                target.focus();
            }
        });
    });
    
    // Handle window resize - close dropdowns and mobile menu
    window.addEventListener('resize', function() {
        // Close all dropdowns
        dropdownParents.forEach(function(parent) {
            parent.setAttribute('aria-expanded', 'false');
            parent.parentElement.classList.remove('open');
            const dropdown = parent.nextElementSibling;
            if (dropdown) {
                dropdown.style.display = 'none';
            }
        });
        
        // Close mobile menu on larger screens
        if (window.innerWidth > 768) {
            if (navMenu) {
                navMenu.classList.remove('active');
            }
            if (mobileMenuToggle) {
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuToggle.classList.remove('active');
            }
        }
    });
    
    // Add loading class removal for performance
    document.body.classList.add('loaded');
    
});
