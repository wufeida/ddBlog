<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>哒哒后台管理 | 登录</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">DA+</h1>

            </div>
            <h3>Welcome to DA+</h3>
            <p>哒哒个人博客</p>
            <p>Login in.</p>
            <form class="m-t" role="form" method="post" action="{{url('/dd/login')}}">
                {{csrf_field()}}
                <div class="form-group">
                    @if(session('msg'))
                        <div class="alert alert-danger">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                        @endforeach
                    @endif
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Username" >
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Password" >
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script>
        function loadTopWindow(){
            if (window.top!=window.self && window.top.document.URL!=document.URL){
                window.top.location= document.URL;
            }
        }
        loadTopWindow();
    </script>

</body>

</html>
