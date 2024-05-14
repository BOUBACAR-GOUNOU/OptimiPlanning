<!DOCTYPE html>
<html lang="en">

<head>

    @include('auth.partials.head')

</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Créer votre compte !</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <x-text-input id="name" placeholder="Nom et Prénom " class="form-control form-control-user" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                                </div>

                            </div>
                            <div class="form-group">
                                <x-text-input id="email" class="form-control form-control-user" placeholder=" Email " name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <x-text-input id="password" class="block mt-1 w-full "
                                                  type="password"
                                                  name="password"
                                                  class="form-control form-control-user" placeholder=" Mot de passe "
                                                  required autocomplete="new-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                </div>
                                <div class="col-sm-6">
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                  type="password"
                                                  class="form-control form-control-user" placeholder="Répété mot de passe"
                                                  name="password_confirmation" required autocomplete="new-password" />

                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-user btn-block"> S'enregistrer</button>
                            </div>

                        </form>
                        <div class="text-center mt-4">
                            <a class="small" href="{{ route('login') }} ">Vous avez deja un compte ? Se connecter !</a>
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
