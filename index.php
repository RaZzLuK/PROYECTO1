<?php
session_start();
require 'dbcon.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD ESTUDIANTES</title>
    <link rel="icon" href="logos.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        .btn-group > form {
            margin-right: 8px;
        }

        .dt-buttons {
            padding-bottom: 10px;
        }

        .buttons-excel, .buttons-pdf {
            margin-right: 5px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>
                            <div class="d-flex justify-content-between align-items-center">
                                DETALLES DEL ESTUDIANTE
                                <div>
                                    <a href="student-create.php" class="btn btn-light">AGREGAR</a>
                                    <button id="fullscreen-toggle" class="btn btn-primary ms-2">
                                        <i class="bi bi-arrows-fullscreen"></i>
                                    </button>
                                    <button id="theme-toggle" class="btn btn-primary ms-2">
                                        <i id="theme-icon" class="bi bi-moon-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRES</th>
                                    <th>APELLIDOS</th>
                                    <th>CORREO</th>
                                    <th>TELEFONO</th>
                                    <th>CURSO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM students";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $student)
                                        {
                                            echo '<tr>';
                                            echo '<td>' . $student['id'] . '</td>';
                                            echo '<td>' . $student['nombres'] . '</td>';
                                            echo '<td>' . $student['apellidos'] . '</td>';
                                            echo '<td>' . $student['correo'] . '</td>';
                                            echo '<td>' . $student['telefono'] . '</td>';
                                            echo '<td>' . $student['curso'] . '</td>';
                                            echo '<td>';
                                            echo '<div class="btn-group" role="group">';
                                            echo '<form action="student-view.php" method="post" class="d-inline">';
                                            echo '<input type="hidden" name="student_id" value="' . $student['id'] . '">';
                                            echo '<button type="submit" class="btn btn-info btn-sm">VER</button>';
                                            echo '</form>';
                                            echo '<form action="student-edit.php" method="POST" class="d-inline">';
                                            echo '<input type="hidden" name="student_id" value="' . $student['id'] . '">';
                                            echo '<button type="submit" class="btn btn-success btn-sm">EDITAR</button>';
                                            echo '</form>';
                                            echo '<form action="code.php" method="POST" class="d-inline">';
                                            echo '<input type="hidden" name="delete_student" value="' . $student['id'] . '">';
                                            echo '<button type="submit" class="btn btn-danger btn-sm">ELIMINAR</button>';
                                            echo '</form>';
                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="7">No hay estudiantes registrados.</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                dom: 'Blfrtip', // Botones en la parte inferior izquierda
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        },
                        className: 'btn btn-success' // Clase de Bootstrap para el botón de Excel
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        },
                        className: 'btn btn-danger' // Clase de Bootstrap para el botón de PDF
                    }
                ]
            });

            $('#theme-toggle').on('click', function() {
                toggleTheme();
            });

            $('#fullscreen-toggle').on('click', function() {
                toggleFullscreen();
            });

            function toggleTheme() {
                if ($('body').hasClass('bg-light')) {
                    $('body').removeClass('bg-light').addClass('bg-dark');
                    $('#theme-icon').removeClass('bi-moon-fill').addClass('bi-brightness-high');
                } else {
                    $('body').removeClass('bg-dark').addClass('bg-light');
                    $('#theme-icon').removeClass('bi-brightness-high').addClass('bi-moon-fill');
                }
            }

            function toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            }
        });
    </script>
</body>
</html>

