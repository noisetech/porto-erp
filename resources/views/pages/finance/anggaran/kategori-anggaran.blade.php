@extends('layouts.be')

@section('title', 'Kategori Anggaran')
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
                <h2 class="text-dark">Kategori Anggaran</h2>
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
                                <th>Nama</th>
                                <th>Aktif</th>
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
                <h5 class="modal-title">Tambah Kategori Anggaran</h5>
                <button type="button" class="btn-close TutupModalTambah"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-simpan" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Kategori:</label>
                                <input name="kode_kategori" class="form-control" placeholder="Masukan kode kategori"></input>
                                <span id="kode_kategori_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Kategori:</label>
                                <input name="nama_kategori" class="form-control" placeholder="Masukan nama kategori"></input>
                                <span id="nama_kategori_error" class="text-danger error-text my-2">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Keterangan:</label>
                        <textarea name="keterangan" class="form-control" style="height: 200px !important;" placeholder="Masukan keterangan" id=""></textarea>
                        <span id="keterangan_error" class="text-danger error-text my-2">
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
                url: "{{ route('finance.kategori_anggaran.data') }}",
                type: "get",
            },
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'kode_kategori',
                    name: 'kode_kategori'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori'
                },
                {
                    data: 'aktif',
                    name: 'aktif'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
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
                lengthMenu: "Tampilkan _MENU_",
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



        $(document).on('click', '.tambah', function(e) {
            e.preventDefault();

            $('#modalTambah').modal('show');
        });


        $('#form-simpan').on('submit', function(e) {

            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("finance.kategori_anggaran.simpan") }}',
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
                        url: "{{ route('finance.kategori_anggaran.hapus') }}",
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


    });
</script>
@endpush
