<!DOCTYPE html>
<html lang="en">

@include('auth.partials.head')

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenue!</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <x-text-input id="email" placeholder="Email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                    </div>

                                    <div class="form-group">
                                        <x-text-input id="password" placeholder="Mot de passe"
                                                      class="form-control form-control-user"
                                                      type="password"
                                                      name="password"
                                                      required autocomplete="current-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                            <label class="custom-control-label" for="remember_me">{{ __('Se rappeler') }}</label>

                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Se connecter') }}</button>
                                    <hr>

                                </form>

                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié ?') }}
                                        </a>
                                    @endif

                                </div>
                                <div class="text-center">
                                    <a class="small"  href="{{ route('register') }}">Creer un compte !</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@include('auth.partials.script_footer')

</body>

</html>
