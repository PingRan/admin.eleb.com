@extends('default')

@section('css')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@endsection

@section('web.js')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
@endsection

@section('content')
    @include('default._errors')
    <form class="form-horizontal" action="{{route('shopcategories.store')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">商品分类名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUserName3" placeholder="分类名字" name="name" value="{{old('name')}}">
            </div>
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">分类图片</label>
            <div class="col-sm-10">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                    <img id="img" src="" alt="">
                </div>
                <input id="img_url" type="hidden" name="img">
            </div>
        </div>



        <div class="form-group">
            <label for="inputPassword8" class="col-sm-2 control-label">分类状态(选中表示显示)</label>
            <div class="col-sm-10">
                <input type="checkbox" name="status" value="1">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">添加</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
//            swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: '{{route('uploader')}}',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData:{
                _token:'{{csrf_token()}}',
            }

        });

        uploader.on( 'uploadSuccess', function(file,responese) {

            var url=responese.fileurl;
            $("#img").attr('src',url);
            $("#img_url").val(url);
        });

    </script>

@endsection