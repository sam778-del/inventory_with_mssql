@extends('layouts.app')

@section('page-title', __('Inventario') )

@section('page-content')
<div class="col-12">
    <div class="card-body border-bottom">
        <div class="row align-items-center">
            {{-- Other Widget --}}
            <div class="col ml-n2">
            </div>
            {{-- End of other widget --}}
            <!-- <div class="col-auto d-none d-md-inline-block">
                <a href="{{ route("inventory.create") }}" class="btn btn-primary" style="display:none">
                    <i class="bi bi-plus-lg"></i>
                    {{ __('Aggiungi prodotto') }}
                </a>
            </div> -->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="branch_list" class="table align-middle mb-0 card-table" cellspacing="0">
                <thead>
                    <tr>
                        <th col="2"></th>
                        <th>PDV</th>
                        <th>DESCRIZIONE</th>
                        <th>ID</th>
                        <th>ANNO</th>
                        <!-- <th>data_inventario</th>
                        <th>inventario_tipo</th>
                        <th>flag_invent_avariato_s_n</th>
                        <th>des__inventario</th>
                        <th>inventario_chiuso_s_n</th>
                        <th>flag_congelata_giacenza</th>
                        <th>data_congelam__giacenza</th>
                        <th>flag_esportato</th>
                        <th>data_ultimo_aggiorn_</th>
                        <th>ora_ultimo_aggior_</th>
                        <th>utente_ultimo_aggiorn_</th>
                        <th>segn_stato_record</th> -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#branch_list')
            .addClass( 'nowrap' )
            .dataTable( {
                responsive: true,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('inventory.datatables') }}',
                columns: [
                    { data: 'radio', searchable: false, orderable: false },
                    { data: 'cod_punto_vendita', name: 'cod_punto_vendita' },
                    { data: 'des__inventario', name: 'des__inventario' },
                    { data: 'progressivo_inventario', name: 'progressivo_inventario' },
                    { data: 'anno_esercizio', name: 'anno_esercizio' },
                    // { data: 'data_inventario', name: 'data_inventario' },
                    // { data: 'inventario_tipo', name: 'inventario_tipo' },
                    // { data: 'flag_invent_avariato_s_n', name: 'flag_invent_avariato_s_n' },
                    // { data: 'des__inventario', name: 'des__inventario' },
                    // { data: 'inventario_chiuso_s_n', name: 'inventario_chiuso_s_n' },
                    // { data: 'flag_congelata_giacenza', name: 'flag_congelata_giacenza' },
                    // { data: 'data_congelam__giacenza', name: 'data_congelam__giacenza' },
                    // { data: 'flag_esportato', name: 'flag_esportato' },
                    // { data: 'data_ultimo_aggiorn_', name: 'data_ultimo_aggiorn_' },
                    // { data: 'ora_ultimo_aggior_', name: 'ora_ultimo_aggior_' },
                    // { data: 'utente_ultimo_aggiorn_', name: 'utente_ultimo_aggiorn_' },
                    // { data: 'segn_stato_record', name: 'segn_stato_record' }
                ],
                language : {
                    processing: '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                },
            });


        });
    </script>
@endpush