<?
// General
$MESS['DATA_EXP_PAGE_TITLE_DEFAULT'] = 'Управления профилями экспорта на торговые площадки';
$MESS['DATA_EXP_PAGE_TITLE'] = 'Список профилей экспорта';

// Core notice
$MESS['DATA_EXP_CORE_NOTICE'] = '<b>Внимание!</b> Не установлен необходимый для работы служебный модуль <a href="/bitrix/admin/update_system_partner.php?addmodule=#CORE_ID#&lang=#LANG#" target="_blank">data.core</a>. Установите его для продолжения работы.';

// General popup
$MESS['DATA_EXP_POPUP_LOADING'] = 'Загрузка...';

// Popup: backup restore
$MESS['DATA_EXP_POPUP_RESTORE_TITLE'] = 'Восстановление профилей из резервной копии';
$MESS['DATA_EXP_POPUP_RESTORE_SAVE'] = 'Восстановить';
$MESS['DATA_EXP_POPUP_RESTORE_CLOSE'] = 'Отменить';
$MESS['DATA_EXP_POPUP_RESTORE_WRONG_FILE'] = 'Выбран некорректный файл';
$MESS['DATA_EXP_POPUP_RESTORE_NO_FILE'] = 'Не выбран файл с резервной копией';
$MESS['DATA_EXP_POPUP_RESTORE_SUCCESS'] = 'Восстановление выполнено.';
$MESS['DATA_EXP_POPUP_RESTORE_ERROR'] = 'Ошибка при восстановлении.';

// Backup
$MESS['DATA_EXP_POPUP_BACKUP_ERROR'] = 'Ошибка создания резервной копии.';
$MESS['DATA_EXP_POPUP_BACKUP_ERROR_FILE_IS_NOT_WRITEABLE'] = 'Файл недоступен для записи (#DATA#).';
$MESS['DATA_EXP_POPUP_BACKUP_ERROR_DIR_IS_NOT_WRITEABLE'] = 'Папка недоступна для записи (#DATA#).';

$MESS['DATA_EXP_HEADER_ID'] = 'ID';
$MESS['DATA_EXP_HEADER_ACTIVE'] = 'Акт.';
$MESS['DATA_EXP_HEADER_NAME'] = 'Название';
$MESS['DATA_EXP_HEADER_DESCRIPTION'] = 'Описание';
$MESS['DATA_EXP_HEADER_SORT'] = 'Сорт.';
$MESS['DATA_EXP_HEADER_SITE_ID'] = 'Сайт';
$MESS['DATA_EXP_HEADER_DOMAIN'] = 'Домен';
$MESS['DATA_EXP_HEADER_IS_HTTPS'] = 'SSL';
$MESS['DATA_EXP_HEADER_AUTO_GENERATE'] = 'Автообработка';
$MESS['DATA_EXP_HEADER_AUTO_CRON'] = 'Автозапуск по Cron';
$MESS['DATA_EXP_HEADER_FORMAT'] = 'Формат выгрузки';
$MESS['DATA_EXP_HEADER_EXPORT_FILE_NAME'] = 'Файл экспорта';
	$MESS['DATA_EXP_HEADER_EXPORT_FILE_NAME_TITLE'] = 'Нажмите, чтобы открыть файл в новой вкладке';
$MESS['DATA_EXP_HEADER_DATE_CREATED'] = 'Дата создания';
$MESS['DATA_EXP_HEADER_DATE_MODIFIED'] = 'Дата изменения';

