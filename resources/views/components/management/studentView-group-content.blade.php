<div x-show="!isEmpty && !loading" class="flex flex-col gap-4 mx-auto p-6 max-w-[1800px] text-gray-800">
    <div class="flex flex-col 2xl:flex-row w-full gap-4">
        <div class="flex flex-col p-8 w-full 2xl:w-2/3 rounded-lg shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
            <div class="flex w-full mb-3">
                <div class="flex items-center space-x-2 me-auto">
                    <div class="bg-secondary-orange/15 p-2 rounded-lg">
                        <x-lucide-hash class="w-5 h-5 text-primary-orange flex-shrink-0"/>
                    </div>
                    <h2 class="text-gray-600 dark:text-gray-300 transition" x-text="'Grupo ' + groups[0].id"></h2>
                </div>
                <div>
                    <span
                        class=" inline-flex text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg transition duration-150 ease-in-out"
                        :class="groups[0]?.state === 1
                            ? 'bg-secondary-blue text-white dark:text-gray-200'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200'"
                        x-text="groups[0]?.state === 1 ? 'Ativo' : 'Inativo'">
                    </span>
                </div>
            </div>
            <h1 x-text="groups[0].theme" class="text-3xl lg:text-4xl font-bold dark:text-gray-100 transition duration-150 ease-in-out"></h1>
            <hr class="border-t border-gray-200 dark:border-gray-700 transition duration-150 ease-in-out my-4">
            <div class="flex flex-wrap text-gray-500 dark:text-gray-400 transition">
                <div class="flex items-center space-x-2 me-6">
                    <x-lucide-users class="w-4 h-4 flex-shrink-0"/>
                    <span x-text="groups[0]?.students.length + ' Membros'"></span>
                </div>
                <span x-text="'Criado em ' + groups[0]?.created_at" class="me-6">Criado em xx/xx/xxxx</span>
                <span x-text="'Atualizado em ' + groups[0]?.updated_at">Atualizado em xx/xx/xxxx</span>
            </div>
        </div>
        <div class="grid sm:grid-cols-4 gap-2 md:gap-4 w-full 2xl:grid-cols-2 2xl:w-1/3">
            <div class="flex flex-col p-4 space-y-2 rounded-lg shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
                <div class="flex items-center space-x-2 w-full">
                    <div class="bg-royal-blue/15 p-2 rounded-lg">
                        <x-lucide-users class="w-4 h-4 text-royal-blue flex-shrink-0"/>
                    </div>
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm transition">Membros</h2>
                </div>
                <span x-text="groups[0]?.students.length" class="font-bold text-lg dark:text-gray-300 transition">X</span>
            </div>
            <div class="flex flex-col p-4 space-y-2 rounded-lg shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
                <div class="flex items-center space-x-2 w-full">
                    <div class="bg-secondary-orange/15 p-2 rounded-lg">
                        <x-lucide-file-text class="w-4 h-4 text-primary-orange flex-shrink-0"/>
                    </div>
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm transition">Trabalhos</h2>
                </div>
                <span x-text="groups[0]?.papers?.length" class="font-bold text-lg dark:text-gray-300 transition">X</span>
            </div>
            <div class="flex flex-col p-4 space-y-2 rounded-lg shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
                <div class="flex items-center space-x-2 w-full">
                    <div class="p-2 rounded-lg" :class="groups[0]?.state ? 'bg-green-400/15' : 'bg-red-400/15'">
                        <template x-if="groups[0]?.state === 1">
                            <x-lucide-circle-check class="w-4 h-4 text-green-600 flex-shrink-0"/>
                        </template>
                        <template x-if="groups[0]?.state === 0">
                            <x-lucide-circle-x class="w-4 h-4 text-red-500 flex-shrink-0"/>
                        </template>
                    </div>
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm transition">Status</h2>
                </div>
                <span x-text="groups[0]?.state === 1 ? 'Ativo' : 'Inativo'" class="font-bold text-lg dark:text-gray-300 transition"></span>
            </div>
            <div class="flex flex-col p-4 space-y-2 rounded-lg shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
                <div class="flex items-center space-x-2 w-full">
                    <div class="bg-indigo-400/15 p-2 rounded-lg">
                        <x-lucide-calendar class="w-4 h-4 text-indigo-500 flex-shrink-0"/>
                    </div>
                    <h2 class="text-gray-600 dark:text-gray-400 text-sm transition">Criado em</h2>
                </div>
                <span x-text="groups[0]?.created_at" class="font-bold text-lg dark:text-gray-300 transition"></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 w-full items-start">
        <div class="flex flex-col p-6 gap-2 rounded-lg md:col-span-2 shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
            <div class="flex flex-wrap items-center w-full">
                <x-lucide-users class="w-5 h-5 text-primary-orange flex-shrink-0 me-2"/>
                <h2 class="font-medium text-xl dark:text-gray-300 transition">Membros do grupo</h2>
            </div>
            <ul class="space-y-2">
                <template x-for="student in groups[0]?.students">
                    <li class="flex flex-col bg-gray-200/40 hover:bg-gray-200/60 dark:bg-gray-700/40 dark:hover:bg-gray-700/50 p-3 rounded transition">
                        <div class="flex flex-wrap items-center mx-2">
                            <img
                                :src="student.profile_photo_url
                                    ? window.appUrl + '/storage/' + student.profile_photo_url
                                    : (() => {
                                        const name = student.name;

                                        let hash = 0;
                                        for (let i = 0; i < name.length; i++) {
                                            hash = name.charCodeAt(i) + ((hash << 5) - hash);
                                        }

                                        const hue = Math.abs(hash) % 360;

                                        // função pequena para converter HSL → HEX
                                        const hslToHex = (h, s, l) => {
                                            s /= 100;
                                            l /= 100;
                                            const k = n => (n + h / 30) % 12;
                                            const a = s * Math.min(l, 1 - l);
                                            const f = n =>
                                                Math.round(255 * (l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)))))
                                                    .toString(16)
                                                    .padStart(2, '0');
                                            return `${f(0)}${f(8)}${f(4)}`;
                                        };

                                        const bgHex = hslToHex(hue, 60, 88);  // fundo suave
                                        const textHex = hslToHex(hue, 65, 38); // letra mais forte

                                        return 'https://ui-avatars.com/api/?name='
                                            + encodeURIComponent(name)
                                            + '&background=' + bgHex
                                            + '&color=' + textHex;
                                    })()"
                                :alt="'Foto de ' + student.name"
                                class="rounded-full size-10 object-cover me-4"
                                @@error="
                                if ($el.dataset.fallback !== 'true') {
                                    $el.dataset.fallback = 'true';
                                    $el.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(student.name);
                                } else {
                                    $el.remove();
                                }
                            "
                            />
                            <span x-text="student.name"
                                class="font-medium text-gray-700 dark:text-gray-200 transition"
                            ></span>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
        <div class="flex flex-col p-6 gap-2 rounded-lg md:col-span-3 shadow dark:shadow-[0_2px_5px_rgba(0,0,0,0.28)] bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-900 transition duration-150 ease-in-out">
            <div class="flex flex-wrap gap-2 items-center w-full">
                <div class="flex flex-wrap items-center me-auto">
                    <x-lucide-file-text class="w-5 h-5 text-primary-orange flex-shrink-0 me-2"/>
                    <h2 class="font-medium text-xl dark:text-gray-300 transition">Trabalhos do grupo</h2>
                </div>
                <template x-if="groups[0]?.papers">
                    <div class="mb-2">
                        <span x-text="(groups[0]?.papers?.length ?? 0) + ' arquivos'" class="text-gray-600 dark:text-gray-300 transition">X arquivos</span>
                    </div>
                </template>
            </div>
            <ul class="space-y-2" :class="groups[0]?.state === 0 ? 'pointer-events-none' : ''">
                <template x-for="paper in (groups[0]?.papers ?? [])">
                    <li class="flex flex-col space-y-1">
                        <button
                            type="button"
                            class="flex items-center p-3 rounded justify-between bg-gray-200/40 hover:bg-gray-200/60 dark:bg-gray-700/40 dark:hover:bg-gray-700/50  transition"
                            :class="{
                                'cursor-pointer': paper.state !== 0,
                                'cursor-default opacity-50': paper.state === 0,
                                'pb-2': paperExpanded[paper.id ?? paper.tempId]
                            }"
                            @click="paperExpanded[paper.id] = !paperExpanded[paper.id]"
                            :title="paper.title"
                        >
                            <span class="ms-1 flex flex-row items-center space-x-2 overflow-hidden">
                                <x-lucide-chevron-right
                                    class="w-4 h-4  flex-shrink-0 transition dark:text-gray-300"
                                    x-bind:class="{
                                        'rotate-90': paperExpanded[paper.id ?? paper.tempId],
                                        'opacity-0': paper.state === 0,
                                        'text-gray-600 dark:text-gray-200': paper.state
                                    }"
                                />
                                <x-lucide-file-text class="w-4 h-4 text-primary-orange flex-shrink-0"/>
                                <span
                                    class="font-medium transition"
                                    :class="{
                                        'text-gray-700 dark:text-gray-200 truncate text-ellipsis': true,
                                        'line-through': !paper.state && paper.id !== null
                                    }"
                                    x-text="paper.title"
                                    :title="paper.title"
                                >Trabalho</span>
                            </span>
                            <template x-if="paper.state === 0">
                                <span class="ms-5" x-text="'(Inativo)'"></span>
                            </template>
                        </button>
                        <div x-show="paperExpanded[paper.id] && paper.state !== 0"
                             class="p-2 px-5 rounded bg-gray-50 dark:bg-gray-700/90 text-gray-500 dark:text-gray-400 transition">
                            <div class="grid grid-cols-2 xs:grid-cols-4 gap-y-4 mt-2">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-calendar class="w-3 h-3 "/>
                                        <span class=" text-sm">Ano</span>
                                    </div>
                                    <span x-text="paper.year" class="text-gray-800 dark:text-gray-200"></span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-book-open class="w-3 h-3 "/>
                                        <span class=" text-sm">Semestre</span>
                                    </div>
                                    <span x-text="paper.semester" class="text-gray-800 dark:text-gray-200"></span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-folder-kanban class="w-3 h-3 "/>
                                        <span class=" text-sm">Projeto</span>
                                    </div>
                                    <span x-text="paper.project" class="text-gray-800 dark:text-gray-200"></span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center space-x-1">
                                        <x-lucide-layers-2 class="w-3 h-3 "/>
                                        <span class=" text-sm">Versão</span>
                                    </div>
                                    <span x-text="paper.version === 'evaluation' ? 'Avaliação' : 'Corrigida'" class="text-gray-800 dark:text-gray-200"></span>
                                </div>
                            </div>
                            <hr class="border-t border-gray-200 dark:border-gray-600 transition duration-150 ease-in-out my-2">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="flex items-center mt-auto">
                                    <button
                                        class="w-full flex justify-center items-center whitespace-nowrap overflow-hidden text-ellipsis rounded-lg
                                             px-4 py-2 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue bg-transparent focus:border-secondary-blue
                                             hover:bg-gray-200/60 dark:hover:bg-gray-600 transition"
                                        x-on:click="$el.blur(); paper.file_path ? showPaper(`${paper.file_path}`) : window.open(paper.url, '_blank')"
                                    >
                                        Visualizar
                                    </button>
                                </div>

                                <div class="flex items-center mt-auto">
                                    <button
                                        class="w-full flex justify-center items-center whitespace-nowrap overflow-hidden text-ellipsis rounded-lg
                                             px-4 py-2 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue bg-transparent focus:border-secondary-blue
                                             hover:bg-gray-200/60 dark:hover:bg-gray-600 transition"
                                        x-on:click="$el.blur(); window.open(paper.file_path, '_blank');"
                                    >
                                        Nova aba
                                    </button>
                                </div>

                                <div class="flex items-center mt-auto">
                                    <a
                                        class="w-full flex justify-center items-center whitespace-nowrap overflow-hidden text-ellipsis rounded-lg
                                             px-4 py-2 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue bg-transparent focus:border-secondary-blue
                                             hover:bg-gray-200/60 dark:hover:bg-gray-600 transition"
                                        x-on:click="$el.blur();"
                                        :href="paper.file_path"
                                        download
                                    >
                                        Baixar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </template>

                <template x-if="groups[0]?.papers?.length < 1">
                    <div class="flex flex-col items-center justify-center text-center pt-5">
                        <p class="text-gray-700 text-md font-medium dark:text-gray-300 transition">
                            Ainda não há nenhum trabalho cadastrado para o seu grupo.
                        </p>
                        <p class="text-gray-500 mt-1 text-sm">
                            Assim que houver, eles serão listados aqui.
                        </p>
                        <x-lucide-book-open class="shrink-0 w-12 h-12 mt-6 text-gray-500 dark:text-gray-300 transition"/>
                    </div>
                </template>
                <template x-if="groups[0]?.state === 0">
                    <div class="flex flex-col items-center justify-center text-center pt-5">
                        <p class="text-gray-700 text-md font-medium dark:text-gray-300 transition">
                            Não é possível exibir trabalhos de grupos inativos
                        </p>
                        <p class="text-gray-500 mt-1 text-sm">
                            Caso seu grupo seja reativado, seus trabalhos aparecerão aqui.
                        </p>
                        <x-lucide-frown class="shrink-0 w-12 h-12 mt-6 text-gray-500 dark:text-gray-300 transition"/>
                    </div>
                </template>
            </ul>
        </div>
    </div>
</div>
