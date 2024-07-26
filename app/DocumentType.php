<?php

namespace App;

enum DocumentType: string
{
    case CPF = "cpf";
    case CNPJ = "cnpj";
}
