<?php
session_start();
require 'dbcon.php';
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>EDICIÓN DE DATOS DEL ESTUDIANTE</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>EDITAR ESTUDIANTE
                            <a href="index.php" class="btn btn-danger float-end">ATRÁS</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM students WHERE id='$student_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="student_id" value="<?= $student['id']; ?>">

                                    <div class="mb-3">
                                        <label>NOMBRES DEL ESTUDIANTE</label>
                                        <input type="text" name="nombres" value="<?=$student['nombres'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>APELLIDOS DEL ESTUDIANTE</label>
                                        <input type="text" name="apellidos" value="<?=$student['apellidos'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>CORREO DEL ESTUDIANTE</label>
                                        <input type="email" name="correo" value="<?=$student['correo'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>TELEFONO DEL ESTUDIANTE</label>
                                        <input type="text" name="telefono" value="<?=$student['telefono'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>CURSO DEL ESTUDIANTE</label>
                                        <input type="text" name="curso" value="<?=$student['curso'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>FOTO DEL ESTUDIANTE</label>
                                        <input type="file" name="foto" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="update_student" class="btn btn-primary">
                                            ACTUALIZAR
                                        </button>
                                    </div>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>NO SE ENCONTRÓ EL ID</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
