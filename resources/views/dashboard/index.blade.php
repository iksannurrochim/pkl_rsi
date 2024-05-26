@section('content')

<div class="container-scroller">
    <main>
        <div class="row g-10">
            @if (Auth::user()->role == '1')
            @include('uspeserta.dashboardpeserta')
            @elseif (Auth::user()->role == '2')
            @include('peserta.profiladmin')
            @else 
            @include('uspenyelia.profilpenyelia')
            @endif
        </div>
    </main>
</div>
@endsection