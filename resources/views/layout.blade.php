@include('includes.head')
@include('includes.header')
@if(Auth::user()->role == 'owner' || Auth::user()->role == 'dev')
@include('includes.sidebar')
@endif
@if(Auth::user()->role == 'client' || Auth::user()->role == 'manager')
    @include('includes.sidebar-client')
@endif
@yield('content')
@include('includes.footer')