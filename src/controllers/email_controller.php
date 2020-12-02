<?php

namespace Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController extends \Configs\Controller
{
  public function send($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $name = $request->getParam('name');
    $email = $request->getParam('email');
    $web_message = $request->getParam('message');
    // load .env
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // mail to visitor
    $layout = require __DIR__ . '/../templates/mails/response.php';
    $logo_url = $this->constants['static_url'] . 'assets/img/legis-mail.png';
    $img_url = $this->constants['static_url'] . 'assets/img/mail.jpeg';
    $favicon = $this->constants['static_url'] . 'favicon.ico';
    $data_layout = array(
      '%name' => $name, 
      '%email' => $email,  
      '%message' => $web_message, 
      '%logo_url' => $logo_url,
      '%img_url' => $img_url,
      '%base_url' => $this->constants['base_url'],
      '%favicon' => $favicon,
    );
    $message = str_replace(
      array_keys($data_layout), 
      array_values($data_layout), 
      $layout
    );
    //echo $message;exit();
    // do mail to visitor
    $mail = new PHPMailer(true);
    try {
      // server settings
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->Debugoutput = 'html';
      $mail->Host = $_ENV['MAIL_HOST'];
      $mail->SMTPAuth = true;
      $mail->Username = $_ENV['MAIL_USER'];
      $mail->Password = $_ENV['MAIL_PASS'];
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;
      // recipients
      $mail->setFrom($_ENV['MAIL_USER'], 'Legis Juristas');
      $mail->addAddress($email, $name);     // Add a recipient
      // content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Legis Juristas - Gracias por contactarnos';
      $mail->Body = $message;
      // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      // send
      $mail->send();
      $rpta = 'Correo enviado';
    } catch (Exception $e) {
      $rpta = json_encode(['ups', $e->getMessage()]);
      $status = 500;
    }
    // do mail to Legist
    $layout = require __DIR__ . '/../templates/mails/visitor.php';
    $message = str_replace(
      array_keys($data_layout), 
      array_values($data_layout), 
      $layout
    );
    //echo $message;exit();
    // do mail
    $mail2 = new PHPMailer(true);
    try {
      // server settings
      $mail2->SMTPDebug = 0;
      $mail2->isSMTP();
      $mail2->CharSet = 'UTF-8';
      $mail2->Debugoutput = 'html';
      $mail2->Host = $_ENV['MAIL_HOST'];
      $mail2->SMTPAuth = true;
      $mail2->Username = $_ENV['MAIL_USER'];
      $mail2->Password = $_ENV['MAIL_PASS'];
      $mail2->SMTPSecure = 'ssl';
      $mail2->Port = 465;
      // recipients
      $mail2->setFrom($_ENV['MAIL_USER'], 'Consulta desde el sitio web');
      $mail2->addAddress($_ENV['MAIL_RESPONSE'], 'Consulta del Sitio Web');     // Add a recipient
      // content
      $mail2->isHTML(true);                                  // Set email format to HTML
      $mail2->Subject = 'Consulta desde el sitio web';
      $mail2->Body = $message;
      // $mail2->AltBody = 'This is the body in plain text for non-HTML mail clients';
      // send
      $mail2->send();
      $resp = 'Correo enviado';
    } catch (Exception $e) {
      $resp = json_encode(['ups', $e->getMessage()]);
      $status = 500;
    }
    return $response->withStatus($status)->write($rpta);
  }
}
