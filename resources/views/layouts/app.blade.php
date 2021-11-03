<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @trixassets
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script>

            /*
            *Initialize a web socket client  
            *
            */
            function clientSocket(config = {}) {
                let route = config.route || "127.0.0.1";
                let port  = config.port || "3280";
                window.Websocket = window.WebSocket || window.MozWebSocket;
                return new WebSocket("ws://"+ route + ":" + port);
              }

              //instantiate a connection 
              var connection = clientSocket();

              /**
               * When the connection is open 
              */
             connection.onopen = function () {
                 console.log('Connetion was succesfully created');
               }            
   

               /**
                * The event listener that will be dispatched 
                * to the websocket server.
               */
               window.addEventListener('event-notification', event => {
                connection.send(JSON.stringify({
                    eventName: event.detail.eventName,
                    eventMessage: event.detail.eventMessage
                }));       
            }); 
            
           

        </script>

    </body>
</html>
