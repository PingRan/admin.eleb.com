<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Title</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    @yield('css')
    <script src="/js/jquery-3.2.1.js"></script>
    <script src="/js/bootstrap.js"></script>
    @yield('web.js')
    <style>
        body{
            height: 100vh;
            margin: 0;
        }
        body{background:url("/121.jpg") no-repeat;font-size: 16px;}
    </style>
</head>
<body>
<div class="container" style="position: absolute;top:0;margin-left: 300px;">
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <tr class="success">
                    <th>活动id</th>
                    <th>活动标题</th>
                    <th>活动开始时间</th>
                    <th>活动结束时间</th>
                    <th>操作</th>
                </tr>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->title}}</td>
                        <td>{{date('Y-m-d',$activity->start_time)}}</td>
                        <td>{{date('Y-m-d',$activity->end_time)}}</td>

                        <td>

                                <a class="btn bg-info" href="{{$activity->static_url}}">查看活动详情</a>

                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

    <script type="text/javascript" src="/js/Particleground.js"></script>
    <script type="text/javascript" src="/Js/Treatment.js"></script>

    <script>
            $('body').particleground({
                dotColor: '#E8DFE8',
                lineColor: '#faebf9'
            });
    </script>
    @yield('js')
</body>
</html>
