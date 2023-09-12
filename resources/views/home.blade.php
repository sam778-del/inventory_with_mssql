@extends('layouts.app')

@section('page-content')
<div class="container">
    <div class="row">
        <center>
            <div class="w-25">
                <a class="mb-3 btn btn-lg bg-secondary text-light text-uppercase {{ Request::segment(1) == "inventory" ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M3.31875 0.45C3.42354 0.310279 3.55942 0.196876 3.71563 0.118769C3.87185 0.0406632 4.0441 0 4.21875 0L13.7812 0C13.9559 0 14.1282 0.0406632 14.2844 0.118769C14.4406 0.196876 14.5765 0.310279 14.6813 0.45L17.8875 5.1C17.9605 5.19737 18 5.31579 18 5.4375V16.875C18 17.1734 17.8815 17.4595 17.6705 17.6705C17.4595 17.8815 17.1734 18 16.875 18H1.125C0.826631 18 0.540483 17.8815 0.329505 17.6705C0.118526 17.4595 0 17.1734 0 16.875V5.4375C0 5.31579 0.0394751 5.19737 0.1125 5.1L3.31875 0.45ZM8.4375 1.125H4.21875L1.6875 4.875H8.4375V1.125ZM9.5625 1.125V4.875H16.3125L13.7812 1.125H9.5625ZM16.875 6H1.125V16.875H16.875V6Z" />
                        <rect class="fill-secondary" x="3" y="8" width="5" height="7" />
                        <path class="fill-secondary" d="M10 8H15V15H10V8Z" />
                    </svg>
                    <span class="ms-2">{{ __('Inventario') }}</span>
                </a>
                <a class="mb-3 btn btn-lg bg-secondary text-light text-uppercase {{ Request::segment(1) == "inventory" ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                    <span class="ms-2">{{ __('Documenti') }}</span>
                </a>
                <a class="mb-3 btn btn-lg bg-secondary text-light text-uppercase {{ Request::segment(1) == "inventory" ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                    <span class="ms-2">{{ __('Movimenti') }}</span>
                </a>
                <a class="btn btn-lg bg-secondary text-light text-uppercase {{ Request::segment(1) == "inventory" ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                    <span class="ms-2">{{ __('Segnalazioni') }}</span>
                </a>
            </div>
        </center>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="codeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">PUNTO VENDITA UTILIZZATO</h5>
                <button type="button" class="btn-close closeb" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <center class="mb-5">
                        <button class="btn btn-lg bg-secondary text-light text-uppercase">{{ Auth::user()->note }}</button>
                    </center>
                    <center>
                        <button class="btn-close btn btn-lg bg-danger text-light text-uppercase">OK</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Function to show the modal
        function showModal() {
            $("#codeModal").modal("show");
        }
        setTimeout(showModal, 3000);
    });

    $('.btn-close').on('click', function() {
        $("#codeModal").modal("hide");
    });
</script>
@endpush
