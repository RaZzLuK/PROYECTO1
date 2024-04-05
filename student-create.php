<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>AGREGAR ESTUDIANTES</title>
</head>
<body>

<div class="container mt-5">

    <?php include('message.php'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>AGREGAR ESTUDIANTE
                        <a href="index.php" class="btn btn-danger float-end">ATRÁS</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label>NOMBRES</label>
                            <input type="text" name="nombres" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>APELLIDOS</label>
                            <input type="text" name="apellidos" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>CORREO ELECTRÓNICO</label>
                            <input type="email" name="correo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>TELÉFONO/CELULAR</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>CURSO</label>
                            <input type="text" name="curso" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>FOTO</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="save_student" class="btn btn-primary">GUARDAR</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
