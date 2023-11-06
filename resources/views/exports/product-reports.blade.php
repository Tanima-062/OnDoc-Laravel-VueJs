@php
    $lang_code = auth()->user()->language->code
@endphp
<table>
    <thead>
    <tr>
        <th>{{ __('Product ID', [], $lang_code) }}</th>
        <th>{{ __('Serial Nr.', [], $lang_code) }}</th>
        <th>{{ __('Product', [], $lang_code) }}</th>
        <th>{{ __('Supplier', [], $lang_code) }}</th>
        <th>{{ __('Category', [], $lang_code) }}</th>
        <th>{{ __('Status', [], $lang_code) }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)

        <tr>
             <td>{{ $report->prefix_id }}</td>
             <td>{{ $report->serial_number  }}</td>
             <td>{{ $report->name  }}</td>
             <td>{{ $report->supplier->name  }}</td>
             <td>{{ $report->category->name  }}</td>
             <td>{{ trans(ucfirst($report->status), [], $lang_code)  }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
