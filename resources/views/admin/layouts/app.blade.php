<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mash Chauffeur - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .input{
            @apply ;
        }
    </style>
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body class="min-h-screen bg-gray-900 flex justify-center">
<!-- Sidebar (Drawer on Mobile) -->
@include('admin.component.sidebar')

<!-- Overlay for Mobile Drawer -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-40"></div>
<div class="flex-1 flex flex-col lg:ml-64">
    <!-- Top Bar -->
    <header class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button id="openSidebar" class="lg:hidden text-yellow-400 hover:text-yellow-300 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h4 class="text-2xl font-semibold text-yellow-400 tracking-tight">Dashboard</h4>
        </div>
        <div class="flex items-center space-x-4">
            <a href="/admin/logout" class="bg-yellow-500 text-gray-900 py-2 px-6 rounded-full hover:bg-yellow-400 transition-colors duration-200 font-medium">Logout</a>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 bg-gray-900">
        <div class="max-w-7xl mx-auto text-white    ">
            <!-- Placeholder for content -->
            @inertia
        </div>
    </main>
</div>
</body>
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

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('main').classList.add('animate-fadeIn');
        document.querySelector('.animate-fadeIn').classList.add('opacity-100');
    });
</script>
</html>
