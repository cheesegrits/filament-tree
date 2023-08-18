@props(['records', 'containerKey', 'tree'])

<div wire:key="navigation-items-wrapper">
    <div
            class="space-y-2"
            x-data="navigationSortableContainer({
                statePath: {{ $containerKey }}
            })"
            data-sortable-container
    >
        @forelse ($records ?? [] as $record)
            @php
                $title = $this->getTreeRecordTitle($record);
                $icon = $this->getTreeRecordIcon($record);
            @endphp
            <x-filament-tree::tree.nav-item
                    :record="$record"
                    :containerKey="$containerKey"
                    :tree="$tree"
                    :title="$title"
                    :icon="$icon"
            />
{{--        @endforeach--}}
{{--        @forelse($getState() as $uuid => $item)--}}
{{--            <x-filament-navigation::nav-item :statePath="$getStatePath() . '.' . $uuid" :item="$item"/>--}}
        @empty
            <div @class([
                    'w-full bg-white rounded-lg border border-gray-300 px-3 py-2 text-left',
                    'dark:bg-gray-700 dark:border-gray-600' => config('forms.dark_mode'),
                ])>
                {{__('filament-navigation::filament-navigation.items.empty')}}
            </div>
        @endforelse
    </div>
</div>

