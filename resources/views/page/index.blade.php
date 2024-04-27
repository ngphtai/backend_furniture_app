@extends('common.page.Master')
@section('noi_dung')
{{-- dash boarh --}}
<div class="wrapper">

    <!--start page wrapper -->
        {{-- get data to chart --}}

        <input type="hidden" id="count_user" value="{{ $count_user }}">
        <input type="hidden" id="count_sold" value="{{ $count_sold }}">

        <div class="page-content">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card radius-10">
                            <div class="card-body">
                               <div class="d-flex align-items-center">
                                   <div>
                                       <h6 class="mb-0">Tổng quan</h6>
                                   </div>
                               </div>
                             <div class="chart-container-0">
                               <canvas id="chart7"></canvas>
                            </div>
                            </div>
                         </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0">Số đơn order theo tháng</h6>
                                    </div>
                                </div>
                                <div class="chart-container-0">
                                    <canvas id="chart-order-status"></canvas>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            <div class="row ">
                <div class="col">
                    <div class="card radius-10 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary font-14">Tổng order</p>
                                    <h5 class="my-0">{{$count_order}}</h5>
                                </div>
                                <div class="text-primary ms-auto font-30"><i class='bx bx-cart-alt'></i>
                                </div>
                            </div>
                         </div>
                        <div class="mt-1" id="chart1"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary font-14">Tổng lợi nhuận</p>
                                    <h5 class="my-0">{{$revenue}} vnd</h5>
                                </div>
                                <div class="text-danger ms-auto font-30"><i class='bx bx-dollar' ></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1" id="chart2"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary font-14">Số Người Dùng</p>
                                    <h5 class="my-0">{{ $count_user }}</h5>
                                </div>
                                <div class="text-success ms-auto font-30"><i class='bx bx-group'></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1" id="chart3"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary font-14">Số sản phẩm đã bán</p>
                                    <h5 class="my-0">{{ $count_sold }}</h5>
                                </div>
                                <div class="text-warning ms-auto font-30"><i class='bx bx-beer'></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1" id="chart4"></div>
                    </div>
                </div>

              </div><!--end row-->

             <div class="card radius-10">
                <div class="card-body">
                   <div class="d-flex align-items-center">
                       <div>
                           <h6 class="mb-0">Top Sản Phẩm Bán Chạy</h6>
                       </div>
                   </div>
                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                   <thead class="table-light">
                    <tr>
                      <th>Sản phẩm</th>
                      <th>Ảnh</th>
                      <th>Product ID</th>
                      <th class ="text-center">Đã Bán</th>
                      <th class ="text-center">Giá sản phẩm</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            @php
                                $images = json_decode($product->product_image);
                            @endphp
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td><img src="{{ asset('/storage//'. $images[0]) }}"  class="product-img-2" alt="product img"></td>
                                <td>{{ $product->id }}</td>
                                <td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">{{ $product->sold }}</span></td>
                                <td class ="text-center">{{ $product->price }}</td>
                            </tr>
                        @endforeach
                   </tbody>
                 </table>
                 </div>
                </div>
           </div>
        <div class="row ">
            <div class="col-12 col-lg-6">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Tỉ lệ của các phương thức thanh toán</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart11" style="margin:70px 0 75px 0"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Tổng quan trạng thái đặt hàng</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container-1">
                            <canvas id="chart14" ></canvas>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Chưa xác nhận <span class="badge rounded-pill" style="background:#EE0909">{{$chuaxacnhan}}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Đã xác nhận <span class="badge rounded-pill" style="background:#a4a21d">{{$daxacnhan}}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Đang giao <span class="badge rounded-pill" style="background:#518bcc" >{{$danggiao}}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Hoàn thành <span class="badge rounded-pill" style="background: #51b142">{{$hoanthanh}}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Hoàn tiền <span class="badge rounded-pill" style="background:#9e89ab">{{$hoantien}}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Từ chối <span class="badge rounded-pill" style="background :#322A37">{{$tuchoi}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>

    <!--end page wrapper -->

</div>

<script>
    $(document).ready(function(){
        $(function() {
    "use strict";
     //lấy dữ liệu từ biến $analysis
     var dataOrder =  @json($analysis);
     var month = @json($month);
    console.log(dataOrder);
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



    var date1 = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date2 = new Date(new Date().setDate(new Date().getDate() - 1)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date3 = new Date(new Date().setDate(new Date().getDate() - 2)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date4 = new Date(new Date().setDate(new Date().getDate() - 3)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date5 = new Date(new Date().setDate(new Date().getDate() - 4)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date6 = new Date(new Date().setDate(new Date().getDate() - 5)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
    var date7 = new Date(new Date().setDate(new Date().getDate() - 6)).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [date7, date6, date5, date4, date3 , date2, date1],
      datasets: [ {
        label: 'Sales',
        data: [dataOrder[6],dataOrder[5],dataOrder[4], dataOrder[3], dataOrder[2], dataOrder[1], dataOrder[0]],
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
        data: [month[0], month[1], month[2] , month[3], month[4], month[5],month[6],month[7],month[8],month[9],month[10],month[11]],
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
    // chart 11
    var direct = @json($direct);
    var vnpay = @json($vnpay);
    var stripe = @json($stripe);
    Morris.Donut({
            element: 'chart11',
            data: [{
                label: "Direct",
                value: direct,

            }, {
                label: "VnPay",
                value: vnpay
            }, {
                label: "Stripe",
                value: stripe
            }],
            resize: true,
            colors:['#C5DF1F', '#15ca20', '#3599FD']
        });

        // chart 4

var ctx = document.getElementById("chart14").getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#EE0909');
    gradientStroke1.addColorStop(1, '#ff6a00');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, '#FFFC4F');
    gradientStroke2.addColorStop(1, '#D9D025');

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke3.addColorStop(0, '#80FFFD');
    gradientStroke3.addColorStop(1, '#006AFF');

var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke4.addColorStop(0, '#22FF00');
    gradientStroke4.addColorStop(1, '#29C34D');

var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke5.addColorStop(0, '#DDCDEE');
    gradientStroke5.addColorStop(1, '#290A2D');

var gradientStroke6 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke6.addColorStop(0, '#322A37');
    gradientStroke6.addColorStop(1, '#000000');

    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["Chưa xác nhận", "Đã xác nhận", "Đang giao","Hoàn thành","Hoàn tiền","Đã hủy"],
        datasets: [{
          backgroundColor: [
            gradientStroke1,
            gradientStroke2,
            gradientStroke3,
            gradientStroke4,
            gradientStroke5,
            gradientStroke6,
          ],

           hoverBackgroundColor: [
            gradientStroke1,
            gradientStroke2,
            gradientStroke3,
            gradientStroke4,
            gradientStroke5,
            gradientStroke6,
          ],

          data: [@json($chuaxacnhan), @json($daxacnhan), @json($danggiao),@json($hoanthanh), @json($hoantien), @json($tuchoi)],
    borderWidth: [1, 1, 1]
        }]
      },
      options: {
       maintainAspectRatio: false,
        cutoutPercentage: 0,
          legend: {
            position: 'bottom',
            display: false,
          labels: {
              boxWidth:8
            }
          },
          tooltips: {
            displayColors:false,
          },
      }
    });



});


    })
</script>
@endsection
