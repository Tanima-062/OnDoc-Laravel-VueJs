


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    @foreach($products as $key=>$product)
        @php
            $file_name = $folder_name."{$product->id}.png";
            if (getDisk() == 'public') {
                $file_url = Storage::disk('public')->url($file_name);
            } else if (getDisk() =='exoscale') {
                $file_url = Storage::disk('exoscale')->publicUrl($file_name);
            }
            echo getDisk();
        @endphp
            <div class="container" style="margin-top:60px;">
                <div class="row" style="text-align: center; width:100%;margin:0 auto;padding-top:40px;">
                    {{ $file_url }}
                    <img src="{{ $file_url }}" height="400" width="400">
                </div>
                <div>
                    <div class="row" style="margin-top:100px;">
                        <div style="font-weight:700; font-size:20px; text-align:center">{{ __('Product ID', [], $lang) }}</div>
                        <div style="text-align:center">{{$product->prefix_id}}</div>
                    </div>
                    <div class="row" style="margin-top:105px">
                        <div style="font-weight:700; font-size:20px; text-align:center">{{ __('Serial Number', [], $lang) }}</div>
                        <div style="text-align:center">{{$product->serial_number}}</div>
                    </div>
                    <div class="row" style="margin-top:105px;">
                        <div style="font-weight:700; font-size:20px; text-align:center">{{ __('Supplier', [], $lang) }}</div>
                        <div style="text-align:center">{{$product->supplier->name}}</div>
                    </div>
                    <div class="row" style="margin-top:105px;">
                        <div style="font-weight:700; font-size:20px; text-align:center">{{ __('Category', [], $lang) }}</div>
                        <div style="text-align:center">{{$product->category->name}}</div>
                    </div>
                    <div class="row" style="margin-top:105px;">
                        <div style="font-weight:700; font-size:20px; text-align:center">{{ __('Status', [], $lang) }}</div>
                        <div style="text-align:center">{{ucfirst($product->status)}}</div>
                    </div>
                    <div style="bottom:20px;margin-top:60px;">
                        <div class="row">
                            {{ __('Created By', [], $lang) }}
                        </div>
                        <div class="row">
                            <img src="{{ public_path() . '/images/pdf_logo.jpg' }}" height="30" width="100">
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
</body>
</html>