// Header for dynamic fields
$MESS['DATA_EXP_HEADER_DATE_START'] = 'Дата запуска';
$MESS['DATA_EXP_HEADER_DATE_END'] = 'Дата завершения';
$MESS['DATA_EXP_HEADER_DATE_LOCKED'] = 'Дата блокировки';
$MESS['DATA_EXP_HEADER_TIME_GENERATED'] = 'Время генерации';
$MESS['DATA_EXP_HEADER_TIME_TOTAL'] = 'Время выгрузки';
$MESS['DATA_EXP_HEADER_COUNT_SUCCESS'] = 'Выгружено успешно';
$MESS['DATA_EXP_HEADER_COUNT_ERROR'] = 'Выгружено с&nbsp;ошибками';
// Context
$MESS['DATA_EXP_CONTEXT_PROFILE_EDIT'] = 'Редактировать';
$MESS['DATA_EXP_CONTEXT_PROFILE_COPY'] = 'Копировать';
$MESS['DATA_EXP_CONTEXT_PROFILE_DELETE'] = 'Удалить';
$MESS['DATA_EXP_CONTEXT_PROFILE_DELETE_CONFIRM'] = 'Удалить профиль %s?';
$MESS['DATA_EXP_CONTEXT_PROFILE_BACKUP'] = 'Скачать рез. копию';
$MESS['DATA_EXP_CONTEXT_PROFILE_ACTIVATE'] = 'Активировать';
$MESS['DATA_EXP_CONTEXT_PROFILE_DEACTIVATE'] = 'Деактивировать';
$MESS['DATA_EXP_CONTEXT_PROFILE_UNLOCK'] = 'Снять блокировку';
$MESS['DATA_EXP_CONTEXT_PROFILE_REMOVE_CRONTAB'] = 'Отменить автозапуск по Cron';

// ToolBar
$MESS['DATA_EXP_TOOLBAR_ADD'] = 'Добавить профиль';
$MESS['DATA_EXP_TOOLBAR_BACKUP'] = 'Резервное копирование';
$MESS['DATA_EXP_TOOLBAR_BACKUP_CREATE'] = 'Скачать рез. копию выбранных профилей';
$MESS['DATA_EXP_TOOLBAR_BACKUP_RESTORE'] = 'Восстановить из рез. копии';

// Group actions
$MESS['DATA_EXP_GROUP_UNLOCK'] = 'снять блокировку';
$MESS['DATA_EXP_GROUP_UNCRON'] = 'отменить автозапуск по Cron';
$MESS['DATA_EXP_GROUP_ERROR_NOT_FOUND'] = 'Профиль #ID# не найден.';
$MESS['DATA_EXP_GROUP_ERROR_DELETE'] = 'Ошибка при удалении профиля #NAME#';
$MESS['DATA_EXP_GROUP_ERROR_UPDATE'] = 'Ошибка при изменении профиля #NAME#';
$MESS['DATA_EXP_GROUP_ERROR_UNLOCK'] = 'Ошибка при снятии блокировки профиля #NAME#';
$MESS['DATA_EXP_GROUP_ERROR_UNCRON'] = 'Ошибка отмены автозапуска профиля #NAME#';

// Filter
$MESS['DATA_EXP_FILTER_ID'] = 'ID профиля';
$MESS['DATA_EXP_FILTER_ACTIVE'] = 'Активность';
$MESS['DATA_EXP_FILTER_LOCKED'] = 'Блокировка';
$MESS['DATA_EXP_FILTER_NAME'] = 'Название';
$MESS['DATA_EXP_FILTER_FORMAT'] = 'Формат выгрузки';
$MESS['DATA_EXP_FILTER_AUTO_GENERATE'] = 'Автогенерация';
$MESS['DATA_EXP_FILTER_SITE_ID'] = 'Сайт';
$MESS['DATA_EXP_FILTER_DATE_CREATED'] = 'Дата создания';
$MESS['DATA_EXP_FILTER_DATE_MODIFIED'] = 'Дата изменения';

// CRM
$MESS['DATA_CRM_SETTINGS_LINK'] = 'Настройки подключения к Битрикс24 находятся в <a href="/bitrix/admin/settings.php?lang=ru&mid=data.exportproplus&data_exportproplus_tab_control_active_tab=crm">настройках модуля</a>.';

?>