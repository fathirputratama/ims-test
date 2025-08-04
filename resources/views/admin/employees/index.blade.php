<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen pegawai
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Daftar pegawai</h3>
                <a href="{{ route('admin.employees.create') }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                    Tambah pegawai
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($employees->isEmpty())
                <p class="text-gray-600">Tidak ada pegawai tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-900">Nama</th>
                                <th class="px-4 py-2 text-left text-gray-900">Jabatan</th>
                                <th class="px-4 py-2 text-left text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="px-4 py-2">{{ $employee->name }}</td>
                                    <td class="px-4 py-2">{{ $employee->position }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.employees.edit', $employee) }}"
                                           class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>