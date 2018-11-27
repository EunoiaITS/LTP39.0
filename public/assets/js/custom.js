
(function($) {

  "use strict";
	/*=======================================================
    // Vertical Center Welcome
    ======================================================*/
    setInterval(function () {
        var widnowHeight = $(window).height();
        var introHeight = $(".parking-kori-login").height();
        var paddingTop = widnowHeight - introHeight;
        $(".parking-kori-login").css({
            'padding-top': Math.round(paddingTop / 2) + 'px',
            'padding-bottom': Math.round(paddingTop / 2) + 'px'
        });
    }, 10);

    /*--========================
    // nice scroll
    =========================-*/

    $("body, .get-select-picker, #sidebar-menu").niceScroll({
	   cursorwidth:"6px"
	 });

    /*--====================
    modal hide with custom js
    ===========================--*/

    $("#modal-hide").click(function(){
    	$(".model-that-hide").modal("hide");
    })

    /*--============================
	user icon toggle class
	============================--*/
	  $(".user-icon").on('click', function(){
	    $(".user-dropdown").toggleClass('new-user');
	  });
	  $(".user-dropdown ul li a").on('click', function(){
	    $(".user-dropdown").removeClass('new-user');
	  });
    
    // page click indication loader --*/

    $(".btn-info").click(function(){
        $(".click-loading-option").addClass("addclickloading").delay(1500).fadeOut('fade');
    });

    /*--============================
	sidebar plus icon toggle class
	============================--*/
	 $(".panel-default a").on('click', function(){
	    $(this).toggleClass('click-color');
	});

	/*--=================
    bootstrap select
    =================--*/
    $('.get-select-picker').selectpicker({});

    /*=======================================
		Datepicker init
	=========================================*/

  	$('.datepicker-f').datetimepicker({
	    format: "YYYY-MM-DD",
	    icons: {
	      up: 'fa fa-angle-up',
	      down: 'fa fa-angle-down',
	      previous: 'fa fa-angle-left',
	      next: 'fa fa-angle-right',
	    },
		minDate: moment(),
	});

    $('.datepicker-d').datetimepicker({
        format: "DD/MM/YYYY",
        icons: {
            up: 'fa fa-angle-up',
            down: 'fa fa-angle-down',
            previous: 'fa fa-angle-left',
            next: 'fa fa-angle-right',
        },
        maxDate: moment(),
    });

  	/*======================
	time-et-select-picker
	=========================--*/
  	$('#datetimepicker3').datetimepicker({
        format: 'LT'
    });
  	$('#datetimepicker4').datetimepicker({
        format: 'LT'
    });


	/*--========================
	slidebar call js
	========================--*/
	$('.slide-drawer-menu').on('click', function(e) {
		e.preventDefault();
		$('body').toggleClass('nav-open');
	});

	$('.slide-drawer-menu').on('click', function(e) {
		e.preventDefault();
		$(this).toggleClass('slide-drawer');
	});

	/*--=============================
	// dataTables call
	==============================--*/
 	$('#example').DataTable({
    	responsive: true,
    	"searching": true,
    	"lengthChange": false,
    	"pageLength": 8,
    	"ordering":true,
    	"language": {
		    "paginate": {
		      "previous": "<i class='fas fa-angle-double-left'></i>",
		      "next": "<i class='fas fa-angle-double-right'></i>"
		    }
		}
    });

    /*--============================
    datatable call 2
    =============================--*/
    $('#example2').DataTable({
    	responsive: true,
    	"searching": true,
    	"lengthChange": false,
    	"pageLength": 8,
    	"ordering":true,
    	"language": {
		    "paginate": {
		      "previous": "<i class='fas fa-angle-double-left'></i>",
		      "next": "<i class='fas fa-angle-double-right'></i>"
		    }
		}
    });
     /*--============================
    datatable call 3
    =============================--*/
    $('#example3').DataTable({
    	responsive: true,
    	"searching": true,
    	"lengthChange": false,
    	"pageLength": 6,
    	"ordering":true,
    	"language": {
		    "paginate": {
		      "previous": "<i class='fas fa-angle-double-left'></i>",
		      "next": "<i class='fas fa-angle-double-right'></i>"
		    }
		}
    });

})(window.jQuery);
