@extends('layout.master')



@section('content')

    <section class="container pb-5 ">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-sm-12 col-xs-12 ">
                    <div class="row">
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-header bg-gradient-light ">
                                    <div class="my-0 h4  text-bold d-inline-block my-1">

                                        <i class=" fas fa-tasks fa-sm "></i>

                                        <span class=""> Görevler </span> <span class=" d-none d-md-inline">

                                        </span>
                                    </div>


                                    <div class="float-right my-1 ">
                                        <a href="#" id="new-record-head-button">
                                            <button class=" btn btn-success " title="Ekle">
                                                <i class="fas fa-plus fa-lg my-0 "></i>
                                            </button>
                                        </a>
                                    </div>

                                </div>
                                <div class="card-body">


                                    <table id="tasks" class="table table-bordered table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Başlık</th>
                                                <th class="text-center w-10">Detay</th>
                                                <th class="text-center w-10">Durum</th>
                                                <th class="text-center w-10">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tasks-content">
                                            @foreach ($tasks as $task)
                                                <tr class="row1 align-items-center my-auto" id="{{ $task->id }}"
                                                    data-id={{ $task->id }}>

                                                    <td title="Sıralamak İçin Tutup Sürükleyin">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </td>

                                                    <td>
                                                        <p id="task_title_{{ $task->id }}"
                                                            class="  bg-gradient-lightblue  rounded px-2 " style="">
                                                            {{ $task->title }}
                                                        </p>
                                                    </td>

                                                    <td class="text-center p-1 ">
                                                        <p id="task_details_{{ $task->id }}">{{ $task->details }}</p>
                                                    </td>
                                                    <td class="text-center p-1  " id="status_td_id_{{ $task->id }}">
                                                        @if ($task->status == 'Pending')
                                                            <button class=" btn badge badge-warning btn-task-done"
                                                                data-task-id={{ $task->id }}
                                                                title="Görevi Tamamlamak İçin Tıklayınız">Beklemede</button>
                                                        @else
                                                            <span class="badge badge-success">Tamamlandı</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-primary btn-edit"
                                                                data-task-id="{{ $task->id }}"
                                                                data-task-title="{{ $task->title }}"
                                                                data-task-details="{{ $task->details }}"
                                                                title="Düzenle"><i class=" fa fa-edit"></i></button>
                                                            <button type="button" class="btn btn-danger btn-remove"
                                                                data-task-id="{{ $task->id }}" title="Sil"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






