<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['badge','badgeColor','color','tooltip','icon','size','labelSrOnly','class'])
<x-filament::icon-button :badge="$badge" :badge-color="$badgeColor" :color="$color" :tooltip="$tooltip" :icon="$icon" :size="$size" :label-sr-only="$labelSrOnly" :class="$class" >

{{ $slot ?? "" }}
</x-filament::icon-button>