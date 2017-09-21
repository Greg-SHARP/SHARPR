@extends('layouts.master')

@section('content')
	<main ng-app="swipeApp" ng-controller="swipeController">
		<div class="inner_wrap">
			<div class="swiper">
				<swiper>
					<slides>
						<slide><img src="img/court.jpg" /></slide>
						<slide><img src="img/court.jpg" /></slide>
					</slides>
				</swiper>

				<button>Curious Total: @{{ num }}</button>
			</div><!-- .swiper -->
		</div>
	</main>

	@if( DB::connection()->getDatabaseName() )
		<h1 style="padding: 10px;">{{ "Connected to database " . DB::connection()->getDatabaseName() }}</h1>
	@endif

	<h1 style="padding: 10px;">{{ "Environment " . App::environment() }}</h1>
@endsection