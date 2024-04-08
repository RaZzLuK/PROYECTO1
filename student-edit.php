<?php 
require 'dbcon.php'; 

$message = '';
$messageClass = '';

if(isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $curso = $_POST['curso'];

    // Verificar campos vacíos
    if (empty($nombres)) {
        $message = "POR FAVOR, RELLENA EL CAMPO 'NOMBRES'.";
        $messageClass = 'alert-danger';
    } elseif (empty($apellidos)) {
        $message = "POR FAVOR, RELLENA EL CAMPO 'APELLIDOS'.";
        $messageClass = 'alert-danger';
    } elseif (empty($correo)) {
        $message = "POR FAVOR, RELLENA EL CAMPO 'CORREO'.";
        $messageClass = 'alert-danger';
    } elseif (empty($telefono)) {
        $message = "POR FAVOR, RELLENA EL CAMPO 'TELEFONO'.";
        $messageClass = 'alert-danger';
    } elseif (empty($curso)) {
        $message = "POR FAVOR, RELLENA EL CAMPO 'CURSO'.";
        $messageClass = 'alert-danger';
    } else {
        $query = "SELECT * FROM students WHERE (correo = ? OR telefono = ?) AND id != ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssi", $correo, $telefono, $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['correo'] == $correo && $row['telefono'] == $telefono) {
                $message = "Error: EL CORREO ELECTRÓNICO Y EL TELÉFONO YA ESTÁN REGISTRADOS.";
            } elseif ($row['correo'] == $correo) {
                $message = "Error: EL CORREO ELECTRÓNICO YA ESTÁ REGISTRADO.";
            } elseif ($row['telefono'] == $telefono) {
                $message = "Error: EL TELÉFONO YA ESTÁ REGISTRADO";
            }
            $messageClass = 'alert-danger';
        } else {
            $query = "UPDATE students SET nombres=?, apellidos=?, correo=?, telefono=?, curso=? WHERE id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $nombres, $apellidos, $correo, $telefono, $curso, $student_id);
            if ($stmt->execute()) {
                $message = "¡LISTO! DATOS DEL ESTUDIANTE ACTUALIZADOS CORRECTAMENTE.";
                $messageClass = 'alert-success';
            } else {
                $message = "Error: No se pudieron actualizar los datos del estudiante.";
                $messageClass = 'alert-danger';
            }

            if (!empty($_FILES['foto']['name'])) {
                $foto_nombre = $_FILES['foto']['name'];
                $foto_temp = $_FILES['foto']['tmp_name'];
                $ruta_destino = 'fotos/' . $foto_nombre;
                if (move_uploaded_file($foto_temp, $ruta_destino)) {
                    $query_update_foto = "UPDATE students SET foto=? WHERE id=?";
                    $stmt_update_foto = $con->prepare($query_update_foto);
                    $stmt_update_foto->bind_param("si", $ruta_destino, $student_id);
                    $stmt_update_foto->execute();
                }
            }
        }
    }
}

if(isset($_POST['student_id']) && !empty($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    $query = "SELECT * FROM students WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $message = "Estudiante no encontrado.";
        $messageClass = 'alert-danger';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDICIÓN DE DATOS DEL ESTUDIANTE</title>
    <link rel="icon" href="logos.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Agregamos la librería de iconos Bootstrap -->
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php if(!empty($message)) { ?>
            <div class="alert <?php echo $messageClass; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>EDITAR ESTUDIANTE
                            <div class="btn-group float-end" role="group">
                                <button id="fullscreen-toggle" class="btn btn-primary">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </button>
                                <button id="theme-toggle" class="btn btn-primary">
                                    <i id="theme-icon" class="bi bi-moon-fill"></i>
                                </button>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="student-edit.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="student_id" value="<?= $student['id']; ?>">
                            <div class="mb-3">
                                <label>NOMBRES DEL ESTUDIANTE</label>
                                <input type="text" name="nombres" value="<?= $student['nombres']; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>APELLIDOS DEL ESTUDIANTE</label>
                                <input type="text" name="apellidos" value="<?= $student['apellidos']; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>CORREO DEL ESTUDIANTE</label>
                                <input type="email" name="correo" value="<?= $student['correo']; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>TELEFONO DEL ESTUDIANTE</label>
                                <input type="text" name="telefono" value="<?= $student['telefono']; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>CURSO DEL ESTUDIANTE</label>
                                <input type="text" name="curso" value="<?= $student['curso']; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>FOTO DEL ESTUDIANTE</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="update_student" class="btn btn-primary">ACTUALIZAR</button>
                                <a href="index.php" class="btn btn-danger">CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para cambiar entre temas claro y oscuro
        function toggleTheme() {
            var body = document.body;
            if (body.classList.contains('bg-light')) {
                body.classList.remove('bg-light');
                body.classList.add('bg-dark');
                document.getElementById('theme-icon').classList.remove('bi-moon-fill');
                document.getElementById('theme-icon').classList.add('bi-brightness-high');
            } else {
                body.classList.remove('bg-dark');
                body.classList.add('bg-light');
                document.getElementById('theme-icon').classList.remove('bi-brightness-high');
                document.getElementById('theme-icon').classList.add('bi-moon-fill');
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
    </script>
</body>
</html>

