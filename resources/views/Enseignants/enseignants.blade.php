@extends('layouts.master')

@section('content')

<section class="db-page">
    <div class="db-page__head">
        <div>
            <h1 class="db-h1">Gestion des Enseignants</h1>
            <p class="db-muted">Profils & pourcentages</p>
        </div>

        <div class="db-actions">
            <button class="db-primary-btn" type="button" onclick="openAddModal()">
                <i class="fas fa-plus me-2"></i> Nouveau Enseignant
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="db-card db-card--glass" style="padding:16px; margin-bottom:18px;">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-7">
                <div class="db-search db-search--module" style="height:46px;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" class="db-search__input" placeholder="Rechercher un enseignant...">
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="db-pill" style="justify-content:flex-end;">
                    <i class="fas fa-users me-2"></i> {{ $enseignants->count() }} résultats
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="db-card db-card--glass">
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="enseignantsTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Rémunération</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($enseignants as $e)
                        <tr>
                            <td class="text-muted">#{{ $e->id }}</td>
                            <td class="fw-semibold">{{ $e->nom }}</td>
                            <td>
                                <span class="db-pill">
                                    {{ $e->pourcentage }}%
                                </span>
                            </td>
                            <td class="text-muted">{{ $e->created_at->format('d/m/Y') }}</td>

                            <td class="text-end">

                                <button type="button"
                                    class="db-ghost-btn"
                                    onclick="openEditModal({{ $e->id }}, '{{ $e->nom }}', {{ $e->pourcentage }})">
                                    ✏️
                                </button>

                                <form action="{{ route('enseignants.destroy', $e->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="db-danger-btn"
                                        onclick="return confirm('Supprimer cet enseignant ?')">
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
<div class="modal fade" id="enseignantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content db-card db-card--glass p-4">

            <h5 id="modalTitle"></h5>

            <form id="enseignantForm" method="POST">
                @csrf
                <input type="hidden" id="enseignant_method" name="_method">

                <div class="mb-3">
                    <label>Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Pourcentage</label>
                    <input type="number" id="pourcentage" name="pourcentage" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="db-ghost-btn" data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="db-primary-btn">
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

    const modalEl = document.getElementById('enseignantModal');
    const modal = new bootstrap.Modal(modalEl);

    const form = document.getElementById('enseignantForm');
    const title = document.getElementById('modalTitle');
    const methodInput = document.getElementById('enseignant_method');

    // expose globally (IMPORTANT)
    window.openAddModal = function () {
        form.reset();
        form.action = "{{ route('enseignants.store') }}";
        methodInput.value = "";
        title.innerText = "Ajouter Enseignant";
        modal.show();
    };

    window.openEditModal = function (id, nom, pourcentage) {
        document.getElementById('nom').value = nom;
        document.getElementById('pourcentage').value = pourcentage;

        form.action = `/enseignants/${id}`;
        methodInput.value = "PUT";
        title.innerText = "Modifier Enseignant";

        modal.show();
    };

    // search
    document.getElementById('search').addEventListener('input', function () {
        const value = this.value.toLowerCase();

        document.querySelectorAll('#enseignantsTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';
        });
    });

});

</script>
@endpush