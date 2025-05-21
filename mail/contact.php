<?php
//if (
   // empty($_POST['name']) ||
   // empty($_POST['email']) ||
   // empty($_POST['phone']) ||
   // empty($_POST['business_type']) ||
   /// !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
//) {
    http_response_code(500);
    exit();
//}

//$name = strip_tags(htmlspecialchars($_POST['name']));
//$email = strip_tags(htmlspecialchars($_POST['email']));
//$phone = strip_tags(htmlspecialchars($_POST['phone']));
//$business_type = strip_tags(htmlspecialchars($_POST['business_type']));

//$to = "contato@cafekamaro.com.br"; // Alterar para o e-mail real
//$subject = "Nova Solicitação de Orçamento - Café Kamaro";
//$body = "Você recebeu uma nova solicitação de orçamento.\n\n"
//      . "Detalhes:\n\n"
//      . "Nome da Empresa: $name\n"
//      . "E-mail: $email\n"
//      . "Telefone: $phone\n"
//      . "Tipo de Negócio: $business_type\n";
//
//$header = "From: $email\r\n";
//$header .= "Reply-To: $email\r\n";
//
//if (!mail($to, $subject, $body, $header)) {
//    http_response_code(500);
//}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/PHPMailer/src/Exception.php';
require 'mail/PHPMailer/src/PHPMailer.php';
require 'mail/PHPMailer/src/SMTP.php';

if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
    http_response_code(500);
    exit();
}

$name    = strip_tags($_POST['name']);
$email   = strip_tags($_POST['email']);
$subject = strip_tags($_POST['subject']);
$message = strip_tags($_POST['message']);

// Instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com'; // Exemplo Hostinger
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contato@cafekamaro.com.br'; // Seu e-mail
    $mail->Password   = 'SENHA_DO_SEU_EMAIL';         // Sua senha
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remetente
    $mail->setFrom('contato@cafekamaro.com.br', 'Café Kamaro');
    // Destinatário
    $mail->addAddress('contato@cafekamaro.com.br'); 

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = "Formulário de Contato: $subject";
    $mail->Body    = "
        <strong>Nome:</strong> $name <br>
        <strong>Email:</strong> $email <br>
        <strong>Assunto:</strong> $subject <br><br>
        <strong>Mensagem:</strong> <br> $message
    ";
    $mail->AltBody = "Nome: $name\nEmail: $email\nAssunto: $subject\n\nMensagem:\n$message";

    $mail->send();
    http_response_code(200);
    echo 'Mensagem enviada com sucesso!';
} catch (Exception $e) {
    http_response_code(500);
    echo "Erro ao enviar a mensagem: {$mail->ErrorInfo}";
}
?>
