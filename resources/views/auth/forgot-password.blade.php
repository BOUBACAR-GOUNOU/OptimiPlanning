<!DOCTYPE html>
<html lang="en">

<head>

    @include('auth.partials.head')

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-">Mot de passe oublié</h1>
                                    <p class="mb-8">Vous avez oublié votre mot de passe ? Pas de problème.</p>
                                </div>
                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                                    <form method="POST" class="user"  action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group">
                                        <x-text-input id="email" class="block mt-1 w-full" type="email"
                                                      name="email" :value="old('email')" required autofocus
                                                      placeholder="Entrer votre email"
                                                      class="form-control form-control-user"
                                        />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Renitialiser le mot de passe</button>
                                    </div>


                                </form>
                                <hr>
                                <div class="text-center mt-4">
                                    <a class="small" href="{{ route('register') }} ">S'enregistrer !</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }} ">Vous avez deja un compte ? Se connecter !</a>
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
