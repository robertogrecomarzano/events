<?php

/**
 * Classe per l'invio delle email, utilizza la libreria PHPMailier
 *
 * @author Roberto
 *
 */
class Mail
{

    /**
     * Invio email attraverso l'uso della libreria PHPMailer
     *
     * @param string $toEmail
     * @param string $subject
     * @param string $message
     * @param string $messageHtml
     * @param array $filename
     * @param array $options
     *
     * @return array
     */
    static function sendPHPMailer($toEmail, $subject, $message, $messageHtml = null, $filename = [], $options = [])
    {
        if (! Config::$config["mail"]) {
            $page = Page::getInstance();
            $page->addWarning(Language::get("EMAIL_SEND_DISABLED"));
            return array(
                'SUCCESS' => 'FALSE',
                "ERROR" => Language::get("EMAIL_SEND_DISABLED")
            );
        }

        $mail = new PHPMailer();

        if (! empty(Config::$config["smtp_debug"])) {
            $mail->SMTPDebug = Config::$config["smtp_debug"];
            $debug = null;
            $mail->Debugoutput = function ($str, $level) use (&$debug) {
                $debug .= "$level: $str\n";
            };
        }
        
        if (Config::$config["smtp"]) {
            $mail->IsSMTP();
            $mail->SMTPAuth = Config::$config["smtp_auth"]; // abilita autenticazione SMTP
            $mail->SMTPKeepAlive = true;

            $mail->Host = Config::$config["smtp_server"];
            $mail->Hostname = Config::$config["smtp_server"];
            $mail->Username = Config::$config["smtp_user"]; // utente server SMTP autenticato
            $mail->Password = Config::$config["smtp_password"]; // password server SMTP autenticato
            $mail->Port = Config::$config["smtp_port"]; // porta server SMTP autenticato

            if (Config::$config["smtp_secure"]) {
                $mail->SMTPSecure = Config::$config["smtp_secure_type"];
                $mail->SMTPAutoTLS = true;
            } else {
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }
        }

        $mail->Sender = Config::$config["email"];
        $mail->From = Config::$config["email"];
        $mail->FromName = Config::$config["denominazione"];
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->CharSet = "UTF-8";

        if (! empty($options["bcc"]))
            $mail->addBCC($options["bcc"]);

        if (! empty($messageHtml)) {
            $mail->MsgHTML($messageHtml);
            $mail->AltBody = "Per poter leggere correttamente questo messaggio è indispensabile che il tuo client di posta elettronica sia abilitato per l'html";
        }

        if (! empty($filename))
            foreach ($filename as $file)
                $mail->AddAttachment($file);

        $mail->AddAddress($toEmail);

        $ret = $mail->Send();

        if ($ret)
            return array(
                'SUCCESS' => 'TRUE'
            );
        else {
            return array(
                'SUCCESS' => 'FALSE',
                "ERROR" => $mail->ErrorInfo,
                "DEBUG"=>$debug
            );
        }
    }
}
