<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="mb-8">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md text-white">
                <h3 class="text-xl font-semibold">
                    Halo, {{ Auth::user()->name ?? 'Admin' }}!
                </h3>
                <p class="mt-2">
                    Selamat datang di dashboard admin Klinik Sehat. Kelola operasional klinik dengan mudah dan efisien.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-blue-500 flex items-center">
                <svg class="h-8 w-8 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a2 2 0 00-2-2h-3m-2-4H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v4a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Total Pegawai</h4>
                    <p class="text-2xl font-bold text-gray-700">{{ \App\Models\Employee::count() }}</p>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-green-500 flex items-center">
                <svg class="h-8 w-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Total Pengguna</h4>
                    <p class="text-2xl font-bold text-gray-700">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-yellow-500 flex items-center">
                <svg class="h-8 w-8 text-yellow-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Total Tindakan</h4>
                    <p class="text-2xl font-bold text-gray-700">{{ \App\Models\Action::count() }}</p>
                </div>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-red-500 flex items-center">
                <svg class="h-8 w-8 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Total Obat</h4>
                    <p class="text-2xl font-bold text-gray-700">{{ \App\Models\Medicine::count() }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.employees.index') }}"
               class="p-6 bg-white rounded-lg shadow-md hover:bg-gray-50 transition flex items-center">
                <svg class="h-6 w-6 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a2 2 0 00-2-2h-3m-2-4H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v4a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Manajemen Pegawai</h4>
                    <p class="mt-2 text-gray-600">Kelola data pegawai klinik.</p>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="p-6 bg-white rounded-lg shadow-md hover:bg-gray-50 transition flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Manajemen Pengguna</h4>
                    <p class="mt-2 text-gray-600">Kelola akun pengguna sistem.</p>
                </div>
            </a>
            <a href="{{ route('admin.actions.index') }}"
               class="p-6 bg-white rounded-lg shadow-md hover:bg-gray-50 transition flex items-center">
                <svg class="h-6 w-6 text-yellow-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Manajemen Tindakan</h4>
                    <p class="mt-2 text-gray-600">Kelola jenis layanan medis.</p>
                </div>
            </a>
            <a href="{{ route('admin.medicines.index') }}"
               class="p-6 bg-white rounded-lg shadow-md hover:bg-gray-50 transition flex items-center">
                <svg class="h-6 w-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">Manajemen Obat</h4>
                    <p class="mt-2 text-gray-600">Kelola data obat klinik.</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>