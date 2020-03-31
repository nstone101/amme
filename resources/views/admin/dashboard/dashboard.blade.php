@extends('layout.master')
@section('title','Admin | Dashboard')

@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{__('Dashboard')}}</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/total_user.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($totalUser) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Total User')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/portfolio.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($totalProject) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Total Portfolio')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/team.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($teams) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Team Members')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/blog.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($posts) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Blog Posts')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/services.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($services) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Services')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 text-center">
                            <div class="qz-status-bar qz-status-bar-b">
                                <div class="das-img">
                                    <img src="{{asset('assets/images/icon/pricing.svg')}}" alt="">
                                </div>
                                <div class="dash-text">
                                    <h4 class="qz-blance">{!! clean($plans) !!}</h4>
                                    <h5 class="qz-total-qustions">{{__('Pricing Plans')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="qz-sec-title">
                                        <h5>{{__('Monthly Blog Post Report')}}</h5>
                                    </div>
                                    <p class="subtitle">{{__('Current Year')}}</p>
                                    <canvas id="mySalesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="qz-sec-title">
                                <h5>{{__('Most Recent Blog Posts')}}</h5>
                                <div class="table-responsive category-table">
                                    <table class="table category-table text-center rounded">
                                        <thead>
                                        <tr>
                                            <th>{{__('SL.')}}</th>
                                            <th>{{__('Image')}}</th>
                                            <th>{{__('Post Title')}}</th>
                                            <th>{{__('Comments')}}</th>
                                            <th>{{__('Added On')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($blogs[0]))
                                            @php ($sl = 1)
                                            @foreach($blogs as $item)
                                                <tr>
                                                    <td>{{$sl++}}</td>
                                                    <td class="table-image"><img src="{{$item->image}}" alt=""></td>
                                                    <td>{!! clean(str_limit($item->title,80)) !!}</td>
                                                    <td>{!! clean(get_comments_count($item->id)) !!}</td>
                                                    <td>{!! clean(date('d M y', strtotime($item->created_at))) !!}</td>
                                                </tr>
                                            @endforeach
                                        <tr class="qz-table-footer">
                                            <td colspan=""></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan=""><h5><a href="{{ route('blogList') }}">{{__('View All')}}</a></h5></td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-danger">{{__('No data found')}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="qz-sec-title">
                                <h5>{{__('Recent Portfolios')}}</h5>
                                <div class="table-responsive category-table">
                                    <table class="table category-table text-center rounded">
                                        <thead>
                                        <tr>
                                            <th>{{__('SL.')}}</th>
                                            <th>{{__('Image')}}</th>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Category')}}</th>
                                            <th>{{__('Added On')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($portfolios[0]))
                                            @php ($sl = 1)
                                            @foreach($portfolios as $item)
                                                <tr>
                                                    <td>{{$sl++}}</td>
                                                    <td class="table-image"><img src="{{$item->image[0]}}" alt=""></td>
                                                    <td>{!! clean(str_limit($item->title,80)) !!}</td>
                                                    <td>{!! clean($item->category->name) !!}</td>
                                                    <td>{!! clean(date('d M y', strtotime($item->created_at))) !!}</td>
                                                </tr>
                                            @endforeach
                                        <tr class="qz-table-footer">
                                            <td colspan=""></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan=""><h5><a href="{{ route('portfolioList') }}">{{__('View All')}}</a></h5></td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-danger">{{__('No data found')}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
    <script src="{{asset('assets/js/revenue-chart.js')}}"></script>
    <script>
        var ctx = document.getElementById('mySalesChart').getContext("2d")
        var mySalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Post",
                    backgroundColor: "#0EC64E",
                    borderColor: "#0EC64E",
                    pointBorderColor: "#0EC64E",
                    pointBackgroundColor: "#0EC64E",
                    pointHoverBackgroundColor: "#0EC64E",
                    pointHoverBorderColor: "#D1D1D1",
                    pointBorderWidth: 10,
                    pointHoverRadius: 10,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    fill: true,
                    borderWidth: 1,
                    data: {!! json_encode($all_posts) !!}
                }]
            },
            options: {
                legend: {
                    position: "bottom",
                    display: true,
                    labels: {
                        fontColor: '#928F8F'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#928F8F",
                            fontStyle: "bold",
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "#f7788e"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#928F8F",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });
    </script>
@endsection