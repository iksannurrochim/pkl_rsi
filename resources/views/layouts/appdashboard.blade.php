<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials._head')


    </head>
    <body class="hold-transition">
        <div class="wrapper">
            @include('layouts.partials._navbardashboard')
            {{-- @include('layouts.partials._sidebar') --}}
            <div class="content-wrapper">
                @yield('content')
            </div>

            @include('layouts.partials._footer')
        </div>
        @include('layouts.partials._script')
    </body>
</html>