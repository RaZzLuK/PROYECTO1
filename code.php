<?php
session_start();
require 'dbcon.php';
function eliminarImagen($ruta) {
    if (file_exists($ruta)) {
        unlink($ruta);
    }
}
if (isset($_POST['delete_student'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);
    $query = "DELETE FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "ESTUDIANTE ELIMINADO CORRECTAMENTE.";
    } else {
        $_SESSION['message'] = "NO SE HA PODIDO ELIMINAR, INTÉNTELO NUEVAMENTE.";
    }
    header("Location: index.php");
    exit(0);
}
if (isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $nombres = mysqli_real_escape_string($con, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($con, $_POST['apellidos']);
    $correo = mysqli_real_escape_string($con, $_POST['correo']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $curso = mysqli_real_escape_string($con, $_POST['curso']);

    if (empty($nombres) || empty($apellidos) || empty($correo) || empty($telefono) || empty($curso)) {
        $_SESSION['message'] = "POR FAVOR, COMPLETE TODOS LOS CAMPOS.";
        header("Location: student-edit.php");
        exit(0);
    }
    $consulta = "SELECT telefono, correo FROM students WHERE (telefono = '$telefono' OR correo = '$correo') AND id != '$student_id'";
    $resultado = mysqli_query($con, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    if ($fila) {
        if ($fila['telefono'] == $telefono) {
            $_SESSION['message'] = "Error: EL TELÉFONO YA ESTA REGISTRADO.";
        } else {
            $_SESSION['message'] = "Error: EL CORREO ELECTRÓNICO YA ESTÁ REGISTRADO.";
        }
        header("Location: index.php");
        exit(0);
    }
    $foto_nombre = $_FILES['foto']['name'];
    $foto_temp = $_FILES['foto']['tmp_name'];

    if (!empty($foto_nombre)) {
        $permitidos = ['image/jpeg', 'image/png'];
        if (in_array($_FILES['foto']['type'], $permitidos)) {
            $ruta_destino = 'fotos/' . $foto_nombre;
            if (move_uploaded_file($foto_temp, $ruta_destino)) {
                $query_update = "UPDATE students SET foto='$ruta_destino' WHERE id='$student_id'";
                $query_run = mysqli_query($con, $query_update);

                if ($query_run) {
                    $_SESSION['message'] = "¡LISTO! DATOS DEL ESTUDIANTE ACTUALIZADO.";
                    $messageClass = 'alert-success';
                } else {
                    $_SESSION['message'] = "Error: DATOS DEL ESTUDIANTE NO ACTUALIZADO, INTÉNTELO NUEVAMENTE.";
                }
            } else {
                $_SESSION['message'] = "Error: HUBO UN PROBLEMA AL CARGAR LA IMAGEN.";
            }
        } else {
            $_SESSION['message'] = "Error: SOLO SE PERMITEN IMÁGENES JPG O PNG.";
        }
    } else {
        $query_update = "UPDATE students SET nombres='$nombres', apellidos='$apellidos', correo='$correo', telefono='$telefono', curso='$curso' WHERE id='$student_id'";
        $query_run = mysqli_query($con, $query_update);

        if ($query_run) {
            $_SESSION['message'] = "¡LISTO! DATOS DEL ESTUDIANTE ACTUALIZADO.";
            $messageClass = 'alert-success';
        } else {
            $_SESSION['message'] = "Error: DATOS DEL ESTUDIANTE NO ACTUALIZADO, INTÉNTELO NUEVAMENTE.";
        }
    }
    header("Location: index.php");
    exit(0);
}
if (isset($_POST['save_student'])) {
    $nombres = mysqli_real_escape_string($con, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($con, $_POST['apellidos']);
    $correo = mysqli_real_escape_string($con, $_POST['correo']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $curso = mysqli_real_escape_string($con, $_POST['curso']);

    $campos_faltantes = array();

    if (empty($nombres)) {
        $campos_faltantes[] = "NOMBRES";
    }
    if (empty($apellidos)) {
        $campos_faltantes[] = "APELLIDOS";
    }
    if (empty($correo)) {
        $campos_faltantes[] = "CORREO";
    }
    if (empty($telefono)) {
        $campos_faltantes[] = "TELEFONO";
    }
    if (empty($curso)) {
        $campos_faltantes[] = "CURSO";
    }
    if (empty($_FILES['foto']['name'])) {
        $campos_faltantes[] = "FOTO";
    }

    if (!empty($campos_faltantes)) {
        $_SESSION['message'] = "POR FAVOR, COMPLETE EL CAMPO " . implode(", ", $campos_faltantes);
        header("Location: student-create.php");
        exit(0);
    }
    $consulta = "SELECT telefono, correo FROM students WHERE telefono = '$telefono' OR correo = '$correo'";
    $resultado = mysqli_query($con, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    if ($fila) {
        if ($fila['telefono'] == $telefono) {
            $_SESSION['message'] = "Error: EL TÉLEFONO YA ESTÁ REGISTRADO.";
        } else {
            $_SESSION['message'] = "Error: EL CORREO ELECTRÓNICO YA ESTÁ REGISTRADO.";
        }
        header("Location: student-create.php");
        exit(0);
    }
    $foto_nombre = $_FILES['foto']['name'];
    $foto_temp = $_FILES['foto']['tmp_name'];

    if (!empty($foto_nombre)) {
        $permitidos = ['image/jpeg', 'image/png'];
        if (in_array($_FILES['foto']['type'], $permitidos)) {
            $ruta_destino = 'fotos/' . $foto_nombre;
            if (move_uploaded_file($foto_temp, $ruta_destino)) {
                $query = "INSERT INTO students (nombres, apellidos, correo, telefono, curso, foto) VALUES ('$nombres', '$apellidos', '$correo', '$telefono', '$curso', '$ruta_destino')";
                $query_run = mysqli_query($con, $query);
                if ($query_run) {
                    $_SESSION['message'] = "¡LISTO! ESTUDIANTE REGISTRADO CORRECTAMENTE.";
                } else {
                    $_SESSION['message'] = "Error: Registro de estudiante fallido, inténtelo nuevamente.";
                }
            } else {
                $_SESSION['message'] = "Error: Hubo un problema al cargar la imagen.";
            }
        } else {
            $_SESSION['message'] = "Error: SOLO SE PERMITEN IMÁGENES JPG O PNG.";
        }
    } else {
        $_SESSION['message'] = "POR FAVOR, COMPLETE TODOS LOS CAMPOS.";
    }
    header("Location: student-create.php");
    exit(0);
}
?>
