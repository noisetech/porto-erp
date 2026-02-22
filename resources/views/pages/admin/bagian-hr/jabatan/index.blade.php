@extends('layouts.be')

@section('title', 'HR-Jabatan')
@section('content')

<style>
    label {
        margin-left: 10px;
    }

    .dt-column-title {
        text-align: left;
    }

    .dt-type-numeric {
        text-align: left !important;
    }

    th {
        font-size: 14px !important;
    }

    td {
        font-size: 14px !important;
    }
</style>

<div class="container-fluid">
    <div class="inner-contents">
        <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
            <div class="left-part">
                <h2 class="text-dark">Manajemen Jabatan</h2>
            </div>
        </div>


        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-secondary mb-1 tambah">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless text-center w-100" style="width: 100%;" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jabatan</th>
                                <th>Dapertemen</th>

                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jabatan</h5>
                <button type="button" class="btn-close TutupModalTambah"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-simpan" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="">Dapertemen:</label>
                        <select name="dapertemen" id="dapertemen" class="form-control select2-dapertemen"></select>
                        <span id="dapertemen_error" class="text-danger error-text my-2">
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan:</label>
                        <input name="jabatan" class="form-control" placeholder="Masukan nama jabatan"></input>
                        <span id="jabatan_error" class="text-danger error-text my-2">
                        </span>
                    </div>





                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm  px-22 TutupModalTambah">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm  px-2">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jabatan</h5>
                <button type="button" class="btn-close TutupModalEdit"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-update" method="post">
                    @csrf

                    <input type="hidden" name="id" class="form-control" id="id">


                    <div class="form-group">
                        <label for="">Dapertemen:</label>
                        <select name="dapertemen" id="edit-dapertemen" class="form-control select2-dapertemen"></select>
                        <span id="dapertemen_error" class="text-danger error-text my-2">
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan:</label>
                        <input name="jabatan" class="form-control" placeholder="Masukan nama jabatan" id="jabatan"></input>
                        <span id="jabatan_error" class="text-danger error-text my-2">
                        </span>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm  px-22 TutupModalEdit">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm  px-2">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            searching: false,
            serverSide: true,
            fixedHeader: true,
            responsive: true,
            autoWidth: false,
            pageLength: 5,

            order: [],
            ajax: {
                url: "{{ route('jabatan.data') }}",
                type: "get",
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },

                {
                    data: 'nama_dapertemen',
                    name: 'nama_dapertemen'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            pagingType: "full_numbers",
            lengthMenu: [5, 10, 25, 50],
            language: {
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                emptyTable: "Tidak ada data tersedia",
                lengthMenu: "Tampilkan _MENU_ data",
                search: "Cari:",
                searchPlaceholder: "Berdasrkan nama atau npm",
                paginate: {
                    first: '',
                    last: '',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>'
                }
            },
        });

        $('#form-simpan').on('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("jabatan.simpan") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data disimpan',
                            icon: 'success',
                            timer: 3000,
                        });
                        $('#modalTambah').modal('hide');
                        $('#form-simpan')[0].reset();
                        $('#dapertemen').val(null).trigger('change').empty();
                        $('#datatable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    console.log(xhr);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_error').text(value);
                        });
                    }
                }
            });
        });


    });

    $(document).on('click', '.tambah', function(e) {
        e.preventDefault();

        $('#modalTambah').modal('show');
    });

    $(document).on('click', '.TutupModalTambah', function() {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('#dapertemen').val(null).trigger('change').empty();
        $('#dapertemen_error').text('');
        $('#jabatan_error').text('');
    });


    $('#modalTambah').on('hidden.bs.modal', function(e) {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('#dapertemen').val(null).trigger('change').empty();
        $('#koder_error').text('');
        $('#nama_dapertemen_error').text('');
    });


    function initSelect2(selector, parent, route) {
        $(selector).select2({
            dropdownParent: $(parent),
            placeholder: '-- Pilih --',
            allowClear: true,
            ajax: {
                url: route,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    let data = {
                        q: params.term
                    };
                    return data;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    initSelect2('#dapertemen', '#modalTambah', "{{ route('jabatan.listDapertemen') }}");
    initSelect2('#edit-dapertemen', '#modalEdit', "{{ route('jabatan.listDapertemen') }}");

    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/dashboard/hr/jabatan/getDataById/' + id,
            method: "GET",
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalEdit').modal('show');
                $('#id').val(response.data.id);
                $('#jabatan').val(response.data.jabatan);
                let optF = new Option(response.data.dapertemen.nama_dapertemen || 'Dapertemen', response.data.dapertemen.id, true, true);
                $('#edit-dapertemen').append(optF).trigger('change');
            },
        })
    });


    $('#form-update').on('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("jabatan.update") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data diubah',
                        icon: 'success',
                        timer: 3000,
                    });
                    $('#modalEdit').modal('hide');
                    $('#form-update')[0].reset();
                    $('#dapertemen_error_edit').text('');
                    $('#jabatan_error_edit').text('');
                    $('#datatable').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '_error' + '_edit').text(value);
                    });
                }
            }
        });
    });



    $(document).on('click', '#hapus', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        Swal.fire({
            title: 'Hapus data?',
            text: "Data akan terhapus!",
            icon: 'warning',
            confirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('jabatan.hapus') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(respose) {
                        if (respose.status == 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data dihapus',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            $('#datatable').DataTable().ajax.reload();
                        }
                    },
                })
            }
        });
    });
</script>
@endpush
