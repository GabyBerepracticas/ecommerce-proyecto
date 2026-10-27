@if (session('exito'))
    <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">
        {{ session('exito') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
@endif