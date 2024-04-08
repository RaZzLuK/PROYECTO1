<?php 
require 'dbcon.php'; 

// Incluir la biblioteca TCPDF
require_once('TCPDF-main/tcpdf.php');
require_once('TCPDF-main/tcpdf_barcodes_1d.php');

if(isset($_POST['student_id']) && !empty($_POST['student_id'])) {
    
    $student_id = intval($_POST['student_id']); // Convertir el ID del estudiante a entero
    
    $query = "SELECT * FROM students WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Generar código de barras
        $barcode_content = strval($student_id); // Convertir el ID del estudiante a cadena
        
        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer metadatos del PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Author');
        $pdf->SetTitle('Código de barras');
        $pdf->SetSubject('Código de barras generado');
        $pdf->SetKeywords('TCPDF, PDF, código de barras');

        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Establecer la fuente
        $pdf->SetFont('helvetica', 'B', 12);

        // Agregar una página
        $pdf->AddPage();

        // Generar el código de barras
        $pdf->write1DBarcode($barcode_content, 'C128', '', '', '', 18, 0.4, array(), 'N');

        // Cerrar y generar PDF
        $pdf_content = $pdf->Output('barcode.pdf', 'S');

        // Mostrar datos del estudiante
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>VISTA DE DATOS DEL ESTUDIANTE</title>
            <link rel="icon" href="logos.png" type="image/png">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        </head>

        <body class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="width: 250px;">
                        <?php if (!empty($student['foto'])): ?>
                            <img src="<?= $student['foto']; ?>" class="card-img-top img-fluid" style="width: 250px; height: 250px;" alt="Foto del Estudiante">
                        <?php else: ?>
                            <div class="card-body">
                                <p class="card-text">Foto no disponible.</p>
                            </div>
                        <?php endif; ?>
                        <!-- Mostrar el código de barras generado -->
                        <embed src="data:application/pdf;base64,<?= base64_encode($pdf_content); ?>" type="application/pdf" width="250" height="100">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 40px; margin-bottom: 60px;"><strong>DETALLES DEL ESTUDIANTE</strong></h5>
                            <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>ID del Estudiante:</strong> <?= $student['id']; ?></p>
                            <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Nombre del Estudiante:</strong> <?= $student['nombres'] . ' ' . $student['apellidos']; ?></p>
                            <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Correo Electrónico:</strong> <?= $student['correo']; ?></p>
                            <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Teléfono/Celular:</strong> <?= $student['telefono']; ?></p>
                            <p class="card-text" style="font-size: 25px; margin-bottom: 40px;"><strong>Curso:</strong> <?= $student['curso']; ?></p>
                            <a href="index.php" class="btn btn-primary">VOLVER</a>
                        </div>
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


