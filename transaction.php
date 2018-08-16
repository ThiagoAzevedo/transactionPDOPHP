<?php

//Dados para a inserção
$login1 = "Mario";
$pass1 = md5("123456");

$login2 = "Maria";
$pass2 = md5("123456");

$login3 = "Jose";
$pass3 = md5("123456");

$login4 = "Josefina";
$pass4 = md5("123456");


$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
);
$conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "", $options);

try {
	//Transação
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->beginTransaction();
	//Insere dados na tabela
	$stmt = $conn->prepare("INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (?, ?)");
	$stmt->execute(array($login1, $pass1));
	$stmt->execute(array($login2, $pass2));
	$stmt->execute(array($login3, $pass3));
	$stmt->execute(array($login4, $pass4));
	//Recupera o último ID da inserção no banco
	$ultimoId = $conn->lastInsertId();
	//Exibe o ID recuperado
	echo "Recuperado o ID: " . $ultimoId . "</br>";
	//Deleta o último ID
	$stmt = $conn->prepare("DELETE FROM tb_usuarios WHERE idusuario = ?");
	$stmt->execute(array($ultimoId));
	//Execute o commit
	return $conn->commit();

} catch(PDOException $ex) {
	echo "<h4>Falha na transação. " . $ex->getMessage() . "</h4></br>";
	$conn->rollback();
}