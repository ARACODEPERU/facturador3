@extends('tenant.layouts.auth')
@section('mystyle')
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #f8fafb;
        }

        p {
            color: #b3b3b3;
            font-weight: 300;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: "Roboto", sans-serif;
        }

        a {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        a:hover {
            text-decoration: none !important;
        }

        .content {
            padding: 7rem 0;
        }

        h2 {
            font-size: 20px;
        }

        @media (max-width: 991.98px) {
            .content .bg {
                height: 500px;
            }
        }

        .content .contents,
        .content .bg {
            width: 50%;
        }

        @media (max-width: 1199.98px) {

            .content .contents,
            .content .bg {
                width: 100%;
            }
        }

        .content .contents,
        .content .bg {
            overflow: hidden;
            margin-bottom: 0;
            padding: 15px 15px;
            border-bottom: none;
            position: relative;
            background: #edf2f5;
            border-bottom: 1px solid #e6edf1;
        }



        .content .bg {
            background-size: cover;
            background-position: center;
        }

        .content a {
            color: #888;
            text-decoration: underline;
        }

        .content .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .content .forgot-pass {
            position: relative;
            top: 2px;
            font-size: 14px;
        }

        .social-login a {
            text-decoration: none;
            position: relative;
            text-align: center;
            color: #fff;
            margin-bottom: 10px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-block;
        }

        .social-login a span {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .social-login a:hover {
            color: #fff;
        }

        .social-login a.facebook {
            background: #3b5998;
        }

        .social-login a.facebook:hover {
            background: #344e86;
        }

        .social-login a.twitter {
            background: #1da1f2;
        }

        .social-login a.twitter:hover {
            background: #0d95e8;
        }

        .social-login a.google {
            background: #ea4335;
        }

        .social-login a.google:hover {
            background: #e82e1e;
        }
    </style>
@stop
@section('content')
    {{-- <div class="container-fluid p-0">
        <!-- login page with video background start-->
        <div class="auth-bg-video">
            <video id="bgvid" poster="{{ asset('cuba/assets/images/other-images/529316.jpg') }}" playsinline=""
                autoplay="" muted="" loop="">
                <source src="{{ asset('cuba/assets/video/auth-bg.mp4') }}" type="video/mp4">
            </video>
            <div class="authentication-box">
                <div class="mt-4">
                    <div class="card-body">
                        <div class="cont text-center">
                            <div>
                                <form class="theme-form needs-validation was-validated" method="POST"
                                    action="{{ route('login') }}">
                                    @csrf
                                    <h4>INICIAR SESIÓN</h4>
                                    <h6>Ingrese su nombre de usuario y contraseña</h6>
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Email</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <label class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </label>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? ' error' : '' }}">
                                        <label class="col-form-label">Contraseña</label>
                                        <input class="form-control" name="password" id="password" type="password"
                                            required="">
                                        @if ($errors->has('password'))
                                            <label class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </label>
                                        @endif
                                    </div>
                                    <div class="checkbox p-0">
                                        <input name="remember" id="checkbox1" type="checkbox"
                                            {{ old('remember') ? 'checked' : '' }} />
                                        <label for="checkbox1">Recuérdame</label>
                                    </div>
                                    <div class="form-group row mt-3 mb-0">
                                        <button class="btn btn-primary btn-block" type="submit">INGRESAR</button>
                                    </div>
                                    <div class="login-divider"></div>
                                    <div class="social mt-3">
                                        <div class="row btn-showcase">
                                            <div class="col-md-4 col-sm-6">
                                                <button class="btn social-btn btn-fb" disabled="">Facebook</button>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <button class="btn social-btn btn-twitter" disabled>Twitter</button>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <button class="btn social-btn btn-google" disabled>Google + </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login page with video background end-->
    </div> --}}

    <section class="content">
        <div class="container ">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ url('images/Invoice-amico.svg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <img src="{{ URL('logo/logo176x32.png') }}"
                                style="width: 280px;margin-top: 20px;margin-bottom: 20px" />
                        </div>
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Iniciar sesión</h3>
                                <p class="mb-4">
                                    "¡Bienvenido de nuevo! Por favor, ingresa tus credenciales para continuar."
                                </p>
                            </div>
                            <form action="{{ route('login') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-group {{ $errors->has('email') ? ' error' : '' }}"
                                    style="margin-bottom: 20px">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input id="email" name="email" type="text" class="form-control"
                                        value="{{ old('email') }}" autocomplete="off">
                                    @if ($errors->has('email'))
                                        <small class="text-danger">
                                            {{ $errors->first('email') }}
                                        </small>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' error' : '' }} mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        autocomplete="off">
                                    @if ($errors->has('password'))
                                        <small class="text-danger">
                                            {{ $errors->first('password') }}
                                        </small>
                                    @endif
                                </div>
                                <div class="form-check" style="margin-bottom: 20px">
                                    <input class="form-check-input" name="remember" id="checkbox1" type="checkbox"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexChecheckbox1ckDefault">
                                        Acuérdate de mí
                                    </label>
                                </div>
                                <input type="submit" value="INGRESAR" class="btn btn-block btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
