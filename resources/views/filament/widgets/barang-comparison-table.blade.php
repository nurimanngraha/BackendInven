{{-- resources/views/filament/widgets/barang-comparison-table.blade.php --}}
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">Jenis</th>
                <th class="px-4 py-2 text-right">Total</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($data as $row)
                <tr>
                    <td class="px-4 py-2">{{ $row['jenis'] }}</td>
                    <td class="px-4 py-2 text-right">{{ number_format($row['total']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
