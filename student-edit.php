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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>EDICIÓN DE DATOS DEL ESTUDIANTE</title>
</head>
<body>
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
</body>
</html>
