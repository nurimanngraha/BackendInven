@php
    $user = filament()->auth()->user();
    $items = filament()->getUserMenuItems();

    $profileItem = $items['profile'] ?? $items['account'] ?? null;
    $profileItemUrl = $profileItem?->getUrl();
    $profilePage = filament()->getProfilePage();
    $hasProfile = filament()->hasProfile() || filled($profileItemUrl);

    $logoutItem = $items['logout'] ?? null;

    // Hilangkan duplikat account/logout/profile dari daftar item
    $items = \Illuminate\Support\Arr::except($items, ['account', 'logout', 'profile']);
@endphp

{{ \Filament\Support\Facades\FilamentView::renderHook('panels::user-menu.before') }}

<x-filament::dropdown
    placement="bottom-end"
    :teleport="false"
    :attributes="
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-user-menu'])
    "
>
    <x-slot name="trigger">
        <button
            aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}"
            type="button"
        >
            <x-filament-panels::avatar.user :user="$user" />
        </button>
    </x-slot>

    <style>
    .fi-user-menu .fi-dropdown-panel {
        top: 100% !important; /* paksa muncul tepat di bawah trigger */
        margin-top: 0.5rem !important; /* beri sedikit jarak */
    }
    </style>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::user-menu.profile.before') }}

    {{-- ====== Bagian Profil ====== --}}
    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            :color="$profileItem?->getColor()"
            :icon="$profileItem?->getIcon() ?? 'heroicon-m-user-circle'"
            :href="$profileItemUrl ?? filament()->getProfileUrl()"
            icon-alias="panels::user-menu.profile-item"
            tag="a"
            class="!mt-0" {{-- ⬅️ fix agar ikon profil tidak naik ke atas --}}
        >
            {{ $profileItem?->getLabel() ?? ($profilePage ? $profilePage::getLabel() : null) ?? filament()->getUserName($user) }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>

    {{-- Garis pemisah antara profil dan menu lainnya --}}
    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

    {{-- ====== Bagian Menu dan Logout ====== --}}
    <x-filament::dropdown.list>
        @foreach ($items as $key => $item)
            <x-filament::dropdown.list.item
                :color="$item->getColor()"
                :href="$item->getUrl()"
                :icon="$item->getIcon()"
                tag="a"
            >
                {{ $item->getLabel() }}
            </x-filament::dropdown.list.item>
        @endforeach

        <x-filament::dropdown.list.item
            :action="$logoutItem?->getUrl() ?? filament()->getLogoutUrl()"
            :color="$logoutItem?->getColor()"
            :icon="$logoutItem?->getIcon() ?? 'heroicon-m-arrow-left-on-rectangle'"
            icon-alias="panels::user-menu.logout-button"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('filament-panels::layout.actions.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>

</x-filament::dropdown>

{{ \Filament\Support\Facades\FilamentView::renderHook('panels::user-menu.after') }}
