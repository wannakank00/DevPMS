<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
   
<div class="container">
    <div class="row justify-content-center">
        <div class="card" style="width: 30rem;padding-left: 0px;padding-right: 0px;">
            <img src="{{ asset('img/LogoLoginPMS.png') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ __('Login To PMS') }}</h5>
                <form method="POST" action="{{ route('UserLogin') }}">
                    @csrf
                    <div class="Username">
                        <label for="esUsername" class="col-form-label text-md-end">
                            <i class="fas fa-address-book"></i>{{ __('Username') }}
                        </label>
                        <input id="esUsername" type="text" placeholder="Username (e-Service)"
                            class="form-control @error('esUsername') is-invalid @enderror" name="esUsername"
                            value="{{ old('esUsername') }}" required autocomplete="esUsername" autofocus>
                        @error('esUsername')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="Password">
                        <label for="esPassword" class="col-form-label text-md-end">
                            <i class="fas fa-lock"></i>{{ __('Password') }}
                        </label>
                        <input id="esPassword" type="password" placeholder="password (e-Service)"
                            class="form-control @error('esPassword') is-invalid @enderror" name="esPassword" required
                            autocomplete="current-password">

                        @error('esPassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                    <p class="text-center">พบปัญหาการใช้งาน หรือ บันทึกข้อมูลผิดพลาด<br>
                        แจ้งได้ที่ LINE : HR Mono Official</p>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>