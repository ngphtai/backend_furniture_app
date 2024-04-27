$(function() {
    "use strict";
    var TotalOrder = $('#order').val();

    console.log(TotalOrder);
	// chart 1

	$('#chart1').sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8,6,4,5,8,7,10,9,5,8,7,9,5,4,8,7,10,9,5,8,7,9,5,4], {
            type: 'bar',
            height: '25',
            barWidth: '2',
            resize: true,
            barSpacing: '2',
            barColor: '#008cff'
        });

	// chart 2

		$('#chart2').sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8,6,4,5,8,7,10,9,5,8,7,9,5,4,8,7,10,9,5,8,7,9,5,4], {
            type: 'bar',
            height: '25',
            barWidth: '2',
            resize: true,
            barSpacing: '2',
            barColor: '#fd3550'
        });

	// chart 3

		$('#chart3').sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8,6,4,5,8,7,10,9,5,8,7,9,5,4,8,7,10,9,5,8,7,9,5,4], {
            type: 'bar',
            height: '25',
            barWidth: '2',
            resize: true,
            barSpacing: '2',
            barColor: '#15ca20'
        });

	// chart 4

		$('#chart4').sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8,6,4,5,8,7,10,9,5,8,7,9,5,4,8,7,10,9,5,8,7,9,5,4], {
            type: 'bar',
            height: '25',
            barWidth: '2',
            resize: true,
            barSpacing: '2',
            barColor: '#ff9700'
        });


	// chart 7
	var ctx = document.getElementById('chart7').getContext('2d');



  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
		          gradientStroke1.addColorStop(0, 'rgba(255, 255, 0, 0.5)');
		          gradientStroke1.addColorStop(1, 'rgba(233, 30, 99, 0.0)');

		      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
		          gradientStroke2.addColorStop(0, '#ffff00');
		          gradientStroke2.addColorStop(1, '#e91e63');


		      var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
		          gradientStroke3.addColorStop(0, 'rgba(0, 114, 255, 0.5)');
		          gradientStroke3.addColorStop(1, 'rgba(0, 200, 255, 0.0)');

		      var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
		          gradientStroke4.addColorStop(0, '#0072ff');
		          gradientStroke4.addColorStop(1, '#00c8ff');




	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Cn'],
      datasets: [ {
        label: 'Sales',
        data: [5, 30, 16, 23, 8, 14, 11],
        backgroundColor: gradientStroke3,
        borderColor: gradientStroke4,
        pointRadius :"0",
        pointHoverRadius:"0",
        borderWidth: 3
      }]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: true,
				labels: {
					fontColor: '#585757',
					boxWidth: 40
				}
			},
			tooltips: {
				enabled: false
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: '#585757'
					},
					gridLines: {
						display: true,
						color: "rgba(0, 0, 0, 0.07)"
					},
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: '#585757'
					},
					gridLines: {
						display: true,
						color: "rgba(0, 0, 0, 0.07)"
					},
				}]
			}
		}
	});


  // chart 2

  var ctx = document.getElementById('chart-order-status').getContext('2d');

  var gradientStroke = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke.addColorStop(0, '#ee0979');
      gradientStroke.addColorStop(1, '#ff6a00');

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
      datasets: [{
        label: 'Sales',
        data: [9, 7, 14, 10, 12, 8],
        backgroundColor: gradientStroke,
        hoverBackgroundColor: gradientStroke,
        borderColor: "#fff",
        pointRadius :6,
        pointHoverRadius :6,
        pointHoverBackgroundColor: "#fff",
        borderWidth: 2

      }]
    },
  options: {
    maintainAspectRatio: false,
    legend: {
      display: false,
      labels: {
      fontColor: '#585757',
      boxWidth:40
      }
    },
    tooltips: {
      displayColors:false
    },
    scales: {
      xAxes: [{
        barPercentage: .4,
      ticks: {
        beginAtZero:true,
        fontColor: '#585757'
      },
      gridLines: {
        display: true ,
        color: "rgba(0, 0, 0, 0.08)"
      },
      }],
       yAxes: [{
      ticks: {
        beginAtZero:true,
        fontColor: '#585757'
      },
      gridLines: {
        display: false ,
        color: "rgba(0, 0, 0, 0.08)"
      },
      }]
     }

   }
  });


});

