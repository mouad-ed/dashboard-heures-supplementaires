@extends('layouts.master')

@section('content')

<section class="db-page">

    {{-- HEADER --}}
    <div class="db-page__head">
        <div>
            <h1 class="db-h1">Gestion des Élèves</h1>
            <p class="db-muted">Liste des élèves</p>
        </div>

        <button class="db-primary-btn" type="button" onclick="openAddModal()">
            + Nouveau Élève
        </button>
    </div>

    {{-- SEARCH --}}
    <div class="db-card db-card--glass mb-3">
        <div class="d-flex justify-content-between align-items-center">

            <div class="db-pill">
                Total : {{ $eleves->count() }}
            </div>

            <div class="db-search" style="max-width:400px;">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="db-search__input"
                       placeholder="Rechercher élève...">
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="db-card db-card--glass">

        <div class="table-responsive">

            <table class="table align-middle mb-0" id="elevesTable">

                <thead>
                <tr>
                    <th>Élève</th>
                    <th>Contact</th>
                    <th>Père</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($eleves as $eleve)
                    <tr class="eleve-row">

                        <td class="fw-semibold">{{ $eleve->name }}</td>
                        <td>{{ $eleve->phone }}</td>
                        <td>{{ $eleve->father_phone }}</td>

                        <td class="text-end">

                            <button class="db-ghost-btn editBtn"
                                data-id="{{ $eleve->id }}"
                                data-name="{{ $eleve->name }}"
                                data-phone="{{ $eleve->phone }}"
                                data-father="{{ $eleve->father_phone }}">
                                ✏️
                            </button>

                            <button class="db-danger-btn deleteBtn"
                                data-id="{{ $eleve->id }}">
                                🗑
                            </button>

                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

</section>

{{-- MODAL --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content db-card db-card--glass p-4">

            <form id="form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="method">

                <h5 id="title" class="mb-3">Ajouter Élève</h5>

                <input type="text" name="name" id="name" class="form-control mb-2" placeholder="Nom" required>

                <input type="text" name="phone" id="phone" class="form-control mb-2" placeholder="Téléphone" required>

                <input type="text" name="father_phone" id="father_phone" class="form-control mb-3" placeholder="Téléphone père" required>

                <div class="d-flex justify-content-end gap-2">
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

    const modalEl = document.getElementById('addModal');
    const modal = new bootstrap.Modal(modalEl);

    const form = document.getElementById('form');
    const title = document.getElementById('title');
    const method = document.getElementById('method');

    // ================= ADD =================
    window.openAddModal = function () {
        form.reset();
        form.action = "/eleves";
        method.value = "";
        title.innerText = "Ajouter Élève";
        modal.show();
    };

    // ================= EDIT =================
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {

            document.getElementById('name').value = btn.dataset.name;
            document.getElementById('phone').value = btn.dataset.phone;
            document.getElementById('father_phone').value = btn.dataset.father;

            form.action = "/eleves/" + btn.dataset.id;
            method.value = "PUT";
            title.innerText = "Modifier Élève";

            modal.show();
        });
    });

    // ================= DELETE =================
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', () => {

            if (!confirm('Supprimer cet élève ?')) return;

            fetch('/eleves/' + btn.dataset.id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    btn.closest('tr').remove();
                } else {
                    alert('Erreur suppression');
                }
            });

        });
    });

    // ================= SEARCH =================
    document.getElementById('searchInput').addEventListener('input', function () {

        let value = this.value.toLowerCase();

        document.querySelectorAll('.eleve-row').forEach(row => {
            row.style.display =
                row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });

    });

});

</script>
@endpush