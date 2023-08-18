{{-- @props(['item', 'statePath']) --}}

@props([
    'record',
    'containerKey',
    'tree',
    'title' => null,
    'icon'  => null,
])
@php
    /** @var $record \Illuminate\Database\Eloquent\Model */
    /** @var $containerKey string */
    /** @var $tree \SolutionForest\FilamentTree\Components\Tree */
    $recordKey   = $tree->getRecordKey($record);
    $itemKey     = $containerKey . '-' . $recordKey;
    $parentKey   = $tree->getParentKey($record);

    $children = $record->children;

    $actions = $tree->getActions();
@endphp

<div
    x-data="{ open: $persist(true) }"
    wire:key="{{ $itemKey }}"
    data-id="{{ $itemKey }}"
    class="space-y-2"
    data-sortable-item
>
    <div class="group relative">
        <div
            @class([
                'flex w-full rounded-lg border border-gray-300 bg-white',
                'dark:border-gray-600 dark:bg-gray-700' => config('filament.dark_mode'),
            ])
        >
            <button
                type="button"
                @class([
                    'flex items-center rounded-l-lg border-r border-gray-300 bg-gray-50 px-px',
                    'dark:border-gray-600 dark:bg-gray-800' => config('filament.dark_mode'),
                ])
                data-sortable-handle
            >
                @svg('heroicon-o-ellipsis-vertical', 'text-gray-400 w-4 h-4 -mr-2')
                @svg('heroicon-o-ellipsis-vertical', 'text-gray-400 w-4 h-4')
            </button>

            <button
                type="button"
                wire:click="editItem('{{ $recordKey }}')"
                class="appearance-none px-3 py-2 text-left"
            >
                <span>{{ $title }}</span>
            </button>

            @if (count($children) > 0)
                <button
                    type="button"
                    x-on:click="open = !open"
                    title="Toggle children"
                    class="appearance-none text-gray-500"
                >
                    <svg
                        class="h-3.5 w-3.5 transition duration-200 ease-in-out"
                        x-bind:class="{
                            '-rotate-90': ! open,
                        }"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
            @endif
        </div>

        {{-- <div @class([ --}}
        {{-- 'absolute top-0 right-0 h-6 divide-x rounded-bl-lg rounded-tr-lg border-gray-300 border-b border-l overflow-hidden rtl:border-l-0 rtl:border-r rtl:right-auto rtl:left-0 rtl:rounded-bl-none rtl:rounded-br-lg rtl:rounded-tr-none rtl:rounded-tl-lg hidden opacity-0 group-hover:opacity-100 group-hover:flex transition ease-in-out duration-250', --}}
        {{-- 'dark:border-gray-600 dark:divide-gray-600' => config('filament.dark_mode'), --}}
        {{-- ])> --}}
        {{-- <button --}}
        {{-- x-init --}}
        {{-- x-tooltip.raw.duration.0="{{__('filament-navigation::filament-navigation.items.add-child')}}" --}}
        {{-- type="button" --}}
        {{-- wire:click="addChild('{{ $containerKey }}')" --}}
        {{-- class="p-1" --}}
        {{-- title="{{__('filament-navigation::filament-navigation.items.add-child')}}" --}}
        {{-- > --}}
        {{-- @svg('heroicon-o-plus', 'w-3 h-3 text-gray-500 hover:text-gray-900') --}}
        {{-- </button> --}}

        {{-- <button --}}
        {{-- x-init --}}
        {{-- x-tooltip.raw.duration.0="{{__('filament-navigation::filament-navigation.items.remove')}}" --}}
        {{-- type="button" --}}
        {{-- wire:click="removeItem('{{ $containerKey }}')" --}}
        {{-- class="p-1" --}}
        {{-- title="{{__('filament-navigation::filament-navigation.items.remove')}}" --}}
        {{-- > --}}
        {{-- @svg('heroicon-o-trash', 'w-3 h-3 text-danger-500 hover:text-danger-900') --}}
        {{-- </button> --}}
        {{-- </div> --}}
    </div>

    <div x-show="open" x-collapse class="ml-6">
        <div
            class="space-y-2"
            wire:key="{{ $itemKey }}-children"
            x-data="navigationSortableContainer({
                        statePath: @js($itemKey . '.children'),
                    })"
        >
            @foreach ($children as $child)
                @php
                    $title = $this->getTreeRecordTitle($child);
                    $icon  = $this->getTreeRecordIcon($child);
                @endphp

                <x-filament-tree::tree.nav-item
                    :record="$child"
                    :containerKey="$containerKey"
                    :tree="$tree"
                    :title="$title"
                    :icon="$icon"
                />
            @endforeach
        </div>
    </div>
</div>
