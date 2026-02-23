@extends('layouts.be')

@section('title', 'Chart Of Account')
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

    #datatable_filter {
        margin-right: 50px !important;
    }

    .paginate_button .last {
        display: none !important;
    }
</style>

<div class="container-fluid">
    <div class="inner-contents">
        <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
            <div class="left-part">
                <h2 class="text-dark">Chart Of Account </h2>
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
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Kelompok</th>
                                <th>Induk</th>
                                <th>Aktif</th>
                                <th>Posting</th>
                                <th>Keterangan</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah COA</h5>
                <button type="button" class="btn-close TutupModalTambah"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-simpan" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Kode Akun:</label>
                                <input name="kode_akun" class="form-control"></input>
                                <span id="kode_akun_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Akun:</label>
                                <input name="nama_akun" class="form-control"></input>
                                <span id="nama_akun_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Keterangan:</label>
                                <input name="keterangan" class="form-control"></input>
                                <span id="keterangan_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="">Jenis Akun</label>
                            <select name="jenis_akun" class="form-control form-select">
                                <option value="">--Pilih-</option>
                                <option value="aset">Aset</option>
                                <option value="kewajiban">Kewajiban</option>
                                <option value="modal">Modal</option>
                                <option value="pendapatan">Pendapatan</option>
                                <option value="beban">Beban</option>
                            </select>
                            <span id="jenis_akun_error" class="text-danger error-text my-2">
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="">Kelompok Akun</label>
                            <select name="kelompok_akun" id="kelompok-akun" class="form-control select2-kompok-akun">
                            </select>
                            <span id="kelompok_akun_error" class="text-danger error-text my-2">
                            </span>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">Boleh Posting:</label>
                            <select name="boleh_posting" class="form-control form-select" id="">
                                <option value="">--Pilih--</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Akun Induk</label>
                            <select id="induk-akun-coa" name="akun_induk" class="form-control select2-induk-akun-coa">
                                <option value="">--Pilih-</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-danger btn-sm  px-22 TutupModalTambah">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm  px-2">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Chart Of Account</h5>
                <button type="button" class="btn-close TutupModalEdit"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-update" method="post">
                    @csrf
                    <input type="hidden" name="id" class="form-control" id="id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Kode Akun:</label>
                                <input name="kode_akun" class="form-control" id="kode_akun"></input>
                                <span id="kode_akun_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Akun:</label>
                                <input name="nama_akun" class="form-control" id="nama_akun"></input>
                                <span id="nama_akun_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Keterangan:</label>
                                <input name="keterangan" class="form-control" id="keterangan"></input>
                                <span id="keterangan_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="">Jenis Akun</label>
                            <select name="jenis_akun" class="form-control form-select" id="jenis_akun">
                                <option value="">--Pilih-</option>
                                <option value="aset">Aset</option>
                                <option value="kewajiban">Kewajiban</option>
                                <option value="modal">Modal</option>
                                <option value="pendapatan">Pendapatan</option>
                                <option value="beban">Beban</option>
                            </select>
                            <span id="jenis_akun_error" class="text-danger error-text my-2">
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="">Kelompok Akun</label>
                            <select name="kelompok_akun" id="edit-kelompok-akun" class="form-control select2-kompok-akun">
                            </select>
                            <span id="kelompok_akun_error" class="text-danger error-text my-2">
                            </span>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">Boleh Posting:</label>
                            <select name="boleh_posting" class="form-control form-select" id="boleh_posting_edit">
                                <option value="">--Pilih--</option>
                                <option value="1">ya</option>
                                <option value="0">tidak</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Akun Induk</label>
                            <select id="edit-induk-akun-coa" name="akun_induk" class="form-control select2-induk-akun-coa">
                                <option value="">--Pilih-</option>
                            </select>
                        </div>
                    </div>


                    <div class="modal-footer mt-5">
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

        $('#form-simpan').on('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("coa.simpan") }}',
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
                        $('.select2-kompok-akun, .select2-induk-akun-coa').val(null).trigger('change');
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

        $('#datatable').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            fixedHeader: true,
            responsive: true,
            autoWidth: false,
            pageLength: 5,
            order: [],
            ajax: {
                url: "{{ route('coa.data') }}",
                type: "get",
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'kode_akun',
                    name: 'kode_akun',
                    orderable: false
                },
                {
                    data: 'nama_akun',
                    name: 'nama_akun',
                    orderable: false
                },
                {
                    data: 'jenis_akun',
                    name: 'jenis_akun',
                    orderable: false
                },
                {
                    data: 'kelompok_akun',
                    name: 'kelompok_akun',
                    orderable: false
                },
                {
                    data: 'induk_akun',
                    name: 'induk_akun',
                    orderable: false
                },
                {
                    data: 'aktif',
                    name: 'aktif',
                    orderable: false
                },
                {
                    data: 'posting',
                    name: 'posting',
                    orderable: false
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    orderable: false
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false
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
                lengthMenu: "Tampilkan _MENU_",
                search: "Cari:",
                searchPlaceholder: "silahkan cari data",
                paginate: {
                    first: '',
                    last: '',
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>'
                }
            },
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

        initSelect2('#induk-akun-coa', '#modalTambah', "{{ route('coa.listAkunIndukCoa') }}");
        initSelect2('#kelompok-akun', '#modalTambah', "{{ route('coa.listKelompokAkun') }}");
        initSelect2('#edit-induk-akun-coa', '#modalEdit', "{{ route('coa.listAkunIndukCoa') }}");
        initSelect2('#edit-kelompok-akun', '#modalEdit', "{{ route('coa.listKelompokAkun') }}");
    });

    $(document).on('click', '.tambah', function(e) {
        e.preventDefault();

        $('#modalTambah').modal('show');
    });

    $(document).on('click', '.TutupModalTambah', function() {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('.select2-kompok-akun, .select2-induk-akun-coa').val(null).trigger('change');
        $('#kode_error').text('');
        $('#kode_akun_error').text('');
        $('#nama_akun_error').text('');
        $('#kelompok_akun_error').text('');
        $('#keterangan_error').text('');
        $('#jenis_akun_error').text('');
    });


    $('#modalTambah').on('hidden.bs.modal', function(e) {
        $('#modalTambah').modal('hide');
        $('#form-simpan')[0].reset();
        $('.select2-kompok-akun, .select2-induk-akun-coa').val(null).trigger('change');
        $('#kode_error').text('');
        $('#kode_akun_error').text('');
        $('#nama_akun_error').text('');
        $('#kelompok_akun_error').text('');
        $('#keterangan_error').text('');
        $('#jenis_akun_error').text('');
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
            url: '/dashboard/finance/coa/getDayaById/' + id,
            method: "GET",
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalEdit').modal('show');
                $('#id').val(response.data.id);
                $('#kode_akun').val(response.data.kode_akun);
                $('#nama_akun').val(response.data.nama_akun);
                $('#keterangan').val(response.data.keterangan);
                $('#jenis_akun').val(response.data.jenis_akun);
                $('#boleh_posting_edit').val(response.data.boleh_posting ? '1' : '0');
                let optKelompokAkun = new Option(response.data.kode_kelompok || '--Pilih--', response.data.kelompok_akun_coa_id, true, true);
                $('#edit-kelompok-akun').append(optKelompokAkun).trigger('change');
                let optIndukAkun = new Option(response.data.induk_akun || '--Pilih--', response.data.akun_induk_id, true, true);
                $('#edit-induk-akun-coa').append(optIndukAkun).trigger('change');
            },
        })
    });

    $('#form-update').on('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("coa.update") }}',
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
                    url: "{{ route('coa.hapus') }}",
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
