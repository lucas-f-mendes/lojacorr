<?php

namespace App\Enum;

class MessagesEnum
{
    const ERROR_HAS_OCURRED = "Ocorreu um erro inesperado :)";
    const FORBIDDEN_OPERATION = "Operação não autorizada";
    const INVALID_CREDENTIALS = "Credenciais Inválidas";
    const UNAUTHENTICATED = "Usuário não autenticado";
    const VALID_TOKEN = "Token Válido";
    const INVALID_TOKEN = "Token Inválido";
    const LOGIN = "Usuário autenticado com sucesso";
    const LOGOUT = "Usuário desconectado";
    const NOT_FOUND = "Não encontrado";
    const REGISTER_NOT_FOUND = "Registro não encontrado";
    const SAME_NAME = "Já existe um registro com o mesmo nome";
    const UNDEFINED_QUERY = "Consulta não definida";
}
