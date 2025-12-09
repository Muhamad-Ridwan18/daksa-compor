@extends('layouts.admin')

@section('title', 'Tabel TER')
@section('page-title', 'Tabel TER (Tarif Efektif Rata-rata)')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Tabel TER PPh 21</h2>
        <p class="text-gray-600 mt-1">Kelola tabel Tarif Efektif Rata-rata sesuai PP No. 58 Tahun 2023</p>
    </div>
    <div class="flex gap-3">
        <form action="{{ route('admin.ter-tables.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset semua tabel TER ke nilai default?')">
            @csrf
            <button type="submit" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                Reset ke Default
            </button>
        </form>
    </div>
</div>

<!-- Tab Navigation -->
<div class="mb-6 border-b border-gray-200">
    <nav class="flex space-x-8" aria-label="Tabs">
        <button type="button" 
                onclick="switchTerTab('ter-a')"
                id="tab-ter-a"
                class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-primary text-primary"
                data-tab="ter-a">
            TER A (TK0/TK1/K0)
        </button>
        <button type="button" 
                onclick="switchTerTab('ter-b')"
                id="tab-ter-b"
                class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                data-tab="ter-b">
            TER B (TK2/TK3/K1/K2)
        </button>
        <button type="button" 
                onclick="switchTerTab('ter-c')"
                id="tab-ter-c"
                class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                data-tab="ter-c">
            TER C (K3)
        </button>
    </nav>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<!-- TER A Tab Content -->
<div id="tab-content-ter-a" class="tab-content">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tabel TER A (TK0/TK1/K0)</h3>
            <button onclick="openAddModal('TER A')" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium transition-colors">
                + Tambah Baris
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($terA as $index => $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->min, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row->max >= 999999999999 ? '∞' : number_format($row->max, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->tarif_percent, 2) }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal('{{ $row->id }}', '{{ $row->min }}', '{{ $row->max }}', '{{ $row->tarif_percent }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <form action="{{ route('admin.ter-tables.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus baris ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TER B Tab Content -->
<div id="tab-content-ter-b" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tabel TER B (TK2/TK3/K1/K2)</h3>
            <button onclick="openAddModal('TER B')" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium transition-colors">
                + Tambah Baris
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($terB as $index => $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->min, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row->max >= 999999999999 ? '∞' : number_format($row->max, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->tarif_percent, 2) }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal('{{ $row->id }}', '{{ $row->min }}', '{{ $row->max }}', '{{ $row->tarif_percent }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <form action="{{ route('admin.ter-tables.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus baris ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TER C Tab Content -->
<div id="tab-content-ter-c" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tabel TER C (K3)</h3>
            <button onclick="openAddModal('TER C')" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium transition-colors">
                + Tambah Baris
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($terC as $index => $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->min, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row->max >= 999999999999 ? '∞' : number_format($row->max, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($row->tarif_percent, 2) }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal('{{ $row->id }}', '{{ $row->min }}', '{{ $row->max }}', '{{ $row->tarif_percent }}')" 
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <form action="{{ route('admin.ter-tables.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus baris ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Baris Tabel TER</h3>
            <form id="addForm" action="{{ route('admin.ter-tables.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kategori" id="add_kategori">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min (Rp)</label>
                    <input type="number" name="min" required min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max (Rp)</label>
                    <input type="number" name="max" required min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarif (%)</label>
                    <input type="number" name="tarif_percent" required min="0" max="100" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Baris Tabel TER</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min (Rp)</label>
                    <input type="number" name="min" id="edit_min" required min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max (Rp)</label>
                    <input type="number" name="max" id="edit_max" required min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarif (%)</label>
                    <input type="number" name="tarif_percent" id="edit_tarif_percent" required min="0" max="100" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchTerTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-primary', 'text-primary');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById('tab-content-' + tabName).classList.remove('hidden');
        
        // Add active state to selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-primary', 'text-primary');
    }

    function openAddModal(kategori) {
        document.getElementById('add_kategori').value = kategori;
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addForm').reset();
    }

    function openEditModal(id, min, max, tarifPercent) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_min').value = min;
        document.getElementById('edit_max').value = max;
        document.getElementById('edit_tarif_percent').value = tarifPercent;
        document.getElementById('editForm').action = '{{ route("admin.ter-tables.update", ":id") }}'.replace(':id', id);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }
</script>
@endsection

