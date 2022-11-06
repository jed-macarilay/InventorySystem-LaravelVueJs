<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app id="inspire" :style="{background: $vuetify.theme.themes.dark.background,}">
            <sidebar></sidebar>

            <v-container>
                <v-toolbar color="rgba(0,0,0,0)" flat class="mt-n4">
                    <v-btn-toggle tile group color="#49D9A0" >
                        <v-btn text>
                            <v-icon>fa fa-arrow-left</v-icon>
                        </v-btn>
                        <v-btn text>
                            <v-icon>fa fa-arrow-right</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-toolbar>
                @yield('content')
            </v-container>
        </v-app>
    </div>
</body>
</html>
