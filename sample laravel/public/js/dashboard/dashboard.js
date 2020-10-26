$(".daterangepicker").each(function(){
	var placeholder = $(this).attr('placeholder'); 

	 $(this).daterangepicker({
		 datepickerOptions : {
			 //changeMonth: true,
			// changeYear: true,
			 numberOfMonths : 2,
			 dateFormat: 'M d, yy',
			 maxDate: null
		 },
		 initialText : placeholder,
		 presetRanges: [], 
	 });
});


if($('.toolipTarget').length > 0) {
 //console.log("We're online.");
  var cursorOnTooltip = false;

  $(".toolipTarget").on("mouseleave", function(ev){
    ev.stopImmediatePropagation(); //don't allow the Tooltip Widget to get hold of this event
    
    window.setTimeout(function(){
      if (!cursorOnTooltip)
        {
          $('.toolipTarget').tooltip("close");
        }
    }, 300); //close the tooltip when the cursor leaves our element, if the cursor is not on the tooltip
    
    $(".dashBluTooltip").on("mouseenter", function(ev){
      cursorOnTooltip = true; //mark the flag so that the tooltip doesn't get closed after 300ms
    });
    $(".dashBluTooltip").on("mouseleave", function(ev){
      // if the cursor leaves the tooltip, close it and unbind all handlers
      cursorOnTooltip = false;
      $('.toolipTarget').tooltip("close");
      $(this).unbind("mouseleave");
      $(this).unbind("mouseenter");
    });
  });

  $('.toolipTarget').tooltip({
  		tooltipClass: "dashBluTooltip",
      position: {
  			my: 'left center', 
			at: 'right+10 center',
			using: function( position, feedback ) {
				$( this ).css( position );
				$( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			},
  		},
  		track:false
  	});	
}


if($('.mstoolipTarget').length > 0) {
 //console.log("We're online.");
  var cursorOnTooltip = false;

  $(".mstoolipTarget").on("mouseleave", function(ev){
    ev.stopImmediatePropagation(); //don't allow the Tooltip Widget to get hold of this event
    
    window.setTimeout(function(){
      if (!cursorOnTooltip)
        {
          $('.mstoolipTarget').tooltip("close");
        }
    }, 300); //close the tooltip when the cursor leaves our element, if the cursor is not on the tooltip
    
    $(".dashWheTooltip").on("mouseenter", function(ev){
      cursorOnTooltip = true; //mark the flag so that the tooltip doesn't get closed after 300ms
    });
    $(".dashWheTooltip").on("mouseleave", function(ev){
      // if the cursor leaves the tooltip, close it and unbind all handlers
      cursorOnTooltip = false;
      $('.mstoolipTarget').tooltip("close");
      $(this).unbind("mouseleave");
      $(this).unbind("mouseenter");
    });
  });

  $('.mstoolipTarget').tooltip({
  		tooltipClass: "dashWheTooltip",
      position: {
  			my: 'left top-10', 
			at: 'right+10 top-10',
			using: function( position, feedback ) {
				$( this ).css( position );
				$( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			},
  		},
  		track:false
  	});	
}		


	$.widget("ui.tooltip", $.ui.tooltip, {
		options: {
			content: function () {
				return $(this).prop('title');
			}
		}
	});
/*Milestone  Time Line Scroller*/
if( $(".jyTimeline ").length > 0){
	$(".jyTimeline ").mCustomScrollbar({
		theme:"minimal",
		axis:"x",
		scrollbarPosition: "inside",
		autoHideScrollbar:true,
		scrollButtons:{ enable: false },
		mouseWheel:{ enable: true },
		advanced:{
		autoExpandHorizontalScroll:true,
		updateOnContentResize:true
		},
	}); 
} 
if( $(".msTimeline").length > 0){
	$(".msTimeline").mCustomScrollbar({
		theme:"minimal",
		axis:"x",
		scrollbarPosition: "inside",
		autoHideScrollbar:true,
		scrollButtons:{ enable: false },
		mouseWheel:{ enable: true },
		advanced:{
		autoExpandHorizontalScroll:true,
		updateOnContentResize:true
		},
	}); 
} 


/*Star Rating*/
$(document).on("click", ".btnrating", function (e) {
    //clearing currrently "rated" star
    $(".btnrating").removeAttr("data-selected");

    var $this = $(this);
	
	//Set rating point
	$('#ratingID').val($this.attr('data-attr'));
	
	//removing Validation error message
	$('#ratingID-error').hide();
	
    //removing ration from all the following stars
    $this.nextAll(".btnrating").removeClass("rated");

    //mark clicked star with data-selected attribute
    $this.addClass("rated").attr("data-selected", "true");

    //mark previous stars
    $this.prevAll(".btnrating").addClass("rated");
	
});

$(document).on("mouseover", ".btnrating", function (e) {
    //unmark rated stars
    $(".btnrating").removeClass("rated");
    var $this = $(this);

    //mark currently hovered star as "hover"
    $(this).addClass("hover");

    //mark preceding stars as "hover"
    $this.prevAll(".btnrating").addClass("hover");
});

$(document).on("mouseout", ".btnrating", function (e) {
    //un-"hover" all the stars
    $(".btnrating").removeClass("hover");

    //mark star with data-selected="true" and preceding stars as "rated"
    $("[data-selected='true']").addClass("rated").prevAll(".btnrating").addClass("rated");
});
