<?php
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

    <title>VISTA DE DATOS DEL ESTUDIANTE</title>
</head>
<body>

<div class="container mt-5">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>DETALLES DEL ESTUDIANTE
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

                                <div class="mb-3">
                                    <label>NOMBRES DEL ESTUDIANTE</label>
                                    <p class="form-control">
                                        <?=$student['nombres'];?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>APELLIDOS DEL ESTUDIANTE</label>
                                    <p class="form-control">
                                        <?=$student['apellidos'];?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>CORREO DEL ESTUDIANTE</label>
                                    <p class="form-control">
                                        <?=$student['correo'];?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>TELEFONO DEL ESTUDIANTE</label>
                                    <p class="form-control">
                                        <?=$student['telefono'];?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>CURSO DEL ESTUDIANTE</label>
                                    <p class="form-control">
                                        <?=$student['curso'];?>
                                    </p>
                                </div>
                                <div class="mb-3 text-center">
                                    <label>FOTO DEL ESTUDIANTE</label>
                                    <div class="d-flex justify-content-center">
                                        <img src="<?=$student['foto'];?>" class="img-thumbnail custom-img" style="width: 250px; height: 250px;">
                                    </div>
                                </div>

                            <?php
                        }
                        else
                        {
                            echo "<h4>ESTUDIANTE NO ENCONTRADO</h4>";
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
