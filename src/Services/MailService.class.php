<?php

namespace Src\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    /**
     * Envoie un e-mail de notification lorsque le compte est créé.
     * @param string $to L'adresse e-mail du destinataire.
     * @param string $token Le token de réinitialisation du mot de passe.
     * @param string $user_name Le nom de l'utilisateur.
     * 
     * @return bool True si l'e-mail a été envoyé avec succès, sinon false.
     */
    public static function sendAccountCreated($to, $token, $user_name)
    {
        $url = getenv('APP_URL');
        $reset_link = $url . "reset-mdp?email=" . urlencode($to) . "&token=" . urlencode($token);

        $img_link = $url . "assets/images/logos/logo-light-big.png";

        $text_alternative = <<<EOT
        Votre compte a été créé avec succès.

        Vous pouvez maintenant finaliser votre inscription en cliquant sur le lien ci-dessous :
        $reset_link

        L’équipe de SynapsIA
        EOT;

        $subject = 'Votre compte a été créé';
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/mails/account_created.html';
        if (file_exists($templatePath)) {
            ob_start();
            include $templatePath;
            $message = ob_get_clean();
            $message = str_replace('{{reset_link}}', $reset_link, $message);
            $message = str_replace('{{img_link}}', $img_link, $message);
            $message = str_replace('{{user_name}}', htmlspecialchars($user_name), $message);
        } else {
            $message = 'Template not found.';
        }
        return self::sendMail($to, $subject, $message, $text_alternative);
    }

    /**
     * Envoie un e-mail de réinitialisation du mot de passe.
     * @param string $to L'adresse e-mail du destinataire.
     * @param string $token Le token de réinitialisation du mot de passe.
     * 
     * @return bool True si l'e-mail a été envoyé avec succès, sinon false.
     */
    public static function sendPasswordReset($to, $token)
    {
        $url = getenv('APP_URL');
        $reset_link = $url . "reset-mdp?email=" . urlencode($to) . "&token=" . urlencode($token);

        $img_link = $url . "assets/images/logos/logo-light-big.png";

        $text_alternative = <<<EOT
        Réinitialisation du mot de passe

        Afin de réinitialiser votre mot de passe, merci de suivre le lien ci-dessous :
        $reset_link

        Ce lien est valable pendant 24 heures.

        Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet e-mail. Aucune modification ne sera apportée à votre compte sans action de votre part.

        L’équipe de SynapsIA
        EOT;

        $subject = 'Réinitialisation de votre mot de passe';
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/mails/reset_password.html';
        if (file_exists($templatePath)) {
            ob_start();
            include $templatePath;
            $message = ob_get_clean();
            $message = str_replace('{{reset_link}}', $reset_link, $message);
            $message = str_replace('{{img_link}}', $img_link, $message);
        } else {
            $message = 'Template not found.';
        }
        return self::sendMail($to, $subject, $message, $text_alternative);
    }

    /**
     * Envoie un e-mail avec PHPMailer.
     * @param string $to L'adresse e-mail du destinataire.
     * @param string $subject Le sujet de l'e-mail.
     * @param string $message Le contenu HTML de l'e-mail.
     * @param string|null $text_alternative Le contenu texte alternatif de l'e-mail.
     * 
     * @return bool True si l'e-mail a été envoyé avec succès, sinon false.
     */
    public static function sendMail($to, $subject, $message, $text_alternative = null)
    {
        $phpmailer = new PHPMailer();
        
        // Change à 2 si tu veux voir les erreurs détaillées dans tes logs
        $phpmailer->SMTPDebug = 0; 

        $phpmailer->isSMTP();
        $phpmailer->Host = getenv('SMTP_HOST');
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = getenv('SMTP_USERNAME');
        $phpmailer->Password = getenv('SMTP_PASSWORD');
        
        // --- AJUSTEMENTS POUR ORANGE ---
        $phpmailer->Port = getenv('SMTP_PORT'); 
        // Si tu utilises le port 465, Orange impose SSL
        if ($phpmailer->Port == 465) {
            $phpmailer->SMTPSecure = 'ssl';
        } else {
            $phpmailer->SMTPSecure = 'tls';
        }

        // L'adresse From doit être ton adresse Orange configurée dans le .env
        $phpmailer->setFrom(getenv('SMTP_FROM_EMAIL'), getenv('SMTP_FROM_NAME'));
        
        if (!self::validateEmail($to)) {
            error_log('Invalid recipient email address: ' . $to);
            return false;
        }
        
        $phpmailer->addAddress($to);
        $phpmailer->Subject = $subject;
        $phpmailer->Body = $message;
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->Encoding = 'base64';

        if ($text_alternative) {
            $phpmailer->AltBody = $text_alternative;
        } else {
            $phpmailer->AltBody = strip_tags($message);
        }

        if (!$phpmailer->send()) {
            error_log('Mailer Error: ' . $phpmailer->ErrorInfo);
            return false;
        }
        return true;
    }

    /**
     * Valide l'adresse e-mail.
     * @param string $email L'adresse e-mail à valider.
     * 
     * @return bool True si l'adresse e-mail est valide, sinon false.
     */
    public static function validateEmail($email)
    {
        // Validate the email format
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
?>