@section('javascript')
    <script type="text/javascript">
        var tasks_Table;
        /* Data Table  */
        $(document).ready(function() {
            tasks_table = $('#tasks').dataTable({
                "responsive": true,

                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Turkish.json"
                },
                "ordering": false,
            });


        });

        /* Update Order Operation */
        $("#tasks-content").sortable({

            items: "tr",
            cursor: 'move',
            opacity: 1,
            update: function() {
                $(".show").removeClass("show");
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {

            var order = [];
            $('tr.row1').each(function(index, element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index + 1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('task.update-order') }}",
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            });

        }

        $(document).on('click', '.btn-task-done', function() {

            var task_done_url = " {{ route('task.done') }}";
            var task_id = $(this).data("task-id");
            var status_td_id = "#status_td_id_" + task_id;

            const taskDoneSwal = Swal.mixin({
                customClass: {
                    confirmButton: '  btn  btn-info px-4  py-2 mx-1 btn-swal radius-1  ',
                    cancelButton: ' btn  btn-danger px-4  py-2 mx-1 btn-swal radius-1   '
                },
                buttonsStyling: false
            })

            taskDoneSwal.fire({
                title: 'Görev Tamamlanıyor!',
                html: 'Görevi tamamlamak istediğinizden emin misiniz? Bu işlem geri alınamaz',
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                confirmButtonText: 'Tamamla',

            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: task_done_url,
                        data: {
                            task_id: task_id,
                            _token: '{{ csrf_token() }}',

                        },

                        success: function(response) {
                            if (response.success == true) {

                                taskDoneSwal.fire({
                                    title: "Görev tamamlandı",
                                    icon: 'warning',
                                    confirmButtonText: 'Tamam',

                                });

                                $(status_td_id).append(
                                    '<span class="badge badge-success">Tamamlandı</span>');
                                $(status_td_id).find('button').remove();
                            } else {

                                taskDoneSwal.fire({
                                    title: "Görev tamamlanamadı",
                                    html: response.message,
                                    icon: 'warning',
                                    confirmButtonText: 'Tamam',

                                })

                            }
                        }
                    });




                }


            })
        });
        $(document).on('click', '.btn-remove', function() {

            var remove_url = " {{ route('task.remove') }}";
            var task_id = $(this).data("task-id");
            var row_id = "#" + task_id;



            const deleteSwal = Swal.mixin({
                customClass: {
                    confirmButton: '  btn  btn-danger px-4  py-2 mx-1 btn-swal radius-1  ',
                    cancelButton: ' btn  btn-info px-4  py-2 mx-1 btn-swal radius-1   '
                },
                buttonsStyling: false
            })

            deleteSwal.fire({
                title: 'Görev siliniyor',
                html: 'Görevi silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                confirmButtonText: 'Sil',

            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: remove_url,
                        data: {
                            task_id: task_id,
                            _token: '{{ csrf_token() }}',

                        },

                        success: function(response) {
                            if (response.success == true) {

                                deleteSwal.fire({
                                    title: "Görev silindi",
                                    icon: 'warning',
                                    confirmButtonText: 'Tamam',

                                });
                                $(row_id).remove();



                            } else {

                                deleteSwal.fire({
                                    title: "Görev Silinemedi",
                                    html: response.message,
                                    icon: 'warning',
                                    confirmButtonText: 'Tamam',

                                })

                            }
                        }
                    });




                }


            })
        });
        $(document).on('click', '#new-record-head-button', function() {
            var new_task_url = "{{ route('task.store') }}";
            Swal.fire({
                title: 'Görev Ekle',
                html: '<input type="text" id="task-title" class="swal2-input" placeholder="Görev Başlığı"><textarea  id="task-details" class="swal2-input" rows="100"  placeholder="Görev Detayını Giriniz" style="height: 300px;"></textarea>',
                confirmButtonText: 'Görevi Ekle',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                customClass: {
                    confirmButton: '  btn  btn-success px-4  py-2 mx-1 btn-swal radius-1  ',
                    cancelButton: ' btn  btn-danger px-4  py-2 mx-1 btn-swal radius-1   '
                },
                buttonsStyling: false,
                focusConfirm: false,
                preConfirm: () => {
                    const task_title = Swal.getPopup().querySelector('#task-title').value
                    const task_details = Swal.getPopup().querySelector('#task-details').value
                    if (!task_title || !task_details) {
                        Swal.showValidationMessage('Lütfen tüm alanları dolrudunuz')
                    }
                    return {
                        task_title: task_title,
                        task_details: task_details
                    }
                }
            }).then((result) => {


                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: new_task_url,
                        data: {
                            task_title: result.value.task_title,
                            task_details: result.value.task_details,
                            _token: '{{ csrf_token() }}',

                        },

                        success: function(response) {

                            if (response.success == true) {

                                Swal.fire({
                                    title: "Görev Eklendi",
                                    icon: 'success',
                                    confirmButtonText: 'Tamam',

                                }).then((result) => {

                                    location.reload();
                                });

                            } else {

                                Swal.fire({
                                    title: "Görev Eklenemedi",
                                    html: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Tamam',

                                })

                            }
                        }
                    });
                }

            })
        });
        $(document).on('click', '.btn-edit', function() {

            var task_id = $(this).data("task-id");
            var task_title = $(this).data("task-title");
            var task_details = $(this).data("task-details");
            var edit_task_url = "{{ route('task.update') }}"




            Swal.fire({
                title: 'Görevi Düzenle',
                html: '<input type="text" id="task-title" class="swal2-input"  value=" ' + task_title +
                    '" placeholder="Görev Başlığı"><textarea  id="task-details" class="swal2-input" rows="100"' +
                    ' placeholder="Görev Detayını Giriniz" style="height: 300px;"> ' +
                    task_details + '</textarea>',
                confirmButtonText: 'Kaydet',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                customClass: {
                    confirmButton: '  btn  btn-success px-4  py-2 mx-1 btn-swal radius-1  ',
                    cancelButton: ' btn  btn-danger px-4  py-2 mx-1 btn-swal radius-1   '
                },
                buttonsStyling: false,
                focusConfirm: false,
                preConfirm: () => {
                    const task_title = Swal.getPopup().querySelector('#task-title').value
                    const task_details = Swal.getPopup().querySelector('#task-details').value
                    if (!task_title || !task_details) {
                        Swal.showValidationMessage('Lütfen tüm alanları doldurunuz')
                    }
                    return {
                        task_title: task_title,
                        task_details: task_details
                    }
                }
            })
        });
    </script>
@endsection
