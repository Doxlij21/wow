<div style="background: #fff;max-width: 375px;margin: 0 auto;">
    <div class="loginCon">
        <div class="item">
            <ul class="tabs">
                <li id="login_tab" class="" style="margin-right: 2rem;display: inline-block;font-size: 1.4rem;">
                    <a style="text-decoration: none;" href="#" onclick='loginWrap()'>Login</a>
                </li>
                <li id="signup_tab" class="" style="margin-right: 2rem;display: inline-block;font-size: 1.4rem;">
                    <a style="text-decoration: none;" href="#" onclick='registerWrap()'>Register</a>
                </li>
                @if(count($errors)>0)
                    <li id="errors_tab" class="selected" style="margin-right: 2rem;display: inline-block;font-size: 1.4rem;">
                @else
                    <li id="errors_tab" class="" style="margin-right: 2rem;display: none;font-size: 1.4rem;">
                        @endif
                        <a style="text-decoration: none;" href="#" onclick='errorsWrap()'>Errors</a>
                    </li>
            </ul>
        </div>
        <div id="loginWrap">
            <form class="loginForm" role="form" action="{{ route ('login') }}" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                <div class="item">
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="username">User name:</label>
                        <input style="width: 325px;" type="text" name="username" class="text" value="">
                    </div>
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="password">Password:</label>
                        <input style="width: 325px;" type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px">Remember me:</label>
                        <input type="checkbox" class="text" name="remember">
                    </div>
                </div>

                <div class="buttons" style="padding: 20px 0;border-top: 1px solid #dad8de;width: 100%;text-align: center;">
                    <div class="form-group">
                        <button type="submit" style="width: 71px;height: 32px;" class="primary button">
                        <span class="js-login-text">
                            Enter
                        </span>
                        </button>

                        <script type="text/javascript">

                            function checkForm(form1)
                            {
                                form1.login.disabled = true;
                                form1.login.value = "Please wait...";
                                return true;
                            }

                        </script>
                    </div>
                    <input type="hidden" name="_token" value="{{Session::token()}}">
                </div>
            </form>
        </div>
        <div id="registerWrap" style="display: none;">
            <form class="form-vertical" role="form" action="{{ route ('register') }}" method="POST" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                <div class="item">
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="username">User name:</label>
                        <input style="width: 325px;" type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="password">Password:</label>
                        <input style="width: 325px;" type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="password_confirmation">Password confirmation:</label>
                        <input style="width: 325px;" type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>
                    <div class="field" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 5px;font-weight: 700;color: #575260;font-size: 14px" for="email">Email:</label>
                        <input style="width: 325px;" type="text" name="email" class="text">
                    </div>
                </div>

                <div class="buttons" style="padding: 20px 0;border-top: 1px solid #dad8de;width: 100%;text-align: center;">
                    <div class="form-group">
                        <button type="submit" name="register" style="width: 71px;height: 32px;" class="primary button">
                        <span class="login-text">
                            Register
                        </span>
                        </button>

                        <script type="text/javascript">

                            function checkForm(form23)
                            {
                                form23.register.disabled = true;
                                form23.register.value = "Please wait...";
                                return true;
                            }

                        </script>
                    </div>
                    <input type="hidden" name="_token" value="{{Session::token()}}">

                </div>
            </form>
        </div>
        @if(count($errors)>0)
            <div id="errorsWrap" style="display: block !important;">
                @else
                    <div id="errorsWrap" style="display: none;">
                        @endif
                        <div class="item">
                            <div class="field" style="margin-bottom: 10px;">
                                @if ($errors->has('username'))
                                    <span style="font-size: 14px;color: red;display: inline-block;" class="help-block">{{ $errors->first('username') }}</span>
                                @endif
                                @if ($errors->has('password'))
                                    <span style="font-size: 14px;color: red;display: inline-block;" class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                                @if ($errors->has('password_confirmation'))
                                    <span style="font-size: 14px;color: red;display: inline-block;" class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
    </div>
