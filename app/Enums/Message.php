<?php

namespace App\Enums;

enum Message: string
{
    case login_success = 'Вход успешно';
    case successfully = 'Успешно.';
    case created = 'Успешно создано.';
    case updated = 'Успешно обновлено.';
    case deleted = 'Успешно удалено.';
    case not_found = 'Запись не найдена.';
    case lesson_have_content = 'В этом уроке уже есть контент.';
    case logged_out = 'Выход успешно.';
    case to_many_attempts = 'Слишком много попыток.';
}
