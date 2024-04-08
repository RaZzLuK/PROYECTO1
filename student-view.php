<?php 
require 'dbcon.php'; 
if(isset($_POST['student_id']) && !empty($_POST['student_id'])) {
    
    $student_id = $_POST['student_id'];
    
    $query = "SELECT * FROM students WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISTA DE DATOS DEL ESTUDIANTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 40px; margin-bottom: 60px;"><strong>DETALLES DEL ESTUDIANTE</strong></h5>
                    <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Nombre del Estudiante:</strong> <?= $student['nombres'] . ' ' . $student['apellidos']; ?></p>
                    <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Correo Electrónico:</strong> <?= $student['correo']; ?></p>
                    <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Teléfono/Celular:</strong> <?= $student['telefono']; ?></p>
                    <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Curso:</strong> <?= $student['curso']; ?></p>
                    <a href="index.php" class="btn btn-primary">VOLVER</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 250px;">
            <?php if (!empty($student['foto'])): ?>
                <img src="<?= $student['foto']; ?>" class="card-img-top img-fluid" style="width: 250px; height: 250px;" alt="Foto del Estudiante">
            <?php else: ?>
                <div class="card-body">
                    <p class="card-text">Foto no disponible.</p>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    } else {
        echo "<p class='card-text'>Estudiante no encontrado.</p>";
    }
}
?>
