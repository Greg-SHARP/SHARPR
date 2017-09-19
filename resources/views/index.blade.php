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
@endsection