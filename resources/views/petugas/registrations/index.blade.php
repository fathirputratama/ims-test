<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pendaftaran
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            <a href="{{ route('petugas.registrations.create') }}"
               class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Tambah Pendaftaran
            </a>
            @if ($registrations->isEmpty())
                <p class="text-gray-600">Tidak ada pendaftaran.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-900">Pasien</th>
                                <th class="px-4 py-2 text-left text-gray-900">Dokter</th>
                                <th class="px-4 py-2 text-left text-gray-900">Tanggal</th>
                                <th class="px-4 py-2 text-left text-gray-900">Status</th>
                                <th class="px-4 py-2 text-left text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrations as $registration)
                                <tr>
                                    <td class="px-4 py-2">{{ $registration->patient->name }}</td>
                                    <td class="px-4 py-2">{{ $registration->doctor->name }}</td>
                                    <td class="px-4 py-2">{{ $registration->registration_date->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">{{ $registration->status }}</td>
                                    <td class="px-4 py-2">
                                        @if ($registration->status !== 'completed')
                                           <a href="{{ route('petugas.registrations.edit', $registration->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>
                                        @endif
                                        <form action="{{ route('petugas.registrations.destroy', $registration->id) }}" method="POST"
                                              class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pendaftaran ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">
                                                Hapus
                                            </button>
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