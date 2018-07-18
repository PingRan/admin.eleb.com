@extends('default')
@section('content')
  @include('default._errors')
    <form class="form-horizontal" action="{{route('shops.store')}}" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">账号</label>
            <div class="col-sm-10">
                <input type="text" name="name" value="{{old('name')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">email</label>
            <div class="col-sm-10">
                <input type="text" name="email" value="{{old('email')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" name="password">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">账号状态(选中表示启用)</label>
            <div class="col-sm-10">
                <input type="checkbox" checked name="UserStatus" value="1">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">添加店铺(选中表示添加店铺)</label>
            <div class="col-sm-10">
                <input  id="add" type="checkbox" name="addshop" value="1">
            </div>
        </div>

       {{--<button id="add" type="button" class="btn btn-primary">点击添加店铺信息</button>--}}

  <div id="info" style="display: none">
        <div class="form-group">
            <label for="inputUserName3" class="col-sm-2 control-label">商家名字</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputUserName3" placeholder="商家名字" name="shop_name" value="{{old('shop_name')}}">
            </div>
        </div>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="inputPassword7" class="col-sm-2 control-label">logo</label>
            <div class="col-sm-10">
                <input type="file" name="shop_img">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword5" class="col-sm-2 control-label">商家分类</label>
            <div class="col-sm-10">

                <select class="form-control" name="shop_category_id">
                    <option value="0">请选择</option>
                    @foreach($categories as $category)
                        <option  value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>

            </div>

        </div>


        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">是否支持</label>
            <div class="col-sm-10">
                <input type="checkbox" name="brand" value="1">品牌
                <input type="checkbox" name="on_time" value="1">准时送达
                <input type="checkbox" name="fengniao" value="1">蜂鸟配送
                <input type="checkbox" name="bao" value="1">保标记
                <input type="checkbox" name="piao" value="1">票标记
                <input type="checkbox" name="zhun" value="1">准标记
            </div>
        </div>



        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">起送金额</label>
            <div class="col-sm-10">
                <input type="number" name="start_send" value="{{old('start_send')}}" >
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">配送费</label>
            <div class="col-sm-10">
                <input type="number" name="send_cost" value="{{old('send_cost')}}">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">店公告</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="notice" id="inputPassword3">{{old('notice')}}</textarea>

            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">优惠信息</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="discount" id="inputPassword3">{{old('discount')}}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <input type="radio" name="ShopStatus" checked value="1">正常
                {{--<input type="radio" checked name="ShopStatus" value="0">待审核--}}
                {{--<input type="radio" name="ShopStatus" value="-1">禁用--}}
            </div>
        </div>

        {{--<div class="form-group">--}}
            {{--<label for="inputPassword6" class="col-sm-2 control-label">请输入验证码</label>--}}
            {{--<div class="col-sm-10">--}}
                {{--<input type="text" name="captcha">--}}
                {{--<img src="{{captcha_src('falt')}}" alt="" onclick="this.src='/captcha/flat?'+Math.random()" title="点击更换">--}}
            {{--</div>--}}
        {{--</div>--}}

  </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">发布</button>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $("#add").click(function(){
            var info=$("#info").css('display');

            if(info=='none'){
                $("#info").css('display','block')
            }else{
                $("#info").css('display','none')
            }
        });
    </script>
@endsection

