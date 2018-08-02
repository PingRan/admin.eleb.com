<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">店铺管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('shops.create')}}">添加商店</a></li>

                        <li><a href="{{route('shops.index')}}">商店列表</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">商家分类<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('shopcategories.index')}}">分类列表</a></li>
                        <li><a href="{{route('shopcategories.create')}}">添加分类</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">管理员<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admins.index')}}">管理员列表</a></li>
                        <li><a href="{{route('admins.create')}}">添加管理员</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">商家账号<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('users.index')}}">账号列表</a></li>
                        <li><a href="{{route('resetpass')}}">重置商家账号</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">活动<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('activities.index')}}">活动列表</a></li>
                        @can('Add-AdminArticle')
                        <li><a href="{{route('activities.create')}}">活动添加</a></li>
                        @endcan
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">订单<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('order.index')}}">统计</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">RBAC<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('permissions.index')}}">权限列表</a></li>
                        <li><a href="{{route('permissions.create')}}">添加权限</a></li>
                        <li><a href="{{route('roles.index')}}">角色列表</a></li>
                        <li><a href="{{route('roles.create')}}">添加角色</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">会员<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('members.index')}}">会员列表</a></li>
                    </ul>
                </li>



            </ul>

            <ul class="nav navbar-nav navbar-right">

                @guest
                <li><a href="{{route('login')}}">登录</a></li>
                @endguest
                @auth
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">管理员:{{ Auth()->user()->name }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admins.edit',['admin'=>Auth()->id()])}}">修改密码</a></li>

                        <li>
                            <a href="{{route('loginout')}}">注销</a>
                        </li>
                    </ul>
                </li>
                @endauth


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>