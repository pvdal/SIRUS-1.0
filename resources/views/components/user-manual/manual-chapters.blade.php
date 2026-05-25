{{-- Navegação entre os capítulos do manual: método de páginas múltiplas --}}
@foreach($chapters as $slug => $data)
    <a href="{{ route('manual.index', $slug) }}"
        class="flex justify-between items-center px-3 py-2 rounded-lg border border-transparent transition
        {{
            $chapter === $slug
                ? 'bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 border border-blue-200 font-medium'
                : 'hover:bg-gray-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200'
        }}"
    >
        <span>{{ $data['label'] }}</span>
        <x-lucide-chevron-right
            class="{{
                $chapter === $slug
                    ? 'text-blue-600 w-4 h-4'
                    : 'hidden'
            }}"
        />
    </a>
@endforeach
