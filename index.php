<?php
session_start();
require 'dbcon.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>CRUD ESTUDIANTES</title>
    <style>
        .btn-group > form {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>DETALLES DEL ESTUDIANTE
                            <a href="student-create.php" class="btn btn-primary float-end">AGREGAR</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
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
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>
