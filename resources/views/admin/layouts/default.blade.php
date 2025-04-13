<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mash Chauffeur Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animations */
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="flex min-h-screen bg-gray-900 text-gray-100 font-sans">

<!-- Sidebar (Drawer on Mobile) -->
@include('admin.component.sidebar')

<!-- Overlay for Mobile Drawer -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-40"></div>

<!-- Main Content -->
<div class="flex-1 flex flex-col lg:ml-64">
    <!-- Top Bar -->
    <header class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button id="openSidebar" class="lg:hidden text-yellow-400 hover:text-yellow-300 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-2xl font-semibold text-yellow-400 tracking-tight">Mash Chauffeur Dashboard</h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="/admin/logout" class="bg-yellow-500 text-gray-900 py-2 px-6 rounded-full hover:bg-yellow-400 transition-colors duration-200 font-medium">Logout</a>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 bg-gray-900 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Placeholder for content -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-xl animate-fadeIn">
                <h2 class="text-xl font-semibold text-yellow-400 mb-4">Welcome Back</h2>
                <p class="text-gray-300">This is your premium admin dashboard. Add your content here.</p>
            </div>
        </div>
    </main>
</div>

<!-- JavaScript for Drawer Functionality -->
<script>
    const sidebar = document.getElementById('sidebar');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const overlay = document.getElementById('overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    openSidebarBtn.addEventListener('click', toggleSidebar);
    closeSidebarBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Add animation class on load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('main').classList.add('animate-fadeIn');
    });
</script>
</body>
</html>
