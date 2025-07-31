/**
 * Top Navigation Dropdown Functionality
 * Handles keyboard navigation and accessibility for dropdown menus
 */

document.addEventListener('DOMContentLoaded', function() {
    const dropdownParents = document.querySelectorAll('.top-nav .has-dropdown > a');
    
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
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (isOpen && !parent.parentElement.contains(e.target)) {
                toggleDropdown();
            }
        });
        
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
    });
});
