// validacao.js

// Função para validar a extensão do arquivo
function validarExtensaoArquivo(inputFile) {
    // Obtém o valor do arquivo enviado
    const filePath = inputFile.value;

    // Define as extensões permitidas
    const extensoesPermitidas = /(\.jpg|\.jpeg)$/i;

    // Verifica se o arquivo enviado tem uma das extensões permitidas
    if (!extensoesPermitidas.exec(filePath)) {
        alert("Por favor, envie um arquivo com extensão .jpg ou .jpeg.");
        inputFile.value = ''; // Limpa o campo de arquivo
        return false;
    } else {
        // Se o arquivo for válido, pode prosseguir
        alert("Arquivo válido!");
        return true;
    }

    console.log("dentro da função");
}

console.log("fora da função");