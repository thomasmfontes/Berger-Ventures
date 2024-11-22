<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $ddi = $_POST['ddi'] ?? '';
    $cell = $_POST['phone'] ?? '';
    $assunto_user = $_POST['subject'] ?? '';
    $mensagem = $_POST['message'] ?? '';

    // Validação básica dos campos
    if (empty($nome) || empty($email) || empty($ddi) || empty($cell) || empty($assunto_user) || empty($mensagem)) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    $para = "thomas@fontes.ca";
    $assunto = $assunto_user;

    // Remover caracteres não numéricos do número de telefone
    $cell_numeric = preg_replace('/\D/', '', $cell);

    // Formatar o número do WhatsApp
    $whatsapp_link = "https://wa.me/$ddi$cell_numeric?text=Olá!%20Como%20eu%20poderia%20te%20ajudar?";

    // Corpo do email com link para WhatsApp
    $corpo = "
        <html>
        <head>
            <title>$assunto</title>
        </head>
        <body>
            <p>Nome: $nome</p>
            <p>Email: $email</p>
            <p>Telefone: $ddi $cell</p>
            <p>Mensagem: $mensagem</p>
            <p>Iniciar conversa no WhatsApp: <a href='$whatsapp_link'>Clique aqui</a></p>
        </body>
        </html>
    ";

    $headers = "From: thomas@fontes.ca\r\n" .
               "Reply-To: $email\r\n" .
               "X-Mailer: PHP/" . phpversion() . "\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=iso-8859-1\r\n";

    if (mail($para, $assunto, $corpo, $headers)) {
        echo "Email enviado para $para com sucesso!";
    } else {
        echo "Falha no envio do email.";
        error_log("Falha no envio do email para $para");
    }
}
?>
