<x-filament-panels::page>
    <form wire:submit="save" id="form" class="grid gap-y-6">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getFormActions()"
            alignment="center"
            class="mt-4"
        />
    </form>
</x-filament-panels::page>
