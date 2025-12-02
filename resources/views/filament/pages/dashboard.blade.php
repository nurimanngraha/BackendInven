<x-filament-panels::page>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

    <style>
.fi-widget-chart {
    height: 360px !important;
}
</style>
</x-filament-panels::page>
