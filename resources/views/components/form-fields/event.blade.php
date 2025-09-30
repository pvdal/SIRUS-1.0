<div>
    <div class="mt-4">
        <x-input class="w-full"
            x-model-="committeeId"/>
    </div>

    <div class="mt-4">
        <x-input class="w-full"
                 x-model-="committeeTitle"/>
    </div>

    <div class="flex justify-between">
        <div class="flex gap-2 mb-2">
            <div class="mt-4">
                <x-input type="date" class="w-full"
                    x-model="dateStart"
                />
            </div>

            <div class="mt-4">
                <x-input type="time" class="w-full"
                         x-model="timeStart"/>
            </div>
        </div>

        <div class="flex gap-2 mb-2">
            <div class="mt-4">
                <x-input type="date" class="w-full"
                         x-model="dateEnd"
                />
            </div>

            <div class="mt-4">
                <x-input type="time" class="w-full"
                         x-model="timeEnd"/>
            </div>
        </div>
    </div>
</div>
