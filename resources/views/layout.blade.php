@include('includes.head')
@include('includes.header')
@if($controller == 'Owner')
@include('includes.sidebar')
@endif
@if($controller == 'Client')
    @include('includes.sidebar-client')
@endif
@yield('content')
@include('includes.footer')