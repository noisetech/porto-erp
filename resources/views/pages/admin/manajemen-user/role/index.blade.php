@extends('layouts.be')

@section('title', 'Role')
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
                <h2 class="text-dark">Manajemen Role</h2>
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
                                <th>Role</th>
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
                <h5 class="modal-title">Tambah Role</h5>
                <button type="button" class="btn-close TutupModalTambah"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-simpan" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="">Role:</label>
                        <input name="role" class="form-control" placeholder="Masukan role"></input>
                        <span id="role_error" class="text-danger fs-10 error-text my-2 text-sm">

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
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="btn-close TutupModalEdit"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-update" method="post">
                    @csrf

                    <input type="hidden" name="id" class="form-control" id="id_jurusan">

                    <div class="form-group">
                        <label for="">Role:</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan role" id="namaEdit">
                        <span id="nama_error_edit" class="text-danger fs-10 error-text my-2 text-sm">

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
            pageLength: 10,

            order: [],
            ajax: {
                url: "{{ route('role.data') }}",
                type: "get",
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'role',
                    name: 'role'
                },

                {
                    data: 'action',
                    name: 'action'
                },
            ],
            pagingType: "full_numbers",
            lengthMenu: [5, 10, 25, 50],
            language: {
                paginate: {
                    first: '',
                    last: '',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>'
                }
            }
        });

        $('#form-simpan').on('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '/admin/role/simpan',
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
        $('#fakultas_error').text('');
        $('#jurusan_error').text('');
    });


    $('#modalTambah').on('hidden.bs.modal', function(e) {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('#fakultas').val(null).trigger('change').empty();
        $('#fakultas_error').text('');
        $('#jurusan_error').text('');
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
                    url: "{{ route('role.hapus') }}",
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
