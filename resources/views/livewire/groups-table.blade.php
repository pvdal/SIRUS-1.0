<div>

    <div class="max-w-[1900px] mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($items as $item)
                <div class="border border-gray-300 rounded-lg shadow h-72 p-4 bg-white">
                    <!-- Conteúdo do card -->
                    <h2 class="text-lg font-semibold">{{ $item['titulo']}}</h2>
                    <p class="mt-2 text-gray-600">{{ $item['descricao'] }}</p>
                    <!-- ... -->
                </div>
            @endforeach
        </div>
    </div>

</div>
