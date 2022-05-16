<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.Landing.meta')

    <title>@yield('title') | SERV</title>

    {{-- Styles --}}
    @stack('before-style')
    @include('includes.Landing.style')
    @stack('after-style')
</head>
<body class="antialiased">
    <div class="relative">
        
        @include('includes.Landing.header')

            @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

            @yield('content')

        @include('includes.Landing.footer')    

        {{-- Scripts --}}
        @stack('before-script')
        @include('includes.Landing.script')
        @stack('after-script')
        
        {{-- Modals --}}
        @include('components.Modal.login')
        @include('components.Modal.register')
        @include('components.Modal.register-success')
    </div>
</body>
</html>