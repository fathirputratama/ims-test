<x-app-layout>
         <x-slot name="header">
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                 Tambah Pegawai
             </h2>
         </x-slot>

         <div class="container px-4 py-6 mx-auto">
             <div class="p-6 bg-white rounded-lg shadow-md">
                 <form action="{{ route('admin.employees.store') }}" method="POST">
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
                         <label for="position" class="block text-gray-700">Posisi</label>
                         <input type="text" name="position" id="position" class="w-full p-2 mt-1 border rounded-lg"
                                value="{{ old('position') }}" required>
                         @error('position')
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