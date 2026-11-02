<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>
    <x-slot name="logo">
    <x-authentication-card-logo />
</x-slot>

<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        Welcome Back
    </h2>

    <p class="text-sm text-gray-500 mt-2">
        Sign in to your University Management System account.
    </p>
</div>

<x-validation-errors class="mb-4" />

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
