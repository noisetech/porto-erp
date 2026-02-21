@extends('layouts.be')

@section('title', 'Kategori Aset Kantor')
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
                <h2 class="text-dark">Kategori Aset Kantor</h2>
            </div>
        </div>


        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-secondary mb-3  tambah">
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
                                <th>Kategori</th>
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
                <h5 class="modal-title">Tambah Dapertemen</h5>
                <button type="button" class="btn-close TutupModalTambah"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-simpan" method="post">
                    @csrf



                    <div class="form-group">
                        <label for="">Kategori Aset:</label>
                        <input name="kategori_aset" class="form-control"></input>
                        <span id="kategori_aset_error" class="text-danger error-text my-2">
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
                <h5 class="modal-title">Edit Dapertemen</h5>
                <button type="button" class="btn-close TutupModalEdit"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-update" method="post">
                    @csrf

                    <input type="hidden" name="id" class="form-control" id="id">


                    <div class="form-group">
                        <label for="">Kode:</label>
                        <input name="kode" id="kode" class="form-control"></input>
                        <span id="kode_error_edit" class="text-danger error-text my-2 text-sm">
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="">Dapertemen:</label>
                        <input name="nama_dapertemen" id="nama_dapertemen" class="form-control"></input>
                        <span id="nama_dapertemen_error_edit" class="text-danger error-text my-2 text-sm">
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
                url: "{{ route('master.kategori_aset.data') }}",
                type: "get",
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'kategori_aset',
                    name: 'kategori_aset'
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
                url: '{{ route("master.kategori_aset.simpan") }}',
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
        $('#fakultas').val(null).trigger('change').empty();
        $('#kode_error').text('');
        $('#nama_dapertemen_error').text('');
    });


    $('#modalTambah').on('hidden.bs.modal', function(e) {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('#fakultas').val(null).trigger('change').empty();
        $('#kode_error').text('');
        $('#nama_dapertemen_error').text('');
    });


    $(document).on('click', '.TutupModalEdit', function() {
        $('#modalEdit').modal('hide');
        $('#form-update')[0].reset();
        $('#kode_error_edit').text('');
        $('#nama_dapertemen_error_edit').text('');
    });



    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/admin/dapertemen/getDataById/' + id,
            method: "GET",
            processData: false,
            contentType: false,
            success: function(response) {

                console.log(response.data.nama_dapertemen);

                $('#modalEdit').modal('show');
                $('#id').val(response.data.id);
                $('#kode').val(response.data.kode);
                $('#nama_dapertemen').val(response.data.nama_dapertemen);
            },
        })
    });




    $('#form-update').on('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("dapertemen.update") }}',
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
                    $('#kode_error').text('');
                    $('#nama_dapertemen_error').text('');
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
                    url: "{{ route('dapertemen.hapus') }}",
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
