<?php

namespace App\Helpers;

use App\Helpers\GlobalMessagesHelper;

class UsersMessagesHelper extends GlobalMessagesHelper
{
    const USER_NOT_FOUND_MESSAGE = 'Usuario nao encontrado';
    const USER_ROLE_EXISTS_MESSAGE = 'Role ja configurada para o usuario';
    const USER_NEW_ROLE_MESSAGE = 'Role %s adicionada ao usuario';
    const USER_NEW_USER_MESAGE = 'Usuario %s criado com sucesso';
}