<?php

namespace marcusvbda\zoop\core;


class Errors
{
    public static function get($_error)
    {
        foreach (self::list() as $error) {
            if (($error["status_code"] == @$_error->status_code) && ($error["category"] == @$_error->category) && ($error["type"] == @$_error->type)) {
                $error["original"] = $_error;
                return (object) $error;
            }
        }
        $_error->original = json_decode(json_encode($_error));
        return $_error;
    }

    public static function list()
    {
        return [
            [
                "status_code" => 500,
                "type" => "processing_error",
                "category" => "server_api_error",
                "description" => "Ocorreu um erro de processamento na Zoop. Se você receber esta mensagem, entre em contato com api@pagzoop.com"
            ],
            [
                "status_code" => 403,
                "type" => "invalid_request_error",
                "category" => "forbidden",
                "description" => "Seu usuário não está autorizado para utilizar este recurso."
            ],
            [
                "status_code" => 409,
                "type" => "invalid_request_error",
                "category" => "duplicate_taxpayer_id",
                "description" => "O cliente com este taxpayer_id já existe."
            ],
            [
                "status_code" => 408,
                "type" => "invalid_request_error",
                "category" => "service_request_timeout",
                "description" => "O processo do cartão de crédito está temporariamente indisponível no local especificado."
            ],
            [
                "status_code" => 404,
                "type" => "invalid_request_error",
                "category" => "endpoint_not_found",
                "description" => "The requested URL was not found on the server"
            ],
            [
                "status_code" => 401,
                "type" => "invalid_request_error",
                "category" => "authentication_failed",
                "description" => "
                O URL solicitado não foi encontrada no servidor"
            ],
            [
                "status_code" => 401,
                "type" => "invalid_request_error",
                "category" => "expired_security_key",
                "description" => "The API Key provided has expired or has been deleted."
            ],
            [
                "status_code" => 401,
                "type" => "invalid_request_error",
                "category" => "invalid_key_for_api_call",
                "description" => "A chave de API fornecida expirou ou foi excluída."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "transaction_amount_error",
                "description" => "O valor mínimo é de R$ 0,50. O valor deve ser um número inteiro positivo em centavos representando quanto cobrar, por exemplo, 1260 por R$ 12,60."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "transfer_amount_error",
                "description" => "
                O valor mínimo da transferência é de R$ 1,00. O valor deve ser um número inteiro positivo em centavos representando quanto cobrar, por exemplo, 1260 por R$ 12,60."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "missing_required_param",
                "description" => "Parâmetros necessários ausentes. Verifique os parâmetros da solicitação."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "unsupported_payment_type",
                "description" => "Pedido inválido: tipo de pagamento não suportado."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "invalid_payment_information",
                "description" => "Informações de pagamento inválidas. Verifique os parâmetros da solicitação."
            ],
            [
                "status_code" => 400,
                "type" => "invalid_request_error",
                "category" => "invalid_parameter",
                "description" => "Parâmetros inválidos. O valor do seu parâmetro está incorreto. Verifique os parâmetros da solicitação."
            ],
            [
                "status_code" => 402,
                "type" => "file_upload",
                "category" => "file_size_too_large",
                "description" => "Arquivo muito grande."
            ],
            [
                "status_code" => 402,
                "type" => "invalid_request_error",
                "category" => "insufficient_escrow_funds_error",
                "description" => "A transferência solicitada excede os fundos liquidados restantes em garantia."
            ],
            [
                "status_code" => 402,
                "type" => "invalid_request_error",
                "category" => "capture_transaction_error",
                "description" => "A solicitação de captura falhou. Não foi possível capturar a transação."
            ],
            [
                "status_code" => 402,
                "type" => "invalid_request_error",
                "category" => "no_action_taken",
                "description" => "Nenhuma ação tomada. Não foi possível fazer o backup da transação anterior"
            ],
            [
                "status_code" => 402,
                "type" => "invalid_request_error",
                "category" => "seller_authorization_refused",
                "description" => "O vendedor não está autorizado a cobrar cartões de crédito. Ativação completa para iniciar o processamento de pagamentos."
            ],
            [
                "status_code" => 402,
                "type" => "invalid_request_error",
                "category" => "void_transaction_error",
                "description" => "A solicitação nula falhou. Não foi possível anular a transação."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "invalid_expiry_month",
                "description" => "Valor do mês de validade inválido. Verifique os parâmetros da solicitação."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "invalid_expiry_year",
                "description" => "Valor inválido do ano de validade. Verifique os parâmetros da solicitação."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "card_customer_not_associated",
                "description" => "Transação negada. Nenhum cartão ativo."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "insufficient_funds_error",
                "description" => "O crédito solicitado excede os fundos liquidados restantes."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "expired_card_error",
                "description" => "O cartão de crédito expirou."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "invalid_card_number",
                "description" => "O número do cartão não é um número de cartão de crédito válido."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "invalid_pin_code",
                "description" => "Transação negada. Código PIN inválido."
            ],
            [
                "status_code" => 402,
                "type" => "card_error",
                "category" => "authorization_refused",
                "description" => "Transação ilegal"
            ],
        ];
    }
}
