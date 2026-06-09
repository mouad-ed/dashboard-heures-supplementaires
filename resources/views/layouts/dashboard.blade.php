@extends('layouts.master')

@section('title', 'Tableau de Bord')

@section('content')

<section class="db-page">

    <div class="db-page__head">
        <div>
            <h1 class="db-h1">Dashboard</h1>
            <p class="db-muted">Statistiques générales du système</p>
        </div>
        <div class="db-actions">
            <div class="db-pill"><i class="fas fa-bolt me-2"></i> Live demo</div>
        </div>
    </div>

    {{-- Statistics cards --}}
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-3">
            <div class="db-card db-card--neumo db-card--primary">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-clock"></i></div>
                    <div class="db-chip">This month</div>
                </div>
                <div class="db-card__title">Total Heures Supplémentaires</div>
                <div class="db-card__value">60,36 h</div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="db-card db-card--neumo db-card--success">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-coins"></i></div>
                    <div class="db-chip">Collected</div>
                </div>
                <div class="db-card__title">Total Encaissé</div>
                <div class="db-card__value">5 400 DH</div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="db-card db-card--neumo db-card--danger">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-user-times"></i></div>
                    <div class="db-chip">Attention</div>
                </div>
                <div class="db-card__title">Élèves Non Payés</div>
                <div class="db-card__value">2</div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="db-card db-card--neumo db-card--warning">
                <div class="db-card__top">
                    <div class="db-card__icon"><i class="fas fa-wallet"></i></div>
                    <div class="db-chip">Due</div>
                </div>
                <div class="db-card__title">À Payer Enseignants</div>
                <div class="db-card__value">2 979 DH</div>
            </div>
        </div>
    </div>

    {{-- Charts (CSS placeholders only) --}}
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="db-card db-card--glass db-card--big">
                <div class="db-card__header">
                    <div>
                        <div class="db-card__kicker">Performance</div>
                        <div class="db-card__header-title">Évolution des revenus & heures</div>
                    </div>
                    <div class="db-seg">
                        <button class="db-seg__btn db-seg__btn--active" type="button">6M</button>
                        <button class="db-seg__btn" type="button">1Y</button>
                        <button class="db-seg__btn" type="button">All</button>
                    </div>
                </div>

                <div class="db-chart db-chart--line" aria-label="Performance chart placeholder">
                    <div class="db-chart__grid"></div>
                    <div class="db-chart__curve"></div>
                    <div class="db-chart__points">
                        <span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>

                <div class="db-legend">
                    <div class="db-legend__item"><span class="db-dot db-dot--primary"></span> Revenus</div>
                    <div class="db-legend__item"><span class="db-dot db-dot--accent"></span> Heures</div>
                    <div class="db-legend__item db-legend__muted">Updated just now</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="db-card db-card--glass">
                <div class="db-card__header">
                    <div>
                        <div class="db-card__kicker">Répartition</div>
                        <div class="db-card__header-title">Globale</div>
                    </div>
                    <div class="db-pill"><i class="fas fa-layer-group me-2"></i> Demo</div>
                </div>

                <div class="db-donut" aria-label="Donut chart placeholder">
                    <div class="db-donut__ring"></div>
                    <div class="db-donut__center">
                        <div class="db-donut__big">78%</div>
                        <div class="db-donut__small">Payé</div>
                    </div>
                </div>

                <div class="db-legend mt-3">
                    <div class="db-legend__item"><span class="db-dot db-dot--primary"></span> Payé</div>
                    <div class="db-legend__item"><span class="db-dot db-dot--accent"></span> Impayé</div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

