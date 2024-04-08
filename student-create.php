<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>AGREGAR ESTUDIANTES</title>
    <link rel="icon" href="logos.png" type="image/png">
    <style>
        .back-btn {
            margin-right: 10px; /* Ajusta este valor según necesites */
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <?php include('message.php'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>AGREGAR ESTUDIANTE
                    <div class="btn-group float-end" role="group">
                                <button id="fullscreen-toggle" class="btn btn-primary">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </button>
                                <button id="theme-toggle" class="btn btn-primary">
                                    <i id="theme-icon" class="bi bi-moon-fill"></i>
                                </button>
                            </div>

                        <a href="index.php" class="btn btn-danger float-end back-btn">ATRÁS</a>
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
<script>
    // Función para cambiar entre temas claro y oscuro
    function toggleTheme() {
        var body = document.body;
        if (body.classList.contains('bg-light')) {
            body.classList.remove('bg-light');
            body.classList.add('bg-dark');
            document.getElementById('theme-icon').classList.remove('bi-moon-fill');
            document.getElementById('theme-icon').classList.add('bi-sun-fill');
            // Guardar preferencia de tema en la sesión
            sessionStorage.setItem('theme', 'dark');
        } else {
            body.classList.remove('bg-dark');
            body.classList.add('bg-light');
            document.getElementById('theme-icon').classList.remove('bi-sun-fill');
            document.getElementById('theme-icon').classList.add('bi-moon-fill');
            // Guardar preferencia de tema en la sesión
            sessionStorage.setItem('theme', 'light');
        }
    }

    // Función para activar la pantalla completa
    function toggleFullscreen() {
        var elem = document.documentElement;
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => {
                console.log(err.message);
            });
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    // Escucha el evento de clic en el botón de cambio de tema
    document.getElementById('theme-toggle').addEventListener('click', function() {
        toggleTheme();
    });

    // Escucha el evento de clic en el botón de pantalla completa
    document.getElementById('fullscreen-toggle').addEventListener('click', function() {
        toggleFullscreen();
    });

    // Verificar si hay preferencia de tema guardada en la sesión y aplicarla al cargar la página
    window.addEventListener('load', function() {
        var theme = sessionStorage.getItem('theme');
        if (theme === 'dark') {
            toggleTheme();
        }
    });
</script>
</body>
</html>
