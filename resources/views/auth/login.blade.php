<x-plantilla>
    @section('title', 'Inicio de Sesión')
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">

            </x-slot>

            <div class="card-body">

                <x-jet-validation-errors class="mb-3 rounded-0" />

                @if (session('status'))
                    <div class="alert alert-success mb-3 rounded-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <x-jet-label value="{{ __('Email') }}" />

                        <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                            :value="old('email')" required />
                        <x-jet-input-error class="mb-2" for="email"></x-jet-input-error>
                    </div>

                    <div class="mb-3">
                        <x-jet-label value="{{ __('Password') }}" />

                        <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-jet-input-error for="password"></x-jet-input-error>
                    </div>

                    <div class="mb-3">
                        <div class="custom-control custom-checkbox">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <label class="custom-control-label" for="remember_me">
                                {{ __('recuerdame') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-end align-items-baseline">
                            @if (Route::has('password.request'))
                                <a class="text-muted me-3" href="{{ route('password.request') }}">
                                    {{ __('Olvidaste tu contraseña?') }}
                                </a>
                            @endif

                            <x-jet-button>
                                {{ __('Iniciar Sesión') }}
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
        </x-jet-authentication-card>
    </x-guest-layout>
</x-plantilla>
