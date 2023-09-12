@extends('layouts.app')

@section('page-title', __('Lista') )

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
                        <th>DESCRIZIONE</th>
                        <th>UM</th>
                        <th>QUANTITA</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="{{ route('inventory.create', ['key' => $key]) }}" style="background: rgb(238, 147, 238) !important;" class="btn btn-lg bg-secondary text-light text-uppercase">{{ __('Chiudi') }}</a>
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
                ajax: '{{ route('lista.datatables') }}',
                columns: [
                    { data: 'descrizione_articolo', name: 'descrizione_articolo' },
                    { data: 'unit__di_misura_prezzo', name: 'unit__di_misura_prezzo' },
                    { data: 'quantita', name: 'quantita' },
                ],
                language : {
                    processing: '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                },
            });


        });
    </script>
@endpush