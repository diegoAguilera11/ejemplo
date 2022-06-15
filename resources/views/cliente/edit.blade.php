@extends('layouts.plantilla_clientes')

@section('contenido')
    <div class="container">
        <div class="table-wrapper">

            <div class="table-title">
                <br>
                <div class="row justify-content-between">

                    <div class="col-sm-4">
                        <h2>Administrar <b>Solicitudes</b><a href="/home" class="btn btn-return"><span>Volver</span></a></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nº Solicitud</th>
                        <th>Fecha y Hora Solicitud</th>
                        <th>Estado</th>
                        <th>Estilista</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($solicituds as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td>{{ $solicitud->fecha_solicitud }} - {{ $solicitud->hora_solicitud }}</td>
                            <td>{{ $solicitud->estado }}</td>

                            @if ($solicitud->estilista_id)
                                <td>{{ App\Models\User::getUserNameById($solicitud->estilista_id) }}</td>
                                {{-- <td>
                                    <a href="" class="edit"><i class="fa-solid fa-comment-dots"></i></a>
                                </td> --}}
                            @else
                                <td>-</td>
                                <a href="" class="edit"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            @endif

                            @if ($solicitud->estado == 'INGRESADA')
                                <td>
                                    <form class="formularioAnular" method="GET" data-toggle="tooltip" data-placement="top"
                                        title="Anula la Solicitud"
                                        action="{{ route('anularSolicitud', ['id' => $solicitud->id]) }}">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                            <center><img src="images/trash.png" with="20" height="20"
                                                    class="d-inline-block align-text-top"></center>
                                        </button>
                                    </form>
                                </td>
                            @endif
                            @if ($solicitud->estado == 'ATENDIDA A TIEMPO' || $solicitud->estado == 'ATENDIDA CON RETRASO')
                                <td>
                                    @if ($solicitud->comentario == '')
                                        <form class="formulario" method="GET" data-toggle="tooltip" data-placement="top"
                                            title="Agrega un Comentario"
                                            action="{{ route('agregar_comentario', ['id' => $solicitud->id]) }}">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                                <center><img src="images/comment.png" with="20" height="20"
                                                        class="d-inline-block align-text-top"></center>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif

                        </tr>
                    @empty

                        <tr>
                            <td colspan="6" class="text-center">No hay solicitudes por mostrar</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>



    </div>

    </div>
    @if ($solicituds->links())
        <div class="d-flex justify-content-center">
            {!! $solicituds->links() !!}
        </div>
    @endif

    <script>
        const formularios = document.getElementsByClassName("formulario");

        for (const form of formularios) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Agrega un Comentario',
                    input: 'textarea',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4DD091',
                    cancelButtonColor: '#FF5C77',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        }
    </script>


    <script>
        const formulariosPlus = document.getElementsByClassName("formularioAnular");

        for (const form of formulariosPlus) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro que quieres Anular la solicitud?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4DD091',
                    cancelButtonColor: '#FF5C77',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        }
    </script>

    {{-- <script>
    $(function() {

        $('#nuevoComentario').modal({
            backdrop = 'static'
        });
    });
</script> --}}
@endsection
