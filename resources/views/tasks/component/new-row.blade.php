     <tr class="row1 align-items-center my-auto" id="{{ $task->id }}"
                                                    data-id={{ $task->id }}>

                                                    <td title="Sıralamak İçin Tutup Sürükleyin">
                                                        <i class="fas fa-arrows-alt"></i>
                                                    </td>

                                                    <td>
                                                        <p  id="task_title_{{$task->id}}" class="  bg-gradient-lightblue  rounded px-2 " style="">
                                                            {{ $task->title }}
                                                        </p>
                                                    </td>

                                                    <td class="text-center p-1 ">
                                                        <p id="task_details_{{$task->id}}">{{ $task->details}}</p>
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