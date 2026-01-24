<!-- Dynamic Sidebar Component - Automatically detects role -->
@php
    // Get user from localStorage via JavaScript
    $userRole = 'affiliate'; // default role
@endphp

<!-- Mobile Menu Button -->
<button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-slate-800 text-white rounded-lg shadow-lg">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

<!-- Sidebar Container -->
<div id="sidebarContainer"
    class="fixed left-0 top-0 h-screen w-64 text-white transition-all duration-300 z-40 -translate-x-full lg:translate-x-0 shadow-2xl">
    <!-- Logo Section -->
    <div class="p-5 border-b border-white border-opacity-10">
        <div class="flex items-center justify-between">
            <img src="{{ asset('images/logoAffilllink2.png') }}" alt="Affillink Logo" class="w-46 h-auto">
            <button id="closeMobileMenu"
                class="lg:hidden text-white hover:bg-white hover:bg-opacity-10 p-1.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Section -->
    <nav id="sidebarMenu" class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 160px);">
        <!-- Menu items will be populated via JavaScript -->
    </nav>

    <!-- Logout Section -->
    <div
        class="absolute bottom-0 left-0 right-0 p-3 border-t border-white border-opacity-10 bg-opacity-30 backdrop-blur-sm">
        <button onclick="logout()"
            class="w-full flex items-center justify-center space-x-2 px-3 py-2.5 text-sm text-white bg-red-500 bg-opacity-20 hover:bg-opacity-30 rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
            <span>Logout</span>
        </button>
    </div>
</div>

<!-- Main Content Area - Add margin to accommodate sidebar -->
<div class="sidebar-layout lg:ml-64 transition-all duration-300"></div>

<style>
    /* Sidebar colors based on role */
    .sidebar-super-admin {
        background: linear-gradient(180deg, #0F172A 0%, #1E3A5F 100%);
    }

    .sidebar-sales {
        background: linear-gradient(180deg, #1E3A5F 0%, #334155 100%);
    }

    .sidebar-affiliate {
        background: linear-gradient(180deg, #0F172A 0%, #0EA5E9 100%);
    }

    .sidebar-finance {
        background: linear-gradient(180deg, #0F172A 0%, #059669 100%);
    }

    /* Smooth scrollbar for menu */
    #sidebarMenu::-webkit-scrollbar {
        width: 6px;
    }

    #sidebarMenu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    #sidebarMenu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    #sidebarMenu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Menu item hover effects */
    .menu-item {
        position: relative;
        overflow: hidden;
    }

    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: currentColor;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .menu-item:hover::before,
    .menu-item.active::before {
        transform: scaleY(1);
    }

    /* Mobile menu animation */
    @media (max-width: 1023px) {
        #sidebarContainer.show {
            transform: translateX(0);
        }
    }
</style>

<script>
    // Menu items per role
    const menuByRole = {
        'super-admin': [
            { label: 'Dashboard', url: '#', icon: 'dashboard', active: true },
            { label: 'Users', url: '#', icon: 'users' },
            { label: 'Affiliates', url: '#', icon: 'affiliates' },
            { label: 'Campaigns', url: '#', icon: 'campaigns' },
            { label: 'Finances', url: '#', icon: 'finances' },
            { label: 'Payouts', url: '#', icon: 'payouts' }
        ],
        'sales': [
            { label: 'Dashboard', url: '#', icon: 'dashboard', active: true },
            { label: 'Leads', url: '#', icon: 'leads' },
            { label: 'Sales', url: '#', icon: 'sales' },
            { label: 'Performance', url: '#', icon: 'performance' },
            { label: 'Reports', url: '#', icon: 'reports' }
        ],
        'affiliate': [
            { label: 'Dashboard', url: '#', icon: 'dashboard', active: true },
            { label: 'Reports', url: '#', icon: 'reports' },
            { label: 'Campaigns', url: '#', icon: 'campaigns' },
            { label: 'Payouts', url: '#', icon: 'payouts' },
            { label: 'Support', url: '#', icon: 'support' }
        ],
        'finance': [
            { label: 'Dashboard', url: '#', icon: 'dashboard', active: true },
            { label: 'Transactions', url: '#', icon: 'sales' },
            { label: 'Invoices', url: '#', icon: 'payouts' },
            { label: 'Reports', url: '#', icon: 'reports' },
            { label: 'Support', url: '#', icon: 'support' }
        ]
    };

    // Icon SVG paths
    const iconPaths = {
        'dashboard': 'M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z',
        'leads': 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v4h8v-4zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z',
        'sales': 'M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z',
        'performance': 'M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z',
        'reports': 'M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z',
        'campaigns': 'M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z',
        'payouts': 'M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z',
        'support': 'M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z',
        'users': 'M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z',
        'affiliates': 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z',
        'finances': 'M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z'
    };

    // Initialize sidebar on page load
    function initSidebar() {
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        const userRole = user?.role?.toLowerCase() || 'affiliate';

        // Map role to sidebar class
        const roleMap = {
            'super-admin': 'sidebar-super-admin',
            'admin': 'sidebar-super-admin',
            'sales': 'sidebar-sales',
            'affiliate': 'sidebar-affiliate',
            'finance': 'sidebar-finance'
        };

        const sidebarContainer = document.getElementById('sidebarContainer');
        const sidebarClass = roleMap[userRole] || 'sidebar-affiliate';

        // Apply role-based styling
        sidebarContainer.classList.add(sidebarClass);

        // Load menu items for this role
        const menuItems = menuByRole[userRole] || menuByRole['affiliate'];
        renderMenu(menuItems);

        // Setup mobile menu
        setupMobileMenu();
    }

    // Render menu items
    function renderMenu(items) {
        const menuContainer = document.getElementById('sidebarMenu');
        menuContainer.innerHTML = items.map((item, index) => {
            const isActive = index === 0;
            const bgColor = isActive ? 'bg-green-500 hover:bg-green-600 shadow-lg' : 'hover:bg-white hover:bg-opacity-10';
            const textColor = 'text-white';

            return `
                <a href="${item.url}" class="menu-item flex items-center space-x-2.5 px-3 py-2.5 ${bgColor} ${textColor} rounded-lg transition-all duration-200 text-sm font-medium ${isActive ? 'active' : ''} group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="${iconPaths[item.icon]}" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1">${item.label}</span>
                    ${isActive ? '<div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>' : ''}
                </a>
            `;
        }).join('');
    }

    // Setup mobile menu functionality
    function setupMobileMenu() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const sidebarContainer = document.getElementById('sidebarContainer');
        const overlay = document.getElementById('sidebarOverlay');

        function openMenu() {
            sidebarContainer.classList.add('show');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            sidebarContainer.classList.remove('show');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        mobileMenuBtn?.addEventListener('click', openMenu);
        closeMobileMenu?.addEventListener('click', closeMenu);
        overlay?.addEventListener('click', closeMenu);

        // Close menu when clicking menu items on mobile
        const menuLinks = document.querySelectorAll('#sidebarMenu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeMenu();
                }
            });
        });
    }

    // Logout function
    async function logout() {
        if (!confirm('Yakin ingin logout?')) return;

        const token = localStorage.getItem('token');
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
        } catch (error) {
            console.error('Logout error:', error);
        }

        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '/login';
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }

    // Also initialize on window load
    window.addEventListener('load', () => {
        if (localStorage.getItem('user')) {
            initSidebar();
        }
    });
</script>