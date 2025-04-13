<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mash Chauffeur - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
<div class="w-full max-w-md bg-gray-800 rounded-xl shadow-xl p-8 animate-fadeIn">
    <!-- Logo/Title -->
    <h1 class="text-3xl font-bold text-center text-yellow-400 mb-6">Mash Chauffeur</h1>
    <p class="text-center text-gray-400 mb-8">Sign in to access the Admin Dashboard</p>

    <!-- Login Form -->
    <form action="/admin/login" method="POST" class="space-y-6">
        @csrf
        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                placeholder="Enter your email"
            >
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                placeholder="Enter your password"
            >
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-yellow-500 text-gray-900 py-3 rounded-full hover:bg-yellow-400 transition-colors duration-200 font-semibold"
        >
            Sign In
        </button>
    </form>

    <!-- Forgot Password Link -->
    <p class="mt-4 text-center text-sm text-gray-400">
        <a href="/admin/forget-password" class="text-yellow-400 hover:text-yellow-300 underline"> Forgot your password?</a>
    </p>
</div>

<!-- JavaScript for Animation -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.animate-fadeIn').classList.add('opacity-100');
    });
</script>
</body>
</html>
