@extends('default')

@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('navs.update',['nav'=>$nav])}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">菜单名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{$nav->name}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">url地址</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="url" value="{{$nav->url}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">上级菜单</label>
            <div class="col-sm-10">
                <select name="pid" id="">
                    <option {{$nav->pid==0?'selected':''}} value="0">顶级菜单</option>
                    @foreach($allNav as $oneNav)
                        <option {{$oneNav->id==$nav->pid?'selected':''}} value="{{$oneNav->id}}">{{$oneNav->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{method_field('patch')}}
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">请选择权限</label>
            <div class="col-sm-10">
                @foreach($permissions as $permission)
                    <label><input type="radio"  {{$nav->permission_id==$permission->id?'checked':''}} name="permission_id" value="{{$permission->id}}">{{$permission->name}}</label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-block">修改</button>
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
