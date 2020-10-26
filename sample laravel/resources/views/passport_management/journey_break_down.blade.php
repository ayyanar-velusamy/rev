@if($journey)
	@if($journey->milestones->count() > 0)
		<div class='msTimeline white-box' >
			<ul id='milestone_timeline'>
				@foreach($journey->milestones as $milestone)
				@php($break_down = $milestone->break_down((($category == 'user') ? user_id() : ''))->first())
				@if($break_down)
					@php($type = $milestone->milestone_type_name())
					@php($assigned_count += $break_down->assigned_count)
					@php($completed_count += $break_down->completed_count)
					@php($completed = (($break_down->assigned_count != 0) &&  ($break_down->assigned_count == $break_down->completed_count)) ? "completed" : "")
				
					  <li class='mileStone {{ $completed }}'>
						<div class='content'>
						  <div class="mileStoneTitle" title="{{$milestone->title}}">{{$milestone->title}}</div>
						  <div class="mileStoneIcon {{ strtolower($type) }}" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>{{$type}}</b> <i>{{$milestone->description}}</i>"></div>
						</div>
					  </li>
					@endif
				@endforeach
			</ul>
		</div>
		@php($percentage = ($assigned_count > 0) ? round(($completed_count/$assigned_count)*100) : 0)
		<script>
		/*Tool Tip Start*/
		$(function () {	
		  $('#inputProgressName .progress-bar').css('width','{{$percentage}}%')
		  $('#inputProgressName .progress-bar span').text('{{$percentage}}%')
		  
		  $("#milestone_timeline .completed").last().addClass('last').prevAll().addClass('blueLine');
		  $("body").addClass('timeline_tooltip');
		  $('.msTimeline [data-toggle="tooltip"]').tooltip( { 
			  position :{ my: 'left top', at: 'right+10 top', html: true ,
			  
			  using: function( position, feedback ) {
				  $( this ).css( position );
				  $( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
				}
			  }
		  });
		})

		$.widget("ui.tooltip", $.ui.tooltip, {
			options: {
				content: function () {
					return $(this).prop('title');
				}
			}
		});
		/*Tool Tip End*/
		
		/*Milestone  Time Line Scroller*/

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
		function setBreakDownResponsive(){
			//var total_width = $('#journeyBreakDown').width();
			var milestone_width = $('#milestone_timeline').width();
			var different = ((breakdownpage_width - milestone_width)/160);
			var append_li_count = Math.floor(different);
			var append_last_li_with_width = Math.round((different - append_li_count) * 160);
			
			var append_last_li_width = append_last_li_with_width - 31;
			
			for (i=0; i <= append_li_count; i++) {				
				$("#milestone_timeline").append('<li id="'+ i +'" ></li>');
			}
			if(breakdownpage_width > milestone_width) {
				$("#milestone_timeline li").last().css({'width': append_last_li_width , 'min-width' : append_last_li_width });
			}
			
			console.log(breakdownpage_width)
			console.log(milestone_width)
			console.log(different)
			console.log(append_li_count)
			console.log(append_last_li_with_width)
		}
		setBreakDownResponsive()
		</script>
	@endif
@endif

