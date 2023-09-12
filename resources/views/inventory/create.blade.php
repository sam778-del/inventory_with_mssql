@extends('layouts.app')

@section('page-title', __('Inventario') )

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
<style>
    @media (max-width: 767px) {
        .card-body .col-sm-6 {
            width: 45%;
        }
    }
</style>
@endpush

@section('page-content')
<div class="row g-3 row-deck">
    <div class="col-12 justify-content-center">
        <div class="card">
            <div class="card-header">
                <h4><a href="{{ route("inventory.index") }}" class="fa fa-arrow-circle-left me-2" title="Shop Code: {{ Auth::user()->pdv_riferimento }}"></a>{{ Auth::user()->pdv_riferimento }} - {{ date('d/m/Y', strtotime($data['data_inventario'])) }}</h4>
                <div class="dropdown morphing scale-left">
                    <a href="javascript:void(0);" class="card-fullscreen" data-bs-toggle="tooltip" title="{{ __("Full Screen") }}"><i class="icon-size-fullscreen"></i></a>
                </div>
            </div>
            {!! Form::open(["route" => ["inventory.store"], "method" => "POST", "id" => "submit-form"]) !!}
                <input type="hidden" name="cod_punto_vendita" value="{{ $data['cod_punto_vendita'] }}">
                <input type="hidden" name="progressivo_inventario" value="{{ $data['progressivo_inventario'] }}">
                <input type="hidden" name="anno_esercizio" value="{{ $data['anno_esercizio'] }}">
                <input type="hidden" name="data_inventario" value="{{ $data['data_inventario'] }}">
                <input type="hidden" name="inventario_tipo" value="{{ $data['inventario_tipo'] }}">
                <input type="hidden" name="flag_invent_avariato_s_n" value="{{ $data['flag_invent_avariato_s_n'] }}">
                <input type="hidden" name="des__inventario" value="{{ $data['des__inventario'] }}">
                <input type="hidden" name="inventario_chiuso_s_n" value="{{ $data['inventario_chiuso_s_n'] }}">
                <input type="hidden" name="flag_congelata_giacenza" value="{{ $data['flag_congelata_giacenza'] }}">
                <input type="hidden" name="data_congelam__giacenza" value="{{ $data['data_congelam__giacenza'] }}">
                <input type="hidden" name="data_ultimo_aggiorn_" value="{{ $data['data_ultimo_aggiorn_'] }}">
                <input type="hidden" name="ora_ultimo_aggior_" value="{{ $data['ora_ultimo_aggior_'] }}">
                <input type="hidden" name="utente_ultimo_aggiorn_" value="{{ $data['utente_ultimo_aggiorn_'] }}">
                <input type="hidden" name="segn_stato_record" value="{{ $data['segn_stato_record'] }}">
                <input type="hidden" name="cod_fornitore" id="cod_fornitore" value="">
                <input type="hidden" name="differenziatore_fornit_" id="differenziatore_fornit_" value="" />
                <input type="hidden" name="cod_merc_area" id="cod_merc_area" value="" />
                <input type="hidden" name="c_merc_settore" id="c_merc_settore" value="" />
                <input type="hidden" name="c_merc_gruppo" id="c_merc_gruppo" value="" />
                <input type="hidden" name="c_merc_segmento" id="c_merc_segmento" value="" />
                <input type="hidden" name="cod_merceolog__progres_" id="cod_merceolog__progres_" value="" />
                <input type="hidden" name="cod_ragg_reparto_casse" id="cod_ragg_reparto_casse" value="" />
                <input type="hidden" name="cod_stato_articolo" id="cod_stato_articolo" value="" />
                <input type="hidden" name="cod_tipo_articolo" id="cod_tipo_articolo" value="" />
                <input type="hidden" name="flag_artic__da_pesare" id="flag_artic__da_pesare" value="" />
                <input type="hidden" name="peso_per_pezzo" id="peso_per_pezzo" value="" />
                <input type="hidden" name="iva" id="iva" value="" />
                <input type="hidden" name="is_exist" id="is_exist" value="0" />
                <!-- <input type="hidden" name="flag_artic__da_pesare" id="flag_artic__da_pesare" value="" /> -->
                <!-- <input type="hidden" name="flag_artic__da_pesare" id="flag_artic__da_pesare" value="" /> -->
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Barcode</label>
                            <div class="input-group">
                                <input type="text" name="barcode_number" id="barcode_number" class="form-control form-control-lg" >
                                <button type="button" id="searchCode" style="display:none; background-color: orange !important;" class="btn btn-lg bg-success text-light text-uppercase">ENTER</button>
                                <button type="button" id="scanCode" style="background-color: orange !important;" class="btn btn-lg bg-success text-light text-uppercase">SCAN</button>
                            </div>
                            <span id="errorCodeMsg" style="display:none;color:red;"></span>
                        </div>
                        <div class="col-sm-12">
                            <textarea rows="2" cols="2" name="description" id="description" class="form-control form-control-lg"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-sm-6">
                                <label class="form-label">Codice Articolo</label>
                                <div class="input-group">
                                    <input type="number" id="codice_articolo" name="codice_articolo" class="form-control form-control-lg" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Variante Articolo</label>
                                <div class="input-group">
                                    <input type="number" id="sub_code" name="variante_articolo" class="form-control form-control-lg" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Quantita</label>
                            <div class="input-group">
                                <input type="number" id="quantita" name="quantita" min="0" class="form-control form-control-lg">
                                <button id="form-submit" style="background: rgb(238, 147, 238) !important;" class="btn btn-lg bg-secondary text-light text-uppercase" type="button">{{ __('Enter') }}</button>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="barcode">
                                <label class="form-check-label" for="barcode">Chiedi EAN</label>
                            </div>
                        </div> -->
                        <div class="d-flex justify-content-between">
                            <div class="col-sm-6">
                                <label class="form-label">UM</label>
                                <input type="text" id="unit_measurement" name="um" class="form-control form-control-lg">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Prec.ins</label>
                                <input type="number" value="0" name="prec_ins" min="0" max="99999.99" id="prec_ins" class="form-control form-control-lg">
                                <span id="errorPrecMsg" style="display:none;color:red;">Il valore deve essere compreso tra 0 e 99999.99.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('lista.index', ['key' => \Illuminate\Support\Facades\Crypt::encryptString(json_encode($data))]) }}" target="_tab" style="background: rgb(238, 147, 238) !important;" class="btn btn-lg bg-secondary text-light text-uppercase">{{ __('Lista') }}</a>
                    <button id="form-reset" style="background: rgb(240, 240, 153) !important;" class="btn btn-lg bg-secondary text-light text-uppercase" type="button">{{ __('Reset') }}</button>
                    <a href="{{ route('inventory.index') }}" style="background: rgb(238, 105, 105) !important;" class="btn btn-lg bg-secondary text-light text-uppercase">{{ __('Esci') }}</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="barcodeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Scan</h5>
                <button type="button" class="btn-close closeb" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <center>
                        <div id="reader"></div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Articolo gia rilevato</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12 mb-5">
                                <p class="text-desc mb-2" id="somma_text"></p>
                                <button type="button" id="submitSomma" style="background-color: rgb(246, 246, 58) !important;" class="btn btn-lg bg-secondary text-light">Somma</button>
                            </div>
                            <div class="col-sm-12 mb-5">
                                <p class="text-desc mb-2" id="rettifica_text"></p>
                                <button type="button" id="submitRettifica" style="background-color: rgb(244, 114, 114) !important;" class="btn btn-lg bg-secondary text-light">Rettifica</button>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-desc mb-2" id="annula_text"></p>
                                <button type="button" id="submitAnnula" style="background-color: rgb(126, 246, 126) !important;" class="btn btn-lg bg-secondary text-light">Annula</button>
                            </div>
                            <p class="text-desc" id="primma_desc"></p>
                            <p class="text-desc" id="seconda_desc"></p>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('/barcode/barcode.js') }}"></script>
