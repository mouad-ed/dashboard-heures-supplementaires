@extends('layouts.master')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-0">💰 Gestion des Salaires</h2>
        <p class="text-muted mb-0">Suivi des rémunérations des enseignants</p>
    </div>

    {{-- ================= STATS ================= --}}
    <div class="row g-3 mb-4">

        @php
            $cards = [
                ['label' => 'Total Encaissé', 'value' => $totalEncaisseGlobal ?? 0, 'color' => '#6366f1'],
                ['label' => 'Total Salaires', 'value' => $totalSalaireGlobal ?? 0, 'color' => '#16a34a'],
                ['label' => 'Part Centre', 'value' => $centreGlobal ?? 0, 'color' => '#ef4444'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-4">
            <div class="db-card db-card--neumo"
                 style="border-radius:18px;
                        transition:.25s;
                        cursor:pointer;
                        box-shadow:0 10px 25px rgba(0,0,0,.05);"
                 onmouseover="this.style.transform='translateY(-4px)'"
                 onmouseout="this.style.transform='translateY(0)'">

                <div class="db-card__kicker" style="font-weight:600;">
                    {{ $card['label'] }}
                </div>

                <div class="db-card__value" style="font-size:30px; color:{{ $card['color'] }};">
                    {{ number_format($card['value'], 2) }} DH
                </div>

            </div>
        </div>
        @endforeach

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="db-card db-card--glass"
         style="border-radius:18px; overflow:hidden;">

        <div class="p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">Détail des enseignants</h5>
                    <small class="text-muted">Encaissements et répartition</small>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead style="background:#f8fafc;">
                        <tr>
                            <th>👨‍🏫 Enseignant</th>
                            <th class="text-end">Encaissé</th>
                            <th class="text-end">Salaire</th>
                            <th class="text-end">Centre</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($enseignants as $e)

                        @php
                            $percentColor = $e->pourcentage >= 70
                                ? '#16a34a'
                                : ($e->pourcentage >= 40 ? '#f59e0b' : '#ef4444');
                        @endphp

                        <tr style="transition:.2s;"
                            onmouseover="this.style.background='#f8fafc'"
                            onmouseout="this.style.background='transparent'">

                            <td class="fw-semibold">
                                {{ $e->nom }}
                            </td>

                            <td class="text-end">
                                <span style="color:#6366f1;font-weight:600;">
                                    {{ number_format($e->total_encaisse ?? 0, 2) }} DH
                                </span>
                            </td>

                            <td class="text-end fw-bold text-success">
                                {{ number_format($e->salaire ?? 0, 2) }} DH
                            </td>

                            <td class="text-end fw-bold text-danger">
                                {{ number_format($e->centre ?? 0, 2) }} DH
                            </td>

                            <td class="text-center">
                                <span class="badge px-3 py-2"
                                      style="background:{{ $percentColor }}15;
                                             color:{{ $percentColor }};
                                             border-radius:999px;
                                             font-weight:600;">
                                    {{ $e->pourcentage }}%
                                </span>
                            </td>

                            <td class="text-center">

                                <form action="{{ route('enseignants.destroy', $e->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer cet enseignant ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm"
                                            style="border-radius:12px;
                                                   border:1px solid #ef4444;
                                                   color:#ef4444;
                                                   background:rgba(239,68,68,.08);
                                                   padding:6px 14px;
                                                   transition:.2s;"
                                            onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                            onmouseout="this.style.background='rgba(239,68,68,.08)';this.style.color='#ef4444'">
                                        🗑
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun enseignant trouvé
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection