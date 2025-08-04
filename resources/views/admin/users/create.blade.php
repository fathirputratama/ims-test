<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengguna
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" class="w-full p-2 mt-1 border rounded-lg"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 mt-1 border rounded-lg"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 ">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 mt-1 border rounded-lg"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 ">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full p-2 mt-1 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 ">Role</label>
                    <select name="role" id="role" class="w-full p-2 mt-1 border rounded-lg" required>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas Pendaftaran</option>
                        <option value="dokter">Dokter</option>
                        <option value="kasir">Kasir</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>