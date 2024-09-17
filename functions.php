<?php
// Inicia a sessão global no início do arquivo
session_start();

/**
 * Função para criar uma sessão de usuário
 * @param string $email - Email do usuário
 * @param bool $isProfessor - Define se o usuário é um professor (opcional)
 */

 function criarSessao($email, $isProfessor = false)
 {
    // Define variáveis de sessão
    $_SESSION['email'] = $email;
    $_SESSION['loggedin'] = true;
    $_SESSION['isProfessor'] = $isProfessor;
    
    // Obtém o ID da sessão PHP
    $session_id = session_id();
    
    // Define o campo PROFESSOR como TRUE
    if($isProfessor == true)
    {
        $professor_status = true;
    }
    else
    {
        $professor_status = false;
    }
    $auth_data = array(
        'PHPSESSID' => $session_id,
        'PROFESSOR' => $professor_status
    );
    // Converte o array para JSON
    $auth_json = json_encode($auth_data);
    // Codifica o JSON em base64
    $auth_base64 = base64_encode($auth_json);
    // Cria o cookie de autenticação com o JSON codificado
    setcookie('auth', $auth_base64, time() + 3600, "/"); 
}

/**
 * Função para validar a sessão de um Professor
 * @return bool - Retorna true se a sessão for válida, false se não for
 * @param string $tipo - tipo do professor ou aluno
 * */
function validarSessao(string $tipo)
{
    // Verifica se o cookie de sessão existe e se o professor está logado
    if (!isset($_COOKIE['auth']))
    {
        echo "Acesso negado. Cookie de autenticação ausente.";
        exit();
    }
    // Obtém o valor do cookie de autenticação
    $auth_base64 = $_COOKIE['auth'];

    // Decodifica o base64
    $auth_json = base64_decode($auth_base64);

    // Converte o JSON em um array associativo
    $auth_data = json_decode($auth_json, true);
    
    // Verifica se o PHPSESSID no cookie corresponde à sessão atual
    if ($auth_data['PHPSESSID'] !== session_id())
    {
        echo "Acesso negado. Sessão inválida.";
        exit();
    }
    // Verifica o campo PROFESSOR
    if ($tipo == "professor")
    {
        if ($auth_data['PROFESSOR'] == true)
        {
            return true;
        }
        else
        {   
            return false;
        }  
    }
    if ($tipo == "aluno")
    {
        if ($auth_data['PROFESSOR'] !== true)
        {
            return true;
        }
        else
        {   
            return false;
        } 
    }
} 
?>