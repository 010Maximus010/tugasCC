@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        
    </main>
</div>
<!-- modal edit khs -->
<div class="modal fade" data-bs-backdrop="static" data-keyboard="false" id="editKHS" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit KHS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnClose" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="showModalKHS">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/js/javascript-ajax.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>

<!-- Load FilePond library -->
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@4.17.1/dist/filepond.js"></script>

<!-- Turn all file input elements into ponds -->
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize
    );
    FilePond.create(document.getElementById('file'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });

    // Send the files to the Controller
    FilePond.setOptions({
        server: {
            url: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
</script>

<script type="text/javascript">
    // data-bs-dismiss="modal" click reload page
    $('button[data-bs-dismiss="modal"]').click(function() {
        location.reload();
    });

    $(document).on("click", "#buttonModalKHS", function() {
        event.preventDefault();
        let href = $(this).attr("data-attr");
        $.ajax({
            url: href,
            // return the result
            success: function(result) {
                $("#editKHS").modal("show");
                $("#showModalKHS").html(result).show();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
            },
        });
    });
</script>

@stop