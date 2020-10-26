$(function(){
	approvalGraph();
	libraryGraph();
	topFiveUsers();
	milestoneGraph();
});

function approvalGraph(){
	sendGetRequest(APP_URL+'approval_graph/',function(response){
		if(response.status){
			graphApproaval(response.data)
		}
	});
}
// Build the chart

function graphApproaval(data){
	var g_data =[{
				name: 'Pending',
				y: parseInt(data.pending),
				color: "#96ac28",
				selected: true
			}, {
				name: 'Accepted',
				y: parseInt(data.approved),
				color: "#bbdc00"
			}, {
				name: 'Rejected',
				y: parseInt(data.rejected),
				color: "#d42f2f"
			}];
	setTimeout(function(){
	Highcharts.chart('graphApproaval', { 
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: ''
		},
		tooltip: {
		   // pointFormat: '{point.name}: <b>{point.percentage:1f}</b>',
			formatter: function () {
			   return this.point.name + ': <b>' + Highcharts.numberFormat(this.point.y, 0) + '</b>';
		   }
		},
		accessibility: {
			point: {
				valueSuffix: ''
			}
		},
		plotOptions: {
			pie: {
				size: 304,
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: true
			}
		},
		series: [{
			name: 'Approval Status',
			colorByPoint: true,
			data:g_data
		}]
	});
	})
}



function libraryGraph(){
	sendGetRequest(APP_URL+'library_graph/',function(response){
		if(response.status){
			graphLibrary(response.data);
		}
	});
}

function graphLibrary(data){ 
	var g_data = [{
					name: 'Article',
					y: parseInt(data[0].count),
					sliced: false,
					color: "#088dc5",
					selected: true
				}, {
					name: 'Video',
					y: parseInt(data[1].count),
					color: "#d42f2f"
				}, {
					name: 'Podcast',
					y: parseInt(data[2].count),
					color: "#bbdc00"
				}, {
					name: 'Book',
					y: parseInt(data[3].count),
					color: "#6475ae"
				},{
					name: 'Courses',
					y: parseInt(data[4].count),
					color: "#a5bf22"
				}, {
					name: 'Event',
					y: parseInt(data[5].count),
					color: "#008e8e"
				}, {
					name: 'Assessments',
					y: parseInt(data[6].count),
					color: "#384f98"
				}];
				
	setTimeout(function(){
		Highcharts.chart('graphLibrary', { 
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			tooltip: {
			   // pointFormat: '{point.name}: <b>{point.percentage:1f}</b>',
				formatter: function () {
				   return this.point.name + ': <b>' + Highcharts.numberFormat(this.point.y, 0) + '</b>';
			   }
			},
			accessibility: {
				point: {
					valueSuffix: ''
				}
			},
			plotOptions: {
				pie: {
					size: 304,
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Approval Status',
				colorByPoint: true,
				data: g_data
			}]
		});
	});
}
function topFiveUsers(){
	sendGetRequest(APP_URL+'top_five_users/',function(response){
		if(response.status){
		 $('#topFiveUser').html('');	
		 $.each(response.data,function(k,v){
			 $('#topFiveUser').append('<div class="row inner-content px-0"><div class="col-md-3 topUserImg pl-4 pr-0"><img width="70" height="70" src="'+v.image+'" /></div><div class="col-md-9 topUserInfo pl-3"><h4>'+v.username+'</h4><h5>'+v.points+'<span> Points</span></h5></div></div>');
		 })
		}
	});
}

function milestoneGraph(){
	sendGetRequest(APP_URL+'milestone_graph/',function(response){
		console.log(response)
	});
}

function userSignupGraph(){
	sendGetRequest(APP_URL+'user_signup_graph/',function(response){
		console.log(response)
	});
}

function userLoginGraph(){
	sendGetRequest(APP_URL+'user_login_graph/',function(response){
		console.log(response)
	});
}