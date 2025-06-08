<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ScrollX.io Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/main_layout.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header>
        <nav style="background: #f6f6f6; border-radius: 8px; margin: 30px 20px 0 20px; padding: 10px 30px; display: flex; align-items: center;">
            <a href="{{ url('/dashboard') }}" style="font-size: 2rem; font-weight: bold; color: #555; text-decoration: none; margin-right: 40px; letter-spacing: 1px;">
                DASHBOARD
            </a>
            @if (!empty(Auth()->user()) && !empty(Auth()->user()->is_admin) && Auth()->user()->is_admin == 1)
                <a href="{{ url('/users') }}" style="font-size: 2rem; font-weight: bold; color: #888; text-decoration: none; margin-right: 30px;">
                    Users
                </a>
                <a href="{{ url('/templates') }}" style="font-size: 2rem; font-weight: bold; color: #888; text-decoration: none;">
                    Templates
                </a>
                
            @endif
        </nav>
    </header>