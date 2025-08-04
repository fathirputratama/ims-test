<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pendaftaran
        </h2>
    </x-slot>

    <div class="container px-4 py-6 mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('petugas.registrations.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pasien</h3>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama Pasien</label>
                            <input type="text" name="name" id="name" class="w-full p-2 mt-1 border rounded-lg"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="birth_date" class="block text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="birth_date" class="w-full p-2 mt-1 border rounded-lg"
                                   value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-gray-700">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="w-full p-2 mt-1 border rounded-lg" required>
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700">Telepon</label>
                            <input type="text" name="phone" id="phone" class="w-full p-2 mt-1 border rounded-lg"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="province_id" class="block text-gray-700">Provinsi</label>
                            <select name="province_id" id="province_id" class="w-full p-2 mt-1 border rounded-lg" required>
                                <option value="" disabled {{ old('province_id') ? '' : 'selected' }}>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="city_id" class="block text-gray-700">Kota/Kabupaten</label>
                            <select name="city_id" id="city_id" class="w-full p-2 mt-1 border rounded-lg" required>
                                <option value="" disabled {{ old('city_id') ? '' : 'selected' }}>Pilih Kota/Kabupaten</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" data-province="{{ $city->province_id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="address_detail" class="block text-gray-700">Detail Alamat</label>
                            <textarea name="address_detail" id="address_detail" class="w-full p-2 mt-1 border rounded-lg">{{ old('address_detail') }}</textarea>
                            @error('address_detail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pendaftaran</h3>
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700">Dokter</label>
                            <select name="user_id" id="user_id" class="w-full p-2 mt-1 border rounded-lg" required>
                                <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Pilih Dokter</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('user_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="registration_date" class="block text-gray-700">Tanggal Pendaftaran</label>
                            <input type="date" name="registration_date" id="registration_date" class="w-full p-2 mt-1 border rounded-lg"
                                   value="{{ old('registration_date', now()->format('Y-m-d')) }}" required>
                            @error('registration_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('province_id');
            const citySelect = document.getElementById('city_id');
            const cities = Array.from(citySelect.options).slice(1); // Exclude the placeholder option

            provinceSelect.addEventListener('change', function () {
                const selectedProvince = this.value;
                citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                
                cities.forEach(city => {
                    if (city.dataset.province === selectedProvince || !selectedProvince) {
                        citySelect.appendChild(city);
                    }
                });
            });

            // Trigger change event on page load if province is pre-selected
            if (provinceSelect.value) {
                provinceSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>