

@extends('users.index', ['isLogin' => true])
@section('content')


<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


                    <div class="card mb-3">

                        <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Đăng nhập {{get_config()->site_name ?? 'FunHome'}}</h5>
                                <p class="text-center small">
                                    Nhập tên người dùng và mật khẩu của bạn để đăng nhập</p>
                            </div>

                            <form class="row g-3 "  method="POST" action="{{ route('post_login') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <input id="email" type="email" class="form-control " name="email"
                                        value="{{ old('email') }}"  autocomplete="email" autofocus="">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control " name="password"
                                        required="" autocomplete="current-password">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                      <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                  </div>
                               

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                                
                            </form>
                          
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </section>

</div>
 
@endsection


