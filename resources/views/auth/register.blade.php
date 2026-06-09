@extends('layouts.master')

@section('title', 'Créer utilisateur')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-primary text-white text-center p-4">

                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-primary"
                             style="width:70px;height:70px;">
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                    </div>

                    <h3 class="fw-bold mb-1">
                        Créer un utilisateur
                    </h3>

                    <p class="mb-0 opacity-75">
                        Admin Panel • Gestion des comptes
                    </p>

                </div>

                {{-- BODY --}}
                <div class="card-body p-4 p-lg-5">

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3">
                            <i class="fas fa-circle-check me-2"></i>
                            {{ session('success') }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        {{-- NAME --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Nom complet
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control border-0 bg-light py-3"
                                    placeholder="Ex: Ahmed Ali"
                                    required
                                >

                            </div>

                            @error('name')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Adresse Email
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control border-0 bg-light py-3"
                                    placeholder="email@example.com"
                                    required
                                >

                            </div>

                            @error('email')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- ROLE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Rôle utilisateur
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-shield-halved text-primary"></i>
                                </span>

                                <select
                                    name="role"
                                    class="form-select border-0 bg-light py-3"
                                    required
                                >
                                    <option value="">
                                        -- Choisir un rôle --
                                    </option>

                                    <option value="admin">
                                        🛡️ Admin
                                    </option>

                                    <option value="user">
                                        👤 User
                                    </option>

                                </select>

                            </div>

                            @error('role')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Mot de passe
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control border-0 bg-light py-3"
                                    placeholder="••••••••"
                                    required
                                >

                            </div>

                            @error('password')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Confirmation mot de passe
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control border-0 bg-light py-3"
                                    placeholder="••••••••"
                                    required
                                >

                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-3 fw-semibold rounded-3 shadow-sm"
                        >
                            <i class="fas fa-user-plus me-2"></i>
                            Créer utilisateur
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection