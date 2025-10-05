<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper {
    public static function sendPasswordResetEmail($recipientEmail, $recipientName, $token) {
        $mail = new PHPMailer(true);
        try {
            // Configuración del Servidor (Gmail SMTP)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'chonojorge6@gmail.com'; 
            $mail->Password   = 'jsgxxzrsrrjfvdqh'; // Contraseña de Aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465; 
            $mail->CharSet    = 'UTF-8';

            // Remitente
            $mail->setFrom('chonojorge6@gmail.com', 'Sistema SysWeb'); 
            $mail->addAddress($recipientEmail, $recipientName); 
            
            // 1. CREACIÓN DEL ENLACE DE RESTABLECIMIENTO           
            $resetLink = 'http://localhost/sysweb/index.php?controller=Login&action=showResetForm&token=' . urlencode($token);
            
            // 2. CONTENIDO DEL CORREO
            $mail->isHTML(true); // Indica que el cuerpo es HTML
            $mail->Subject = 'Recuperación de Contraseña para SysWeb';
            
            // Llama a la función que genera el cuerpo HTML
            $mail->Body    = self::getResetEmailBody($recipientName, $resetLink);
            
            // Texto plano de respaldo (buena práctica)
            $mail->AltBody = "Hola {$recipientName},\n\nHas solicitado restablecer tu contraseña. Copia y pega el siguiente enlace: {$resetLink}\n\nSi no solicitaste esto, ignora este correo.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
            return false;
        }
    }
    
    //Genera el cuerpo del correo en formato HTML.     
    private static function getResetEmailBody($name, $link) {
        return "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto;'>
                <h2 style='color: #1A7595;'>Restablecer tu Contraseña</h2>
                <p>Hola <strong>{$name}</strong>,</p>
                <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta SysWeb. Haz clic en el siguiente botón:</p>
                <p style='text-align: center; margin: 30px 0;'>
                    <a href='{$link}' style='background-color: #1A7595; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;'>
                        Restablecer Contraseña
                    </a>
                </p>
                <p>Si no puedes hacer clic en el botón, copia y pega este enlace en tu navegador:</p>
                <p style='font-size: 0.9em; word-break: break-all;'><a href='{$link}'>{$link}</a></p>
                <p>Este enlace es válido solo por 1 hora. Si no solicitaste este cambio, puedes ignorar este correo.</p>
                <hr style='border: 0; border-top: 1px solid #eee;'>
                <p style='font-size: 0.8em; color: #666;'>Atentamente, El equipo de SysWeb.</p>
            </div>
        ";
    }
}