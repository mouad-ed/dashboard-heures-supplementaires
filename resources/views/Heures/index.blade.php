@extends('layouts.master')

@section('content')

<section class="db-page">

    {{-- HEADER --}}
    <div class="db-page__head">

        <div>
            <h1 class="db-h1">Heures Supplémentaires</h1>
            <p class="db-muted">
                Gestion des paiements enseignants
            </p>
        </div>

        <button
            class="db-primary-btn"
            type="button"
            onclick="openAddModal()">

            + Nouveau

        </button>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-12 col-lg-4">
            <div class="db-card db-card--neumo">
                <div class="db-card__kicker">
                    TOTAL HEURES
                </div>

                <div class="db-card__value">
                    {{ $total_heures }} h
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="db-card db-card--neumo db-card--success">

                <div class="db-card__kicker">
                    PAYÉ
                </div>

                <div class="db-card__value">
                    {{ $total_paye }} DH
                </div>

            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="db-card db-card--neumo db-card--warning">

                <div class="db-card__kicker">
                    ATTENTE
                </div>

                <div class="db-card__value">
                    {{ $total_attente }} DH
                </div>

            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="db-card db-card--glass">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Enseignant</th>
                        <th>Élève</th>
                        <th>Heures</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($heures as $h)

                    <tr>

                        <td class="fw-semibold">
                            {{ $h->seance->enseignant->nom ?? '-' }}
                        </td>

                        <td>
                            {{ $h->eleve->name ?? '-' }}
                        </td>

                        <td>
                            <span class="db-pill">
                                ⏱ {{ $h->heures }} h
                            </span>
                        </td>

                        <td class="fw-semibold">
                            {{ $h->montant }} DH
                        </td>

                        <td>

                            @if($h->statut_paiement == 'paye')

                                <span
                                    class="db-pill"
                                    style="background:#dcfce7;color:#16a34a;">

                                    Payé

                                </span>

                            @elseif($h->statut_paiement == 'en_retard')

                                <span
                                    class="db-pill"
                                    style="background:#fee2e2;color:#dc2626;">

                                    En retard

                                </span>

                            @else

                                <span
                                    class="db-pill"
                                    style="background:#fef3c7;color:#f59e0b;">

                                    En attente

                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $h->date_paiement ?? '-' }}
                        </td>

                        <td class="text-end">

                            {{-- EDIT --}}
                            <button
                                type="button"
                                class="btn btn-sm"
                                style="
                                    border:1px solid #6c4cf1;
                                    background:rgba(108,76,241,.07);
                                    color:#6c4cf1;
                                    border-radius:12px;
                                "
                                onclick="openEditModal(
                                    {{ $h->id }},
                                    {{ $h->seance_id }},
                                    {{ $h->eleve_id }},
                                    {{ $h->heures }},
                                    '{{ $h->statut_paiement }}',
                                    '{{ $h->date_paiement }}'
                                )">

                                ✏️

                            </button>

                            {{-- DELETE --}}
                            <form
                                action="{{ route('heures.destroy',$h->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-sm"
                                    style="
                                        margin-left:5px;
                                        border:1px solid #ef4444;
                                        background:rgba(239,68,68,.07);
                                        color:#ef4444;
                                        border-radius:12px;
                                    "
                                    onclick="return confirm('Supprimer ?')">

                                    🗑

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Aucun enregistrement
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>

{{-- MODAL --}}
<div class="modal fade" id="heureModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content db-card db-card--glass p-4">

            <h5 id="modalTitle">
                Nouvel enregistrement
            </h5>

            <form
                id="heureForm"
                method="POST"
                action="{{ route('heures.store') }}">

                @csrf

                <input
                    type="hidden"
                    name="_method"
                    id="heure_method">

                <div class="row g-3 mt-2">

                    {{-- SEANCE --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Séance
                        </label>

                        <select
                            name="seance_id"
                            id="seance_id"
                            class="form-select">

                            @foreach($seances as $s)

                                <option value="{{ $s->id }}">
                                    {{ $s->groupe }} -
                                    {{ $s->enseignant->nom }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- ELEVE --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Élève
                        </label>

                        <select
                            name="eleve_id"
                            id="eleve_id"
                            class="form-select">

                            @foreach($eleves as $e)

                                <option value="{{ $e->id }}">
                                    {{ $e->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- HEURES --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Heures
                        </label>

                        <input
                            type="number"
                            name="heures"
                            id="heures"
                            class="form-control">

                    </div>

                    {{-- MONTANT --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Montant
                        </label>

                        <input
                            type="text"
                            id="montant"
                            class="form-control"
                            readonly>

                    </div>

                    {{-- STATUT --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Statut
                        </label>

                        <select
                            name="statut_paiement"
                            id="statut_paiement"
                            class="form-select">

                            <option value="en_attente">
                                En attente
                            </option>

                            <option value="paye">
                                Payé
                            </option>

                            <option value="en_retard">
                                En retard
                            </option>

                        </select>

                    </div>

                    {{-- DATE --}}
                    <div class="col-md-6">

                        <label class="mb-1">
                            Date paiement
                        </label>

                        <input
                            type="date"
                            name="date_paiement"
                            id="date_paiement"
                            class="form-control">

                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <button
                        type="button"
                        class="db-ghost-btn"
                        data-bs-dismiss="modal">

                        Annuler

                    </button>

                    <button
                        type="submit"
                        class="db-primary-btn">

                        Enregistrer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

    const modalEl =
        document.getElementById('heureModal');

    const modal =
        new bootstrap.Modal(modalEl);

    const form =
        document.getElementById('heureForm');

    const prix = 10;

    // RESET
    function resetForm() {

        form.reset();

        document.getElementById('montant').value = '';

        document.getElementById('heure_method').value = '';
    }

    // CALCUL
    function calculMontant() {

        let heures =
            document.getElementById('heures').value || 0;

        document.getElementById('montant').value =
            (heures * prix) + ' DH';
    }

    // INPUT EVENT
    document.getElementById('heures')
        .addEventListener('input', calculMontant);

    // ADD
    window.openAddModal = function () {

        resetForm();

        form.action =
            "{{ route('heures.store') }}";

        document.getElementById('modalTitle').innerText =
            'Nouvel enregistrement';

        modal.show();
    };

    // EDIT
    window.openEditModal = function (
        id,
        seanceId,
        eleveId,
        heures,
        statut,
        datePaiement
    ) {

        resetForm();

        document.getElementById('seance_id').value =
            seanceId;

        document.getElementById('eleve_id').value =
            eleveId;

        document.getElementById('heures').value =
            heures;

        document.getElementById('statut_paiement').value =
            statut;

        document.getElementById('date_paiement').value =
            datePaiement ?? '';

        document.getElementById('montant').value =
            (heures * prix) + ' DH';

        document.getElementById('heure_method').value =
            'PUT';

        form.action =
            `/heures/${id}`;

        document.getElementById('modalTitle').innerText =
            'Modifier enregistrement';

        modal.show();
    };

});

</script>

@endpush