<script>
    function isValidCode32(barcode) {
      const code32set = "0123456789BCDFGHJKLMNPQRSTUWXY";
      // Check if every character in the barcode is in the code32set
      return [...barcode].every(char => code32set.includes(char));
    }

    function code39ToCode32(code39) {
      const len = code39.length;
      let result = 0;
  
      for (let i = 0; i < len; i++) {
        const char = code39[len - i - 1];
        const base32 = char.charCodeAt(0);
        let base10 = base32 - (48 + (8 * (base32 > 65)) + (base32 > 69) + (base32 > 73) + (base32 > 79));
        result += base10 * Math.pow(32, i);
      }
  
      return result.toString().padStart(8, '0');
    }

    function checkIfCode39(code39)
    {
      if (!isValidCode32(code39)) {
        return false;
      }

      return true;
    }

    $(window).on("load", function () {
      $('#barcode_number').focus();
      // var codeA = code39ToCode32("0HHPL0");
      // alert(codeA);
    });

    $(document).ready(function () {
      $('#form-submit').prop("disabled", true);

      $("#prec_ins").keyup(function () {
        if ($(this).val() < 0 || $(this).val() > 99999.99) {
          $('#errorPrecMsg').show();
          $(this).val('99999.99');
          $('#form-submit').prop("disabled", true);
        }
        else {
          $('#errorPrecMsg').hide();
          $('#form-submit').prop("disabled", false);
        }
      });
      

      $('#scanCode').on('click', function () {
        $(this).prop("disabled", true);
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#barcode_number').prop("readonly", true);
        const sound = new Audio("{{ asset('barcode/barcode.wav') }}");
        docReady(function () {
          function onScanSuccess(decodedText, decodedResult) {
            var $bacodeVal = $('#barcode_number');
            switch (validateScan(decodedText)) {
              case true:
                  sound.play();
                  $bacodeVal.val(decodedText);
                  $('#barcodeModal').modal('hide');
                break;
            
              default:
                if(checkIfCode39(decodedText)) {
                  sound.play();
                  var codeA = code39ToCode32(decodedText);
                  $bacodeVal.val(codeA);
                  $('#barcodeModal').modal('hide');
                }
                break;
            }
            // if(checkIfCode39(decodedText)) {
            //   sound.play();
            //   var codeA = code39ToCode32(decodedText);
            //   $bacodeVal.val(codeA);
            //   $('#barcodeModal').modal('hide');
            // }else {
            //   var regExp = /[a-zA-Z]/g;
            //   if(regExp.test(decodedText)){
            //     alert('wrong value'+decodedText);
            //   }else {
            //     sound.play();
            //     $bacodeVal.val(decodedText);
            //     $('#barcodeModal').modal('hide');
            //   }
            // }
            if($bacodeVal.length != 0){
                $('#scanCode').hide();
                $('#searchCode').show();
                $('#searchCode').click();
            }
          }
          var qrboxFunction = function (viewfinderWidth, viewfinderHeight) {
            // Square QR Box, with size = 80% of the min edge.
            var minEdgeSizeThreshold = 250;
            var edgeSizePercentage = 0.75;
            var minEdgeSize = (viewfinderWidth > viewfinderHeight) ?
              viewfinderHeight : viewfinderWidth;
            var qrboxEdgeSize = Math.floor(minEdgeSize * edgeSizePercentage);
            if (qrboxEdgeSize < minEdgeSizeThreshold) {
              if (minEdgeSize < minEdgeSizeThreshold) {
                return { width: minEdgeSize, height: minEdgeSize };
              } else {
                return {
                  width: minEdgeSizeThreshold,
                  height: minEdgeSizeThreshold
                };
              }
            }
            return { width: qrboxEdgeSize, height: qrboxEdgeSize };
          }

          const formatsToSupport = [
            Html5QrcodeSupportedFormats.EAN_8,
            Html5QrcodeSupportedFormats.EAN_13,
            Html5QrcodeSupportedFormats.CODE_39
          ];

          let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            {
              fps: 10,
              qrbox: qrboxFunction,
              formatsToSupport: formatsToSupport,
              supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
              experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
              },
              rememberLastUsedCamera: true,
              showTorchButtonIfSupported: true
            });
          html5QrcodeScanner.render(onScanSuccess);
        });
        $('#barcodeModal').modal('show');
      });
    })

    var checkIfexists = function (anno_esercizio, progressivo_inventario, cod_punto_vendita, cod__articolo, variante_articolo) {
      return $.ajax({
        url: '{{ route('inventory.check_if_exists') }}',
        method: 'POST', // or 'POST' for example
        data: {
          "_token": "{!! csrf_token() !!}",
          "anno_esercizio": anno_esercizio,
          "progressivo_inventario": progressivo_inventario,
          "cod_punto_vendita": cod_punto_vendita,
          "cod__articolo": cod__articolo,
          "variante_articolo": variante_articolo
        }
      });
    };

    $(document).ready(function () {
      $("#updateModal").on("hidden.bs.modal", function () {
        $('#form-submit').prop("disabled", false);
        $('#form-submit').html('ENTER');
      });

      $("#barcodeModal").on("hidden.bs.modal", function () {
        $('#html5-qrcode-button-camera-stop').click();
        $('#scanCode').prop("disabled", false);
        $('#scanCode').html('SCAN');
        $('#barcode_number').prop("readonly", false);
      });

      $('#form-reset').on('click', function () {
        $('#html5-qrcode-button-camera-stop').click();
        $('#submit-form')[0].reset();
        $('#description').html('');
        $('#scanCode').prop("disabled", false);
        $('#searchCode').prop("disabled", false);
        $('#searchCode').hide();
        $('#scanCode').show();
        $(this).html('RESET');
      });

      $('.btn-close').on('click', function () {
        $('#updateModal').modal('hide');
      });

      $('.closeb').on('click', function() {
        $("#barcodeModal").modal('hide');
      });

      $('#form-submit').on("click", function () {
        if ($('#quantita').val() == '' || $('#quantita').val() == 0) {
          $('#quantita').focus();
          return false;
        }

        $(this).prop("disabled", true);
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        var is_exist = $('#is_exist').val();
        switch (is_exist) {
          case '1':
            let qta = $('#quantita').val() != '' ? $('#quantita').val() : 0;
            let pre_ins = $('#prec_ins').val() != '' ? $('#prec_ins').val() : 0;
            let total = parseFloat(qta) + parseFloat(pre_ins);
            if (pre_ins == 0) {
              $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
              let anno_esercizio = $('input[name="anno_esercizio"]').val();
              let progressivo_inventario = $('input[name="progressivo_inventario"]').val();
              let cod_punto_vendita = $('input[name="cod_punto_vendita"]').val();
              let cod__articolo = $('#codice_articolo').val();
              let variante_articolo = $('#sub_code').val();
              let unit_measurement = $('#unit_measurement').val();
              // console.log(unit_measurement);
              // add total
              $.ajax({
                url: '{{ route('inventory.update_if_exists') }}',
                method: 'POST', // or 'POST' for example
                data: {
                  "_token": "{!! csrf_token() !!}",
                  "anno_esercizio": anno_esercizio,
                  "progressivo_inventario": progressivo_inventario,
                  "cod_punto_vendita": cod_punto_vendita,
                  "cod__articolo": cod__articolo,
                  "variante_articolo": variante_articolo,
                  "um": unit_measurement,
                  "quantity": qta
                },
                success: function (data) {
                  if (data.status == true) {
                    toastr.success("{{__('Success') }}", data.msg, 'success');
                  } else {
                    toastr.error("{{__('Error') }}", data.msg, 'error');
                  }
                  location.reload();
                },
                error: function (error) {
                  toastr.error("{{__('Error') }}", "Errore durante l'elaborazione della tua richiesta", 'error');
                }
              });
            } else {
              $('#somma_text').html(`Vuoi sommare le qta ${qta} + ${pre_ins} = ${parseFloat(total)}`);
              $('#rettifica_text').html(`Vuoi confermare la seconda qta? = ${parseFloat(qta)}`);
              $('#annula_text').html(`Vuoi confermare la prima qta? = ${parseFloat(pre_ins)}`);
              $('#primma_desc').html(`Prima qta (precedente): ${qta}`);
              $('#seconda_desc').html(`Seconda qta (digitata): ${pre_ins}`);
              $('#updateModal').modal('show');
            }
            break;

          default:
            $('#submit-form').submit();
            break;
        }
      });

      $('#submitSomma').on('click', function () {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        let anno_esercizio = $('input[name="anno_esercizio"]').val();
        let progressivo_inventario = $('input[name="progressivo_inventario"]').val();
        let cod_punto_vendita = $('input[name="cod_punto_vendita"]').val();
        let cod__articolo = $('#codice_articolo').val();
        let variante_articolo = $('#sub_code').val();
        let unit_measurement = $('#unit_measurement').val();
        // add total
        let qta = $('#quantita').val();
        let pre_ins = $('#prec_ins').val() != '' ? $('#prec_ins').val() : 0;
        let total = parseFloat(qta) + parseFloat(pre_ins);
        $.ajax({
          url: '{{ route('inventory.update_if_exists') }}',
          method: 'POST', // or 'POST' for example
          data: {
            "_token": "{!! csrf_token() !!}",
            "anno_esercizio": anno_esercizio,
            "progressivo_inventario": progressivo_inventario,
            "cod_punto_vendita": cod_punto_vendita,
            "cod__articolo": cod__articolo,
            "variante_articolo": variante_articolo,
            "um": unit_measurement,
            "quantity": total
          },
          success: function (data) {
            if (data.status == true) {
              toastr.success("{{__('Success') }}", data.msg, 'success');
            } else {
              toastr.error("{{__('Error') }}", data.msg, 'error');
            }
            location.reload();
          },
          error: function (error) {
            toastr.error("{{__('Error') }}", "Errore durante l'elaborazione della tua richiesta", 'error');
          }
        });
      });

      $('#submitRettifica').on('click', function () {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        let anno_esercizio = $('input[name="anno_esercizio"]').val();
        let progressivo_inventario = $('input[name="progressivo_inventario"]').val();
        let cod_punto_vendita = $('input[name="cod_punto_vendita"]').val();
        let cod__articolo = $('#codice_articolo').val();
        let variante_articolo = $('#sub_code').val();
        let unit_measurement = $('#unit_measurement').val();
        // add total
        let qta = $('#quantita').val();
        $.ajax({
          url: '{{ route('inventory.update_if_exists') }}',
          method: 'POST', // or 'POST' for example
          data: {
            "_token": "{!! csrf_token() !!}",
            "anno_esercizio": anno_esercizio,
            "progressivo_inventario": progressivo_inventario,
            "cod_punto_vendita": cod_punto_vendita,
            "cod__articolo": cod__articolo,
            "variante_articolo": variante_articolo,
            "um": unit_measurement,
            "quantity": qta
          },
          success: function (data) {
            if (data.status == true) {
              toastr.success("{{__('Success') }}", data.msg, 'success');
            } else {
              toastr.error("{{__('Error') }}", data.msg, 'error');
            }
            location.reload();
          },
          error: function (error) {
            toastr.error("{{__('Error') }}", "Errore durante l'elaborazione della tua richiesta", 'error');
          }
        });
      });

      $('#submitAnnula').on('click', function () {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        let anno_esercizio = $('input[name="anno_esercizio"]').val();
        let progressivo_inventario = $('input[name="progressivo_inventario"]').val();
        let cod_punto_vendita = $('input[name="cod_punto_vendita"]').val();
        let cod__articolo = $('#codice_articolo').val();
        let variante_articolo = $('#sub_code').val();
        let unit_measurement = $('#unit_measurement').val();
        // add total
        let pre_ins = $('#prec_ins').val() != '' ? $('#prec_ins').val() : 0;
        $.ajax({
          url: '{{ route('inventory.update_if_exists') }}',
          method: 'POST', // or 'POST' for example
          data: {
            "_token": "{!! csrf_token() !!}",
            "anno_esercizio": anno_esercizio,
            "progressivo_inventario": progressivo_inventario,
            "cod_punto_vendita": cod_punto_vendita,
            "cod__articolo": cod__articolo,
            "variante_articolo": variante_articolo,
            "um": unit_measurement,
            "quantity": pre_ins
          },
          success: function (data) {
            if (data.status == true) {
              toastr.success("{{__('Success') }}", data.msg, 'success');
            } else {
              toastr.error("{{__('Error') }}", data.msg, 'error');
            }
            location.reload();
          },
          error: function (error) {
            toastr.error("{{__('Error') }}", "Errore durante l'elaborazione della tua richiesta", 'error');
          }
        });
      });
    });

    function fetchBarcodeData(barcodeNumber) {
      $.ajax({
        url: '{{ route('inventory.barcode_data') }}',
        method: 'POST', // or 'POST' for example
        data: {
          "_token": "{!! csrf_token() !!}",
          "barcode_number": barcodeNumber
        },
        success: function (data) {
          $('#cod_fornitore').val(data.msg[0].cod_fornitore);
          $('#differenziatore_fornit_').val(data.msg[0].differenziatore_fornit_);
          $('#cod_merc_area').val(data.msg[0].cod_merc_area);
          $('#c_merc_settore').val(data.msg[0].c_merc_settore);
          $('#c_merc_gruppo').val(data.msg[0].c_merc_gruppo);
          $('#c_merc_segmento').val(data.msg[0].c_merc_segmento);
          $('#cod_merceolog__progres_').val(data.msg[0].cod_merceolog__progres_);
          $('#cod_ragg_reparto_casse').val(data.msg[0].cod_ragg_reparto_casse);
          $('#cod_stato_articolo').val(data.msg[0].cod_stato_articolo);
          $('#cod_tipo_articolo').val(data.msg[0].cod_tipo_articolo);
          $('#flag_artic__da_pesare').val(data.msg[0].flag_artic__da_pesare);
          $('#peso_per_pezzo').val(data.msg[0].peso_per_pezzo);
          $('#iva').val(data.msg[0].aliquota_iva);
          // $('#flag_artic__da_pesare').val(data.msg[0].);

          // Handle the data returned from the server
          $('#description').html(data.msg[0].descrizione_articolo);
          $('#unit_measurement').val(data.msg[0].unit__di_misura_prezzo);
          $('#codice_articolo').val(data.msg[0].cod__articolo);
          $('#sub_code').val(data.msg[0].variante_articolo);
          $('#description').prop("readonly", true);
          $('#unit_measurement').prop("readonly", true);
          $('#codice_articolo').prop("readonly", true);
          $('#sub_code').prop("readonly", true);

          let anno_esercizio = $('input[name="anno_esercizio"]').val();
          let progressivo_inventario = $('input[name="progressivo_inventario"]').val();
          let cod_punto_vendita = $('input[name="cod_punto_vendita"]').val();
          let cod__articolo = $('#codice_articolo').val();
          let variante_articolo = $('#sub_code').val();
          checkIfexists(anno_esercizio, progressivo_inventario, cod_punto_vendita, cod__articolo, variante_articolo)
            .done(function (data) {
              var unit_m = data.msg.unit__di_misura_prezzo;
              $('#prec_ins').prop("readonly", true);
              switch (unit_m) {
                case 'PZ':
                  $('#prec_ins').val(data.msg.prelievo__qta_pz);
                  break;
                case 'KG':
                  $('#prec_ins').val(data.msg.prelievo_qta_in_kg);
                  break;
                default:
                  $('#prec_ins').val(data.msg.prelievo_qta_in_pz);
                  break;
              }
              $('#quantita').focus();
              $('#is_exist').val('1');
              $('#barcode_number').prop("readonly", false);
              $('#searchCode').html('ENTER');
              $('#searchCode').prop("disabled", false);
              // $('#quantita').val('0');
              $('#form-submit').prop("disabled", false);
            })
            .fail(function (error) {
              $('#quantita').focus();
              $('#is_exist').val('0');
              // $('#quantita').val('1');
              $('#barcode_number').prop("readonly", false);
              $('#searchCode').html('ENTER');
              $('#searchCode').prop("disabled", false);
              $('#form-submit').prop("disabled", false);
            });
        },
        error: function (xhr, status, error) {
          $('#form-submit').prop("disabled", true);
          $('#description').prop("readonly", false);
          $('#unit_measurement').prop("readonly", false);
          $('#codice_articolo').prop("readonly", false);
          $('#sub_code').prop("readonly", false);
          $('#barcode_number').prop("readonly", false);
          $('#searchCode').html('ENTER');
          $('#searchCode').prop("disabled", false);
          $('#errorCodeMsg').show();
          $('#errorCodeMsg').html(xhr.responseJSON.msg);
        }
      });
    }

    $(document).ready(function () {
      var timeout;
      var delay = 2000;   // 2 seconds
      $('#barcode_number').on('keyup', function (e) {
        if (timeout) {
          clearTimeout(timeout);
        }

        var $input = $(this); // Capture $(this) in a variable
        $('#form-submit').html('ENTER');
        $('#form-submit').prop("disabled", true);
        $('#description').prop("readonly", false);
        $('#unit_measurement').prop("readonly", false);
        $('#codice_articolo').prop("readonly", false);
        $('#sub_code').prop("readonly", false);
        $('#errorCodeMsg').hide();
        $('#description').html('');
        $('#prec_ins').val('');
        $('#unit_measurement').val('');
        $('#codice_articolo').val('');
        $('#sub_code').val('');

        var barcodeNumber = $input.val();
        if (barcodeNumber.length != 0) {
          $('#scanCode').hide();
          $('#searchCode').show();
        } else {
          $('#scanCode').show();
          $('#searchCode').hide();
        }

        timeout = setTimeout(function () {
          var barcodeNumber = $input.val();
          if (barcodeNumber.length != 0) {
            $('#scanCode').hide();
            $('#searchCode').show();
          } else {
            $('#scanCode').show();
            $('#searchCode').hide();
          }
        }, delay);
      });

      $(document).keypress(function (e) {
        if (e.which == 13) {
          if ($('#quantita').is(':focus')) {
            $('#form-submit').click();
          } else {
            $('#searchCode').click();
          }
        }
      });

      function containsAlphabetAndNumbers(inputString) {
          const regex = /^(?=.*[a-zA-Z])(?=.*\d)/;
          return regex.test(inputString);
      }

      function validateScan(input) {
        var pattern = /^[0-9.]*$/;
        return pattern.test(input);
      }

      $('#searchCode').on('click', function () {
        var $input = $('#barcode_number'); // Capture $(this) in a variable
        $('#form-submit').html('ENTER');
        $('#form-submit').prop("disabled", true);
        $('#description').prop("readonly", false);
        $('#unit_measurement').prop("readonly", false);
        $('#codice_articolo').prop("readonly", false);
        $('#sub_code').prop("readonly", false);
        $('#errorCodeMsg').hide();
        $('#description').html('');
        $('#prec_ins').val('');
        $('#unit_measurement').val('');
        $('#codice_articolo').val('');
        $('#sub_code').val('');
        // next
        var barcodeNumber = $input.val();
          if (barcodeNumber.length != 0) {
            switch (validateScan(barcodeNumber)) {
              case true:
                $('#barcode_number').val(barcodeNumber);
                fetchBarcodeData(barcodeNumber); 
                $input.prop("readonly", true);
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $(this).prop("disabled", true);
                break;
            
              default:
                if(checkIfCode39(barcodeNumber)) {
                  var codeA = code39ToCode32(barcodeNumber);
                  $('#barcode_number').val(codeA);
                  fetchBarcodeData(codeA); 
                  $input.prop("readonly", true);
                  $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                  $(this).prop("disabled", true);
                }
                break;
            }
            // if(checkIfCode39(barcodeNumber)) {
            //   var codeA = code39ToCode32(barcodeNumber);
            //   $('#barcode_number').val(codeA);
            //   fetchBarcodeData(codeA); 
            // }else{
            //   $('#barcode_number').val('');
            // }
        }
      });
    });

    $(window).on('load', function () {
      $('.modal.fade').appendTo('body');
    });
  </script>
<script>
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }
</script>
@endpush