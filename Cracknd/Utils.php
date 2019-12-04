<?php
namespace Cracknd;

class Utils{
    public static function debug($enabled = true){
        if($enabled){
            ini_set('display_errors', 1);
            return true;
        } else {
            ini_set('display_errors', 0);
            return false;
        }
    }

    public static function send_email($emails_to, $subject, $template, $keystoreplace = null, $attachments = null, $from = null, $emails_cc = null, $emails_bcc = null){
        try{
            if(SENDGRID_ENABLED){
                $sendgrid = new \SendGrid(SENDGRID_API_KEY);
                $email = new \SendGrid\Mail\Mail();
                if(!empty($from))
                    $email->setFrom($from['email'], $from['name']);
                else
                    $email->setFrom(SENDGRID_FROM_EMAIL, SENDGRID_FROM_NAME);
                if(!SENDGRID_DEBUG)
                    foreach ($emails_to as $to)
                        $email->addTo($to);
                else
                    foreach (SENDIGRD_DEBUG_EMAILS as $to)
                        $email->addTo($to);
                foreach ($emails_cc as $cc)
                    $email->addCc($cc);
                foreach ($emails_bcc as $bcc)
                    $email->addBcc($bcc);
                if(!empty($keystoreplace)){
                    $template_html = file_get_contents(storage_path("mails/$template.html"));
                    foreach ($keystoreplace as $key => $content)
                        $template_html = str_replace("@$key@", $content, $template_html);
                }

                $email->setSubject($subject);
                $email->addContent('text/html', $template_html);
                $response = $sendgrid->send($email);
                return ['status' => true, 'message' => $response];
            } else
                $response = ['status' => false, 'message' => 'Envío de notificaciones: deshabilitado'];
        } catch (\Exception $exception){
            $response = ['status' => false, 'message' => $exception->getMessage()];
        }
        return $response;
    }
}