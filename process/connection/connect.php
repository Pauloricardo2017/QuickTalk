<?php
// Estabelece uma conexão com o banco de dados MySQL
$con = mysqli_connect("localhost", "root", "", "quicktalk");

// Define o fuso horário do banco de dados como UTC
mysqli_query($con, "SET time_zone='+00:00'");

// Define o fuso horário padrão do script PHP como UTC
date_default_timezone_set("UTC");

// Verifica se houve erro na conexão com o banco de dados
if (mysqli_connect_errno()) {
    // Se houver erro, exibe uma mensagem de falha na conexão e encerra o script
    echo "Falha a ligar a base de dados:" . mysqli_connect_error();
    exit();
}
