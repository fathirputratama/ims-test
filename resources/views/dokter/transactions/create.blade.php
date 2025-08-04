<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Transaksi Tindakan & Obat
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('dokter.transactions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="registration_id" class="block text-gray-700">Pendaftaran</label>
                    <select name="registration_id" id="registration_id" class="w-full p-2 mt-1 border rounded-lg" required>
                        <option value="">Pilih Pendaftaran</option>
                        @foreach ($registrations as $registration)
                            <option value="{{ $registration->id }}"
                                    {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                {{ $registration->patient->name }} - {{ $registration->registration_date->format('d-m-Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('registration_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>
                <div id="actions-container" class="mb-6">
                    <div class="action-item mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700">Tindakan</label>
                                <select name="actions[0][action_id]" class="w-full p-2 mt-1 border rounded-lg">
                                    <option value="">Pilih Tindakan</option>
                                    @foreach ($actions as $action)
                                        <option value="{{ $action->id }}">{{ $action->name }} (Rp {{ number_format($action->price, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                                @error('actions.*.action_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-action" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Tambah Tindakan
                </button>

                <h3 class="text-lg font-semibold text-gray-900 mb-4">Obat</h3>
                <div id="medicines-container" class="mb-6">
                    <div class="medicine-item mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700">Obat</label>
                                <select name="medicines[0][medicine_id]" class="w-full p-2 mt-1 border rounded-lg">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok: {{ $medicine->stock }}, Rp {{ number_format($medicine->price, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                                @error('medicines.*.medicine_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700">Jumlah</label>
                                <input type="number" name="medicines[0][quantity]" class="w-full p-2 mt-1 border rounded-lg" min="1" placeholder="Masukkan jumlah">
                                @error('medicines.*.quantity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-medicine" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Tambah Obat
                </button>

                <div class="mb-4">
                    <label for="notes" class="block text-gray-700">Catatan</label>
                    <textarea name="notes" id="notes" class="w-full p-2 mt-1 border rounded-lg">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('dokter.transactions.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let actionIndex = 1;
        document.getElementById('add-action').addEventListener('click', function () {
            const container = document.getElementById('actions-container');
            const newItem = document.createElement('div');
            newItem.classList.add('action-item', 'mb-4');
            newItem.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Tindakan</label>
                        <select name="actions[${actionIndex}][action_id]" class="w-full p-2 mt-1 border rounded-lg">
                            <option value="">Pilih Tindakan</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action->id }}">{{ $action->name }} (Rp {{ number_format($action->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="button" class="remove-action mt-1 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            actionIndex++;
        });

        let medicineIndex = 1;
        document.getElementById('add-medicine').addEventListener('click', function () {
            const container = document.getElementById('medicines-container');
            const newItem = document.createElement('div');
            newItem.classList.add('medicine-item', 'mb-4');
            newItem.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Obat</label>
                        <select name="medicines[${medicineIndex}][medicine_id]" class="w-full p-2 mt-1 border rounded-lg">
                            <option value="">Pilih Obat</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok: {{ $medicine->stock }}, Rp {{ number_format($medicine->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700">Jumlah</label>
                        <input type="number" name="medicines[${medicineIndex}][quantity]" class="w-full p-2 mt-1 border rounded-lg" min="1" placeholder="Masukkan jumlah">
                        <button type="button" class="remove-medicine mt-1 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            medicineIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-action')) {
                e.target.closest('.action-item').remove();
            }
            if (e.target.classList.contains('remove-medicine')) {
                e.target.closest('.medicine-item').remove();
            }
        });
    </script>
</x-app-layout>