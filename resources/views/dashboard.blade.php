@extends('components.layouts.app')

@section('title','Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Dashboard Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-black p-4 rounded shadow border border-red-500">
            <div class="text-sm text-red-500">Total Vehicles</div>
            <div class="text-2xl font-bold text-white">{{ $totalVehicles }}</div>
        </div>

        <div class="bg-black p-4 rounded shadow border border-red-500">
            <div class="text-sm text-red-500">Total Brands</div>
            <div class="text-2xl font-bold text-white">{{ $totalBrands }}</div>
        </div>

        <div class="bg-black p-4 rounded shadow border border-red-500">
            <div class="text-sm text-red-500">Vehicles Without Brand</div>
            <div class="text-2xl font-bold text-white">{{ $vehiclesWithoutBrand }}</div>
        </div>
    </div>

    {{-- Add Vehicle --}}
    <div class="flex gap-6 mb-6">
        <div class="text-white w-full bg-black p-4 rounded shadow border border-red-500">
            <h2 class="font-semibold text-red-500 mb-3">Add Vehicle</h2>

            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-white">Vehicle Name</label>
                        <input name="name" value="{{ old('name') }}" class="w-full bg-black border p-2 rounded border-red-500" required>
                        @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-white">Brand</label>
                        <select name="brand_id" class="w-full bg-black border p-2 rounded border-red-500">
                            <option value="">Select Brand</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-white">Model Year</label>
                        <input name="model_year" type="number" value="{{ old('model_year') }}" class="w-full bg-black border p-2 rounded border-red-500">
                        @error('model_year')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-white">Color</label>
                        <input name="color" value="{{ old('color') }}" class="w-full bg-black border p-2 rounded border-red-500">
                        @error('color')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-white">Price</label>
                        <input name="price" step="0.01" type="number" value="{{ old('price') }}" class="w-full bg-black border p-2 rounded border-red-500">
                        @error('price')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="pt-2">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-800">Add Vehicle</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Vehicle Table --}}
    <div class="mt-5 w-full bg-black p-4 rounded shadow border border-red-500 overflow-x-auto">
        <h2 class="font-semibold text-red-500 mb-3">Vehicles</h2>

        <table class="w-full table-auto border-collapse text-white">
            <thead>
                <tr class="bg-black border border-red-500 text-left text-white">
                    <th class="px-3 py-2 border-b border-red-500">ID</th>
                    <th class="px-3 py-2 border-b border-red-500">Name</th>
                    <th class="px-3 py-2 border-b border-red-500">Brand</th>
                    <th class="px-3 py-2 border-b border-red-500">Model Year</th>
                    <th class="px-3 py-2 border-b border-red-500">Color</th>
                    <th class="px-3 py-2 border-b border-red-500">Price</th>
                    <th class="px-3 py-2 border-b border-red-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $v)
                <tr class="border border-red-500 text-white bg-black">
                    <td class="px-3 py-2">{{ $v->id }}</td>
                    <td class="px-3 py-2">{{ $v->name }}</td>
                    <td class="px-3 py-2">{{ $v->brand ? $v->brand->name : 'N/A' }}</td>
                    <td class="px-3 py-2">{{ $v->model_year ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $v->color ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $v->price ?? '-' }}</td>
                    <td class="px-3 py-2">
                        {{-- Edit --}}
                        <button
                            class="px-2 py-1 text-sm bg-black text-white border border-white rounded hover:bg-black hover:text-red-500 hover:border-red-500 edit-vehicle-btn"
                            data-id="{{ $v->id }}"
                            data-name="{{ $v->name }}"
                            data-brand="{{ $v->brand_id }}"
                            data-model_year="{{ $v->model_year }}"
                            data-color="{{ $v->color }}"
                            data-price="{{ $v->price }}"
                        >Edit</button>

                        {{-- Delete --}}
                        <form action="{{ route('vehicles.destroy', $v) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-vehicle-btn px-2 py-1 text-sm bg-black text-red-500 border border-red-500 rounded hover:bg-black hover:text-white hover:border-white">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Edit Vehicle Modal --}}
<div id="edit-vehicle-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-black w-full max-w-lg p-4 rounded border border-red-500">
        <h3 class="font-semibold mb-2 text-red-500">Edit Vehicle</h3>
        <form id="edit-vehicle-form" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm text-white">Vehicle Name</label>
                    <input name="name" id="edit-name" class="text-white w-full bg-black border p-2 rounded border-red-500" required>
                </div>
                <div>
                    <label class="block text-sm text-white">Brand</label>
                    <select name="brand_id" id="edit-brand" class="text-white w-full bg-black border p-2 rounded border-red-500">
                        <option value="">Select Brand</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-white">Model Year</label>
                    <input name="model_year" id="edit-year" type="number" class="text-white w-full bg-black border p-2 rounded border-red-500">
                </div>
                <div>
                    <label class="block text-sm text-white">Color</label>
                    <input name="color" id="edit-color" class="text-white w-full bg-black border p-2 rounded border-red-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-white">Price</label>
                    <input name="price" id="edit-price" step="0.01" type="number" class="text-white w-full bg-black border p-2 rounded border-red-500">
                </div>
            </div>
            <div class="mt-3 flex gap-2 justify-end">
                <button type="button" id="edit-cancel" class="px-4 py-2 border rounded text-white hover:text-red-700 hover:border-red-700">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-black text-red-500 border border-red-500 rounded hover:text-white hover:border-white">Save</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Open Edit Modal
    document.querySelectorAll('.edit-vehicle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById('edit-vehicle-modal');
            const form = document.getElementById('edit-vehicle-form');
            const id = btn.dataset.id;

            document.getElementById('edit-name').value = btn.dataset.name;
            document.getElementById('edit-brand').value = btn.dataset.brand;
            document.getElementById('edit-year').value = btn.dataset.model_year;
            document.getElementById('edit-color').value = btn.dataset.color;
            document.getElementById('edit-price').value = btn.dataset.price;

            form.action = `/vehicles/${id}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Close Edit Modal
    document.getElementById('edit-cancel').addEventListener('click', () => {
        const modal = document.getElementById('edit-vehicle-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    document.getElementById('edit-vehicle-modal').addEventListener('click', (e) => {
        if(e.target.id === 'edit-vehicle-modal'){
            e.currentTarget.classList.add('hidden');
            e.currentTarget.classList.remove('flex');
        }
    });

    // Delete Vehicle Confirmation
    document.querySelectorAll('.delete-vehicle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(confirm('Are you sure you want to delete this vehicle?')) {
                btn.closest('form').submit();
            }
        });
    });
});
</script>
@endpush

@endsection
