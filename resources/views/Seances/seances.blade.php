@extends('layouts.master')

@section('content')

<section class="db-page">

    {{-- HEADER --}}
    <div class="db-page__head">
        <div>
            <h1 class="db-h1">Planning des Séances</h1>
            <p class="db-muted">Gérez les cours et enseignants</p>
        </div>

        <button class="db-primary-btn" onclick="openAddModal()">
            + Nouvelle Séance
        </button>
    </div>

    {{-- SEARCH --}}
    <div class="db-card db-card--glass mb-3">
        <div class="d-flex justify-content-between align-items-center">

            <div class="db-pill">
                {{ $seances->count() }} Séances
            </div>

            <div class="db-search" style="max-width:420px;">
                <i class="fas fa-search"></i>
                <input type="text" id="search" class="db-search__input" placeholder="Rechercher groupe...">
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="db-card db-card--glass">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                <tr>
                    <th>Date</th>
                    <th>Groupe</th>
                    <th>Enseignant</th>
                    <th>Prix</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($seances as $s)

                    @php
                        // 🎨 Color logic for price
                        $priceColor = $s->prix_heure < 50
                            ? '#2e7d32'
                            : ($s->prix_heure < 100 ? '#f9a825' : '#c62828');
                    @endphp

                    <tr class="seance-row">

                        <td>
                            <div class="fw-semibold">{{ $s->date }}</div>
                            <small class="text-muted">{{ $s->start_time }} → {{ $s->end_time }}</small>
                        </td>

                        <td class="fw-semibold">{{ $s->groupe }}</td>

                        <td>{{ $s->enseignant->nom ?? '-' }}</td>

                        {{-- 💰 PRICE WITH COLOR --}}
                        <td>
                            <span class="db-pill"
                                  style="background: {{ $priceColor }}20; color: {{ $priceColor }};">
                                💰 {{ $s->prix_heure }} DH
                            </span>
                        </td>

                        <td class="text-end">

                            <button class="db-ghost-btn editBtn"
                                onclick="openEditModal(
                                    {{ $s->id }},
                                    '{{ $s->date }}',
                                    '{{ $s->start_time }}',
                                    '{{ $s->end_time }}',
                                    '{{ $s->groupe }}',
                                    {{ $s->enseignant_id }},
                                    {{ $s->prix_heure }}
                                )">
                                ✏️
                            </button>

                            <form method="POST" action="{{ route('seances.destroy', $s->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="db-danger-btn"
                                        onclick="return confirm('Supprimer ?')">
                                    🗑
                                </button>
                            </form>

                        </td>

                    </tr>

                @endforeach
                </tbody>

            </table>

        </div>

    </div>

</section>

{{-- MODAL --}}
<div class="modal fade" id="seanceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content db-card db-card--glass p-4">

            <h5 id="modalTitle" class="mb-3">Nouvelle Séance</h5>

            <form id="seanceForm" method="POST">
                @csrf
                <input type="hidden" id="seance_method" name="_method">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label>Date</label>
                        <input type="date" id="date" name="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Groupe</label>
                        <input type="text" id="groupe" name="groupe" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Début</label>
                        <input type="time" id="start_time" name="start_time" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Fin</label>
                        <input type="time" id="end_time" name="end_time" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Enseignant</label>
                        <select id="enseignant_id" name="enseignant_id" class="form-select">
                            @foreach($enseignants as $e)
                                <option value="{{ $e->id }}">{{ $e->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Prix / heure</label>
                        <input type="number" id="prix_heure" name="prix_heure" class="form-control">
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="db-ghost-btn" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="db-primary-btn">Enregistrer</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

document.addEventListener("DOMContentLoaded", function () {

    const modal = new bootstrap.Modal(document.getElementById('seanceModal'));

    const form = document.getElementById('seanceForm');
    const title = document.getElementById('modalTitle');

    window.openAddModal = function () {
        form.reset();
        form.action = "{{ route('seances.store') }}";
        document.getElementById('seance_method').value = "";
        title.innerText = "Nouvelle Séance";
        modal.show();
    };

    window.openEditModal = function (id, date, start, end, groupe, enseignantId, prix) {

        document.getElementById('date').value = date;
        document.getElementById('start_time').value = start;
        document.getElementById('end_time').value = end;
        document.getElementById('groupe').value = groupe;
        document.getElementById('enseignant_id').value = enseignantId;
        document.getElementById('prix_heure').value = prix;

        form.action = `/seances/${id}`;
        document.getElementById('seance_method').value = "PUT";

        title.innerText = "Modifier Séance";
        modal.show();
    };

    document.getElementById('search').addEventListener('input', function () {
        let value = this.value.toLowerCase();

        document.querySelectorAll('.seance-row').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';
        });
    });

});

</script>
@endpush