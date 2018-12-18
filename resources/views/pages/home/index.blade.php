
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Parking Kori</title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/public/home/img/pk-icon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/public/home/img/pk-icon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/public/home/img/pk-icon.ico') }}">

    <!-- stylesheet css -->
    <link rel="stylesheet" href="{{ asset('/public/home/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/home/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/home/css/bootstrap.min.css') }}">
	<!-- slick slider -->
    <link rel="stylesheet" href="{{ asset('/public/home/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/home/css/bootstrap.min.css') }}">
    <!-- slit slider css -->
    <link rel="stylesheet" href="{{ asset('/public/home/css/slick.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/home/css/slick-theme.css') }}">
	<!-- slit slider -->
	<link rel="stylesheet" href="{{ asset('/public/home/css/styleslit.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/home/css/style.css') }}">
	<!-- mordernizr css -->
	<script src="{{ asset('/public/home/js/vendor/modernizr.custom.79639.js') }}"></script>
</head>
<body>

	<div id="svgLoader">
		<svg class="mainSVG" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
		   <defs>   
		     <path id="puff" d="M4.5,8.3C6,8.4,6.5,7,6.5,7s2,0.7,2.9-0.1C10,6.4,10.3,4.1,9.1,4c2-0.5,1.5-2.4-0.1-2.9c-1.1-0.3-1.8,0-1.8,0
		  	s-1.5-1.6-3.4-1C2.5,0.5,2.1,2.3,2.1,2.3S0,2.3,0,4.4c0,1.1,1,2.1,2.2,2.1C2.2,7.9,3.5,8.2,4.5,8.3z" fill="#fff"/>
		     <circle id="dot"  cx="0" cy="0" r="5" fill="#fff"/>   
		  </defs>

		    <circle id="mainCircle" fill="none" stroke="none" stroke-width="2" stroke-miterlimit="10" cx="400" cy="300" r="130"/>
		    <circle id="circlePath" fill="none" stroke="none" stroke-width="2" stroke-miterlimit="10" cx="400" cy="300" r="80"/>

		    <g id="mainContainer" >
		      <g id="car">
		  <path id="carRot" fill="#FFF"  d="M45.6,16.9l0-11.4c0-3-1.5-5.5-4.5-5.5L3.5,0C0.5,0,0,1.5,0,4.5l0,13.4c0,3,0.5,4.5,3.5,4.5l37.6,0
		  	C44.1,22.4,45.6,19.9,45.6,16.9z M31.9,21.4l-23.3,0l2.2-2.6l14.1,0L31.9,21.4z M34.2,21c-3.8-1-7.3-3.1-7.3-3.1l0-13.4l7.3-3.1
		  	C34.2,1.4,37.1,11.9,34.2,21z M6.9,1.5c0-0.9,2.3,3.1,2.3,3.1l0,13.4c0,0-0.7,1.5-2.3,3.1C5.8,19.3,5.1,5.8,6.9,1.5z M24.9,3.9
		  	l-14.1,0L8.6,1.3l23.3,0L24.9,3.9z"/>      
		      </g>
		    </g>
		</svg>
	</div>
	
	<div class="pk-home-wrapper">
		<div class="header-slider-bg clearfix" id="home">
			<div class="slider-container demo-1">
				<!-- pk header area -->
				<div class="pk-header">
					<!-- Fixed navbar -->
				    <nav class="navbar navbar-default navbar-fixed-top">
				      <div class="container-fluid padding-2">
				        <div class="navbar-header">
				          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				            <span class="sr-only">Toggle navigation</span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				          </button>
				          <a class="navbar-brand" href="#home"><img src="{{ asset('/public/home/img/pklogo.png') }}" alt="Pk Logo"></a>
				        </div>
				        <div id="navbar" class="navbar-collapse collapse">
				          <ul class="nav navbar-nav navbar-center">
				            <li><a href="#home">Home</a></li>
				            <li><a href="#parking">Parking</a></li>
				            <li><a href="#about-us">About Us</a></li>
				            <li><a href="#contact">Contact Us</a></li>
				            <li><a href="{{ url('/login') }}">Login</a></li>
				          </ul>
				          <ul class="nav navbar-nav navbar-right">
				            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
				            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
				          </ul>
				        </div><!--/.nav-collapse -->
				      </div>
				    </nav>
				</div><!--/. end pk header area -->

				<!-- landing area -->
				<div id="slider" class="sl-slider-wrapper">

					<div class="sl-slider">
					
						<div class="sl-slide bg-1" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
							<div class="sl-slide-inner">
								<p><b>Parking Kori</b> is your digital parking automation partner.</p>
							</div>
						</div>
						
						<div class="sl-slide bg-2" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
							<div class="sl-slide-inner">
								<p>Days of handwritten receipt and long queues are over, with <b>ParkingKori</b> these issues can be mitigated through the use of our smart hardware and software solutions.</p>
							</div>
						</div>
						
						<div class="sl-slide bg-3" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
							<div class="sl-slide-inner">
								<p>Experience the parking solutions catered perfectly for the digital age only with <b>ParkingKori</b></p>
							</div>
						</div>

					</div><!-- /sl-slider -->


					<nav id="nav-dots" class="nav-dots">
						<span class="nav-dot-current"></span>
						<span></span>
						<span></span>
					</nav>

				</div><!-- /slider-wrapper -->
			</div>
		</div>
		<div class="clearfix"></div>

		
		<!-- current-status -->
		<div class="pk-current-status" id="parking">
			<div class="container-fluid padding-0">
				<h3 class="pk-title">Current Parking Status</h3>
				<div class="item-slick-carosel">
                    @foreach($all_clients as $ac)
					<div class="item padding-0-pk">
						<div class="padding-0-color color-plate-1">
							<div class="pk-chart">
								<h4 class="pk-chart-title">{{ $ac->name }}</h4>
								 <div class="chart-bundle-js">
								 	<canvas id="chart-area{{ $ac->id }}" width="200px" height="200px"/>
								 </div>
							</div>	
						</div>
					</div>
                    @endforeach
				</div>
			</div>
		</div><!--/ end current status -->

		<!-- about us area -->
		<div class="pk-aboutcontact clearfix">
			<div class="pk-aboutus clearfix" id="about-us">
				<div class="container">
					<div class="col-md-4 col-sm-5 col-sm-offset-2 col-md-offset-0 col-xs-8">
						<div class="pk-about-img">
							<img src="{{ asset('/public/home/img/about-img.jpg') }}" alt="">
							<div class="pk-position-img">
								<img src="{{ asset('/public/home/img/about-img-white.jpg') }}" alt="">
							</div>
						</div>
						
					</div>
					<div class="col-sm-12 col-md-5 col-md-offset-3 col-xs-12">
						<div class="pk-about-details">
							<h2 class="pk-about-title">About Us</h2>
							<p>We here at <b>DexHUB</b> believe that there's always a better way of doing things namely by digitizing and automating every possible aspect of your business. We are obsessively passionate about making your day to day workflow easier.</p>
							<p>Current traditional parking scenarios involve problems such as being very inefficient, time consuming and more over have the problems such as mismanagement and lack of orderly cash management.</p>
							<p>We wanted to have these problems mitigated hence we spent immense time in the research and development of a solution. Therefore let us introduce ParkingKori, your parking automation partner. We are here to ease the hassle of managing parking at your business more efficient and easier than ever.</p>
						</div>
					</div>
				</div>
			</div>

			<!-- contact-us -->
			<div class="pk-contactus cleafix" id="contact">
				<div class="container">
					<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
						<div class="contact-tab-panel">
							<div class="tab-panel-header">
							  <!-- Nav tabs -->
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active"><a href="#contact-us" aria-controls="contact-us" role="tab" data-toggle="tab">
							    	<span class="flaticon-pencil-tool-symbol-in-diagonal-position-for-interface"></span>
							    	Contact Us
							    </a></li>
							    <li role="presentation"><a href="#visit-us" aria-controls="visit-us" role="tab" data-toggle="tab">
							    	<span class="glyph-icon flaticon-placeholder"></span>
							    	Visit Us
							    </a></li>
							  </ul>
							</div>
							<!--================ Tab panes contents ==============-->
						  <div class="tab-content">
						    <div role="tabpanel" class="tab-pane fade in active" id="contact-us">
						    	<!-- contact us form -->
						    	<div class="contact-details-form clearfix">
						    		<form action="{{ url('/contact') }}" method="post">
						    			@csrf
										<div class="form-group clearfix">
							    			<div class="col-sm-6">
							    				<label for="name" class="form-label">Name <span>*</span></label>
							    				<input name="name" type="text" class="form-control from-input" id="name" required="required">
							    			</div>
							    			<div class="col-sm-6">
							    				<label for="email" class="form-label">Email <span>*</span></label>
							    				<input name="email" type="email" class="form-control from-input" id="email" required="required">
							    			</div>
							    			<div class="col-sm-12 clearfix">
							    				<label for="message" class="form-label">Message <span>*</span></label>
							    				<textarea name="message" id="message" cols="30" class="form-control from-input" rows="3"></textarea>
							    			</div>
							    		</div>
							    		<button class="btn btn-info btn-from text-center">Submit</button>
						    		</form>
						    	</div>
						    </div>
						    <div role="tabpanel" class="tab-pane fade" id="visit-us">
						    	<!-- about us map form -->
						    	<div class="contact-details-form clearfix">
						    		<div class="map-area">
						    			<div class="mapouter">
						    				<div class="gmap_canvas">
						    					<iframe id="gmap_canvas" src="https://maps.google.com/maps?q=Green%20Taj%20Center%20Level%202%20Road%208%2FA%20%2C%20Dhanmondi%20Dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
						    				</div>
						    		</div>
						    	</div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
			</div>
			<!-- footer area -->

			<div class="pk-footer-area clearfix">
				<div class="container">
					<div class="pk-footer">
						<p>A Product of <a target="_blank" href="https://www.dexhub.org/">DexHub</a></p>
						<p>Powered by <a target="_blank" href="http://www.eunoiaits.com/">Eunoia I.T Solutions</a></p>
					</div>
				</div>
			</div>
		</div><!--end about us araa -->
	</div>
		<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="modal-title text-center" id="myModalLabel"><img src="{{ asset('/public/assets/img/pksmlogo.png') }}" alt=""></div>
					</div>
					<div class="modal-body">
						<p class="text-center">Your Request has been received. We will contact with you soon!</p>
					</div>
					<button id="ok" type="button" class="btn btn-dark btn-flat">Ok</button>
				</div>
			</div>
		</div>
	
	
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- main js file --> 

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('/public/home/js/vendor/jquery-3.2.1.min.js') }}"><\/script>')</script>
	<!-- bootstrap css -->
    <script src="{{ asset('/public/home/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/public/home/js/niceScroll.min.js') }}"></script>
    <script src="{{ asset('/public/home/js/jquery.malihu.PageScroll2id.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('/public/home/js/slick.min.js') }}"></script>
    <!-- slit slider js -->
    <script src="{{ asset('/public/home/js/jquery.ba-cond.min.js') }}"></script>
    <script src="{{ asset('/public/home/js/jquery.slitslider.js') }}"></script>
    <!-- pic chart -->
    <script src="{{ asset('/public/home/js/Chart.bundle.js') }}"></script>
    <!-- svgleader js -->
    <script src="{{ asset('/public/home/js/TweenMax.min.js') }}"></script>
	<script src="{{ asset('/public/home/js/MorphSVGPlugin.min.js') }}"></script>
	<script src="{{ asset('/public/home/js/svgloader.js') }}"></script>

    <!-- main js file -->
    <script src="{{ asset('/public/home/js/custom.js') }}"></script>

    <script>
    	// slit slider 
    	$(function() {
			
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' ),
						$nav = $( '#nav-dots > span' ),
						slitslider = $( '#slider' ).slitslider( {
							autoplay: true, 
    						interval: 4000,
    						speed : 2500,
    						translateFactor : 230,
							onBeforeChange : function( slide, pos ) {

								$nav.removeClass( 'nav-dot-current' );
								$nav.eq( pos ).addClass( 'nav-dot-current' );

							}
						} ),

						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':last' ).on( 'click', function() {

								slitslider.next();
								return false;

							} );

							$navArrows.children( ':first' ).on( 'click', function() {
								
								slitslider.previous();
								return false;

							} );

							$nav.each( function( i ) {
							
								$( this ).on( 'click', function( event ) {
									
									var $dot = $( this );
									
									if( !slitslider.isActive() ) {

										$nav.removeClass( 'nav-dot-current' );
										$dot.addClass( 'nav-dot-current' );
									
									}
									
									slitslider.jump( i + 1 );
									return false;
								
								} );
								
							} );

						};

						return { init : init };

				})();

				Page.init();

				$.Slitslider.defaults = {
				    // transitions speed
				    speed : 800,
				    // if true the item's slices will also animate the opacity value
				    optOpacity : false,
				    // amount (%) to translate both slices - adjust as necessary
				    translateFactor : 230,
				    // maximum possible angle
				    maxAngle : 25,
				    // maximum possible scale
				    maxScale : 2,
				    // slideshow on / off
				    autoplay : true,
				    // keyboard navigation
				    keyboard : true,
				    // time between transitions
				    interval : 4000,
				    // callbacks
				    onBeforeChange : function( slide, idx ) { return false; },
				    onAfterChange : function( slide, idx ) { return false; }
				};
			
			});


    /*--================
    // window hight css 
    ===================--*/
    $(window).ready(function(){
		$('.slider-container.demo-1').css('height', $(window).height());
	});
	$(window).resize(function(){
		$('.slider-container.demo-1').css('height', $(window).height());
	});
    </script>
    @if(isset($text))
        @if ($text == 1)
            echo "<script type='text/javascript'>
         $(window).on('load',function(){
            $('#myModal').modal('show');
         });
         $('#ok').on('click',function(e) {
           e.preventDefault();
           window.location.href = 'https://pkcompany.acumenits.com';
         });
    </script>";
	@endif
		@endif
        @if(isset($js))
            @include($js)
            @endif
</body>
</html>
