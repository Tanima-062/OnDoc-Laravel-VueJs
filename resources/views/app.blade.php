<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Ondoc Dashboard</title>


    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{asset('favicon.svg')}}" type="image/svg+xml">
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script> --}}
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
    @inertiaHead
</head>

<body>
    @inertia


</body>

</html>
