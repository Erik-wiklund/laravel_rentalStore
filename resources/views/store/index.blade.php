@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-cover bg-center h-screen" style="background-image: url('/images/hero-bg.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center text-white py-32">
            <h1 class="text-5xl font-bold mb-4">Welcome to RentalStore</h1>
            <p class="text-lg mb-8">Browse the best TV shows and movies, or choose your subscription plan today!</p>
            <a href="#subscriptions" class="bg-blue-500 py-2 px-6 rounded-full text-lg">Get Started</a>
        </div>
    </div>

    <!-- Subscriptions Section -->
    <div class="bg-gray-800 text-white py-12" id="subscriptions">
        <h2 class="text-3xl font-bold text-center mb-6">Choose Your Subscription</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
            @foreach ($subscriptions as $subscription)
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-xl font-semibold">{{ $subscription->name }}</h3>
                    <p class="text-lg">{{ $subscription->description }}</p>
                    <p class="text-2xl font-bold">{{ $subscription->price }}</p>
                    <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded mt-4 inline-block">Subscribe Now</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured TV Shows Section -->
    <div class="bg-gray-900 text-white py-12">
        <h2 class="text-3xl font-bold text-center mb-6">Featured TV Shows</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4">
            @foreach ($featuredShows as $show)
                <div class="bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ $show->poster_url }}" alt="{{ $show->title }}" class="w-full h-56 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold">{{ $show->title }}</h3>
                        <p class="text-sm">{{ $show->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Movies Section -->
    <div class="bg-gray-800 text-white py-12">
        <h2 class="text-3xl font-bold text-center mb-6">Featured Movies</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4">
            @foreach ($featuredMovies as $movie)
                <div class="bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-56 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold">{{ $movie->title }}</h3>
                        <p class="text-sm">{{ $movie->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
