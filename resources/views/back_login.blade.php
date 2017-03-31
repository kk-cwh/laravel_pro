<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


    <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Laravel</title>
</head>
<body>
<div class="container">
<br>
    <form class="form-horizontal" action="/home/user/login" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 col-lg-2 control-label">邮箱</label>
            <div class="col-sm-10 col-lg-4">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 col-lg-2 control-label " name="password">密码</label>
            <div class="col-sm-10 col-lg-4">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-md-2 col-lg-2 control-label">验证码</label>
            <div class="col-sm-4 col-md-4 col-lg-2">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="code">
            </div>
            <div class="col-sm-4 col-md-4 col-lg-2">
                <img style="display: inline" src="/home" name="imgc" id="imgc"  class="get-code" height="30" width="80" onclick="javascript:this.src='/home?_r'+Math.random()" alt="验证码">
            </div>

        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-lg-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> 记住密码
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">登录</button>
            </div>
        </div>
    </form>


    </div>




</body>
</html>
