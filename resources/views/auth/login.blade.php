<x-guest-layout>

    <div class="db-login">

        {{-- PARTIE GAUCHE --}}
        <div class="db-login__left">

            <div class="db-login__overlay"></div>

            <div class="db-login__content">

                <div class="db-login__brand">
                    <div class="db-login__logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h1>Tableau de Bord Scolaire</h1>
                        <p>Plateforme de gestion intelligente</p>
                    </div>
                </div>

                <div class="db-login__hero">
                    <h2>
                        Simplifiez la gestion de votre établissement
                    </h2>

                    <p>
                        Gérez les élèves, les enseignants,
                        les paiements, les emplois du temps
                        et les statistiques depuis une seule
                        plateforme moderne et sécurisée.
                    </p>
                </div>

            </div>

        </div>

        {{-- PARTIE DROITE --}}
        <div class="db-login__right">

            <div class="db-login__card">

                <div class="text-center mb-4">
                    <h2 class="db-login__title">
                        Connexion
                    </h2>

                    <p class="db-login__subtitle">
                        Connectez-vous pour accéder à votre espace d'administration
                    </p>
                </div>

                <x-auth-session-status
                    class="mb-3"
                    :status="session('status')"
                />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-4">

                        <label class="db-label">
                            Adresse e-mail
                        </label>

                        <div class="db-input-group">
                            <i class="fas fa-envelope"></i>

                            <x-text-input
                                id="email"
                                class="db-input"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                placeholder="nom@exemple.com"
                            />
                        </div>

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2 text-danger"
                        />
                    </div>

                    {{-- MOT DE PASSE --}}
                    <div class="mb-4">

                        <label class="db-label">
                            Mot de passe
                        </label>

                        <div class="db-input-group">
                            <i class="fas fa-lock"></i>

                            <x-text-input
                                id="password"
                                class="db-input"
                                type="password"
                                name="password"
                                required
                                placeholder="••••••••"
                            />
                        </div>

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2 text-danger"
                        />
                    </div>

                    {{-- OPTIONS --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-check">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                            >

                            <label class="form-check-label" for="remember_me">
                                Se souvenir de moi
                            </label>
                        </div>


                    </div>

                    {{-- BOUTON --}}
                    <button type="submit" class="db-login__btn w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Se connecter
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>