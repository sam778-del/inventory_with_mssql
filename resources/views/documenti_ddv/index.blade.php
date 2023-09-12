@extends('layouts.app')

@section('page-title', __('Documenti') )

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('/css/jquerysteps.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/daterangepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/parsley.css') }}" />
@endpush

@section('page-content')
<div class="row g-3 row-deck">
    <div class="col-12 justify-content-center">
        <div class="card">
            <div class="card-header">
                <h4><a href="{{ route("inventory.index") }}" class="fa fa-arrow-circle-left me-2" title="Shop Code: {{ Auth::user()->pdv_riferimento }}"></a>ENTARA</h4>
                <div class="dropdown morphing scale-left">
                    <a href="javascript:void(0);" class="card-fullscreen" data-bs-toggle="tooltip" title="{{ __("Full Screen") }}"><i class="icon-size-fullscreen"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="d-flex justify-content-center">
                        <div class="col-sm-8 mb-3">
                            {!! Form::open(["route" => ["fatura.search.ddv"], "method" => "GET", "id" => "submit-search"]) !!}
                                <label class="form-label">Partita Iva</label>
                                <div class="input-group">
                                    <input type="number" name="partita_iva" value="{{ isset($_GET['partita_iva']) ? $_GET['partita_iva'] : '' }}" class="form-control form-control-lg" >
                                    <button id="form-submit" class="btn btn-lg bg-secondary text-light text-uppercase" type="button">{{ __('SEARCH') }}</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    @if(isset($result) && !empty($result))
                        {!! Form::open(["route" => ["documenti_ddv.store"], "class" => "validation", "method" => "POST", "id" => "submit-wizard"]) !!}
                            <div class="d-flex justify-content-center">
                                <div class="col-sm-8">
                                    <div class="step-app h-wizard-demo1">
                                        <ul class="step-steps d-flex justify-content-center">
                                            <li data-step-target="step1"><span>1</span></li>
                                            <li data-step-target="step2"><span>2</span></li>
                                            <li data-step-target="step3"><span>3</span></li>
                                        </ul>
                                        <div class="step-content">
                                            <div class="step-tab-panel" data-step="step1">
                                                <div class="row g-3 mb-5">
                                                    <div class="col-sm-6">
                                                        <label class="form-label">Cod Fornitore</label>
                                                        <div class="input-group">
                                                            <input type="text" id="cod_fornitore" value="{{ $result[0]['cod_fornitore'] }}" name="cod_fornitore" class="form-control form-control-lg" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label">Var Fornitore</label>
                                                        <div class="input-group">
                                                            <input type="text" id="var_fornitore" value="{{ $result[0]['differenziatore_fornit_'] }}" name="var_fornitore" class="form-control form-control-lg" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label class="form-label">Ragione Sociale</label>
                                                        <textarea rows="2" name="ragione_sociale" id="ragione_sociale" class="form-control form-control-lg">{{ $result[0]['ragione_sociale_forn_'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="step-tab-panel" data-step="step2">
                                                <div class="row g-3 mb-5">
                                                    <!-- <div class="col-sm-12">
                                                        <label class="form-label">PARTITA IVA DESTINATARIO</label>
                                                        <div class="input-group">
                                                            <input type="number" id="partita_iva_destinatario" value="{{ isset($_GET['partita_iva']) ? $_GET['partita_iva'] : '' }}" name="partita_iva_destinatario" class="form-control form-control-lg" >
                                                            <button class="btn btn-lg bg-secondary text-light text-uppercase" type="button">{{ __('SEARCH') }}</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                            <label class="form-check-label" for="flexCheckChecked">IDEM</label>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-12">
                                                        <label class="form-label">RAGIONE SOCIALE</label>
                                                        <div class="input-group">
                                                            <input type="text" name="destinatario_sociale" value="{{ $result[0]['DESTINATARIO_MERCE_RAGIONE_SOCIALE'] }}" class="form-control form-control-lg" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" name="dest_merce_indirizzo" value="{{ $result[0]['DEST_MERCE_INDIRIZZO'] }}" class="form-control form-control-lg" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input type="text" name="dest_merce_luogo" value="{{ $result[0]['DEST_MERCE_LUOGO'] }}" class="form-control form-control-lg" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="step-tab-panel" data-step="step3">
                                                <div class="col-sm-12">
                                                    <label class="form-label">Numero documento</label>
                                                    <div class="input-group">
                                                        <input type="text" name="var_fornitore" class="form-control form-control-lg" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="form-label">Data documento</label>
                                                    <div class="input-group">
                                                        <input type="text" name="data_documento" class="form-control form-control-lg datepicker" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-footer card-footer d-flex justify-content-between">
                                            <button class="btn step-btn" data-step-action="prev">Exit</button>
                                            <button class="btn step-btn" data-step-action="next">Aventi</button>
                                            <button class="btn step-btn finish" data-step-action="finish">Crea Documento</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('/bundles/jquerysteps.bundle.js') }}"></script>
<script src="{{ asset('/bundles/jquerysteps.bundle.js') }}"></script>
<script src="{{ asset('/bundles/parsley.js') }}"></script>
<script>
    $(function() {
        $('input[name="data_documento"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: false,
        }, function(start, end, label) {

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#form-submit').on('click', function() {
            $(this).prop("disabled", true);
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-search').submit();
        });

        $('.finish').on('click', function() {
            $(this).prop("disabled", true);
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-wizard').submit();
        });

        $('.h-wizard-demo1').steps({});
    });
</script>
@endpush