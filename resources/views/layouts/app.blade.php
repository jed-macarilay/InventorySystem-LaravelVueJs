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

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app id="inspire" :style="{background: $vuetify.theme.themes.dark.background,}">
            @auth
            <sidebar
                current-link="{{ Request::path() }}"
                auth="{{ Auth::user()->user_type }}"
            ></sidebar>
            @endauth

            <v-container class="main-page">
                @auth
                    <v-toolbar
                        color="#218c74" 
                        dark
                        flat 
                        class="ml-auto ml-lg-5 mt-n4"
                    >
                        <v-toolbar-title>DENLEE VARIETY STORE</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <a class="pa-4" href="/notifications">
                            @php 
                                $notification_count = App\Notification::get()->count();
                            @endphp
                            <v-badge content="{{ $notification_count }}" class="" dark>
                                <v-icon color="white">fa fa-bell</v-icon>
                            </v-badge>
                        </a>
                    </v-toolbar>
                    <v-toolbar color="rgba(0,0,0,0)" flat class="">
                        <v-btn-toggle tile group color="#49D9A0" >
                            <v-btn 
                                href="{{ url()->previous() }}" 
                                text
                            >
                                <v-icon>fa fa-arrow-left</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </v-toolbar>
                @endauth
                <div class="ml-auto ml-lg-7">
                    @yield('content')
                </div>
            </v-container>
        </v-app>
    </div>
</body>
</html>

<style>
    @media (min-width: 1440px) {
        .main-page {
            margin-left: 4vw;
        }
    }
</style>