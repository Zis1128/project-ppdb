<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Bukti Pembayaran</h3>

    <form action="{{ route('dashboard.pembayaran.upload') }}" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        <input type="hidden" name="pembayaran_id" value="{{ $pembayaran->id }}">

        <!-- Tanggal Transfer -->
        <div>
            <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Transfer <span class="text-red-500">*</span>
            </label>
            <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}" required
                max="{{ date('Y-m-d') }}"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('tanggal_bayar') border-red-500 @enderror">
            @error('tanggal_bayar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Metode Pembayaran -->
        <div>
            <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                Metode Pembayaran
            </label>
            <select id="metode_pembayaran" name="metode_pembayaran"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>
                    Transfer Bank</option>
                <option value="ATM" {{ old('metode_pembayaran') == 'ATM' ? 'selected' : '' }}>ATM</option>
                <option value="Internet Banking" {{ old('metode_pembayaran') == 'Internet Banking' ? 'selected' : '' }}>
                    Internet Banking</option>
                <option value="Mobile Banking" {{ old('metode_pembayaran') == 'Mobile Banking' ? 'selected' : '' }}>
                    Mobile Banking</option>
            </select>
        </div>

        <!-- Upload Bukti -->
        <div>
            <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                Bukti Pembayaran <span class="text-red-500">*</span>
            </label>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition"
                x-data="{ fileName: '', filePreview: '' }"
                @drop.prevent="
                    let file = $event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        fileName = file.name;
                        let reader = new FileReader();
                        reader.onload = (e) => filePreview = e.target.result;
                        reader.readAsDataURL(file);
                        $refs.fileInput.files = $event.dataTransfer.files;
                    }
                 "
                @dragover.prevent
                @change="
                    let file = $event.target.files[0];
                    if (file) {
                        fileName = file.name;
                        let reader = new FileReader();
                        reader.onload = (e) => filePreview = e.target.result;
                        reader.readAsDataURL(file);
                    }
                 ">

                <div class="space-y-2 text-center" x-show="!filePreview">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 justify-center">
                        <label for="bukti_pembayaran"
                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                            <span>Upload file</span>
                            <input id="bukti_pembayaran" x-ref="fileInput" name="bukti_pembayaran" type="file"
                                accept="image/jpeg,image/jpg,image/png" required class="sr-only">
                        </label>
                        <p class="pl-1">atau drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max: 2MB)</p>
                </div>

                <!-- Preview -->
                <div x-show="filePreview" class="w-full">
                    <div class="relative">
                        <img :src="filePreview" alt="Preview" class="max-h-64 mx-auto rounded-lg">
                        <button type="button" @click="filePreview = ''; fileName = ''; $refs.fileInput.value = ''"
                            class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 text-center" x-text="fileName"></p>
                </div>
            </div>

            @error('bukti_pembayaran')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Tips Upload Bukti:</strong>
                    </p>
                    <ul class="mt-2 text-sm text-blue-600 list-disc list-inside space-y-1">
                        <li>Pastikan foto bukti transfer terlihat jelas</li>
                        <li>Mencantumkan nama pengirim, jumlah, dan tanggal transfer</li>
                        <li>Format file: JPG, JPEG, atau PNG</li>
                        <li>Ukuran maksimal 2MB</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            Upload Bukti Pembayaran
        </button>
    </form>
</div>
