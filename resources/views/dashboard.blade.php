@extends('layouts.master')

@section('title', 'Tableau de Bord')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="db-page">

    {{-- HEADER --}}
    <div class="db-page__head">

        <div>
            <h1 class="db-h1">Education Management</h1>
            <p class="db-muted">Statistiques générales du système</p>
        </div>

        <div class="db-actions">
            <a href="{{ route('dashboard') }}" class="db-ghost-btn">
                <i class="fas fa-arrows-rotate me-2"></i> Refresh
            </a>
        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-12 col-md-6 col-xl-3">
            <div class="db-card db-card--neumo db-card--primary">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-clock"></i></div>
                    <div class="db-card__chip db-chip">Total</div>
                </div>

                <div class="db-card__title">Total Heures</div>
                <div class="db-card__value">
                    {{ number_format($totalHours ?? 0, 2, ',', ' ') }} h
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="db-card db-card--neumo db-card--success">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-coins"></i></div>
                    <div class="db-card__chip db-chip">Payé</div>
                </div>

                <div class="db-card__title">Total Encaisse</div>
                <div class="db-card__value">
                    {{ number_format($totalIncome ?? 0, 0, ',', ' ') }} DH
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="db-card db-card--neumo db-card--danger">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-user-times"></i></div>
                    <div class="db-card__chip db-chip">Attention</div>
                </div>

                <div class="db-card__title">Élèves Non Payés</div>
                <div class="db-card__value">
                    {{ $unpaidStudents ?? 0 }}
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="db-card db-card--neumo db-card--warning">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-wallet"></i></div>
                    <div class="db-card__chip db-chip">Due</div>
                </div>

                <div class="db-card__title">À Payer Enseignants</div>
                <div class="db-card__value">
                    {{ number_format($teachersDue ?? 0, 0, ',', ' ') }} DH
                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="row g-4">

        <div class="col-12 col-lg-8">

            <div class="db-card db-card--glass db-card--big">

                <div class="db-card__header">
                    <div>
                        <div class="db-card__kicker">Performance</div>
                        <div class="db-card__header-title">Revenus & Heures</div>
                    </div>
                </div>

                <div style="height:380px;">
                    <canvas id="performanceChart"></canvas>
                </div>

            </div>

        </div>

    </div>

</section>

{{-- SAFE DATA --}}
@php
    $revenuesArray = array_fill(1, 12, 0);
    $hoursArray = array_fill(1, 12, 0);

    if (!empty($revenues)) {
        foreach ($revenues as $month => $value) {
            $revenuesArray[$month] = $value;
        }
    }

    if (!empty($hours)) {
        foreach ($hours as $month => $value) {
            $hoursArray[$month] = $value;
        }
    }
@endphp

<script>

    const revenuesData = @json(array_values($revenuesArray));
    const hoursData = @json(array_values($hoursArray));

    const canvas = document.getElementById('performanceChart');

    if (canvas) {

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],

                datasets: [
                    {
                        label: 'Revenus (€)',
                        data: revenuesData,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79,70,229,0.10)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Heures',
                        data: hoursData,
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6,182,212,0.10)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    }

</script>

@endsection