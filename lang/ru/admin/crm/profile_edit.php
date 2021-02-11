<?
// Titles
$MESS['DATA_EXP_PAGE_TITLE_DEFAULT'] = 'Управления профилями экспорта на торговые площадки';
$MESS['DATA_EXP_PAGE_TITLE_ADD'] = 'Добавление профиля экспорта';
$MESS['DATA_EXP_PAGE_TITLE_COPY'] = 'Копирование профиля экспорта ##ID#';
$MESS['DATA_EXP_PAGE_TITLE_EDIT'] = 'Редактирование профиля экспорта ##ID#';

// Core notice
$MESS['DATA_EXP_CORE_NOTICE'] = '<b>Внимание!</b> Не установлен необходимый для работы служебный модуль <a href="/bitrix/admin/update_system_partner.php?addmodule=#CORE_ID#&lang=#LANG#" target="_blank">data.core</a>. Установите его для продолжения работы.';

// Main notice
$MESS['DATA_EXP_MAIN_NOTICE_FOR_HINTS'] = '<b style="color:red">Внимательно читайте подсказки к настройкам!</b> Подсказки (<span id="hint_main_noice"></span><script>BX.hint_replace(BX("hint_main_noice"), "Это подсказка!");</script> ) содержат много полезной информации, без знания которой легко совершить ошибки в настройке. <a href="#" data-role="main-notice-hide">Больше не показывать</a>';

// Lock notice
$MESS['DATA_EXP_LOCK_NOTICE'] = '<b>Внимание!</b> Текущий профиль заблокирован (т.е. выполняется загрузка). <b>Внесение изменений в профиль не рекомендуется.</b> Дата блокировки: #DATE#. <a href="javascript:void(0)" data-role="profile-unlock" data-confirm="Действительно разблокировать?">Разблокировать</a>';

// General popup
$MESS['DATA_EXP_POPUP_LOADING'] = 'Загрузка...';
$MESS['DATA_EXP_POPUP_SAVE'] = 'Сохранить';
$MESS['DATA_EXP_POPUP_CLOSE'] = 'Закрыть';
$MESS['DATA_EXP_POPUP_CANCEL'] = 'Отменить';
$MESS['DATA_EXP_POPUP_REFRESH'] = 'Обновить';

// Context menu
$MESS['DATA_EXP_MENU_LIST'] = 'Список профилей';
$MESS['DATA_EXP_MENU_CRON'] = 'Настроить автозапуск';
$MESS['DATA_EXP_MENU_RUN'] = 'Запустить!';
$MESS['DATA_EXP_MENU_ACTIONS'] = 'Действия';
$MESS['DATA_EXP_MENU_ADD'] = 'Добавить новый профиль';
$MESS['DATA_EXP_MENU_COPY'] = 'Копировать текущий профиль';
$MESS['DATA_EXP_MENU_DELETE'] = 'Удалить текущий профиль';
	$MESS['DATA_EXP_MENU_DELETE_CONFIRM'] = 'Вы уверены что хотите удалить текущий профиль?';
$MESS['DATA_EXP_MENU_BACKUP'] = 'Скачать рез. копию профиля';

// Tabs
$MESS['DATA_EXP_TAB_GENERAL_NAME'] = 'Площадка';
	$MESS['DATA_EXP_TAB_GENERAL_DESC'] = 'Настройки профиля и подключения к площадке';
$MESS['DATA_EXP_TAB_BASIC_NAME'] = 'Общие настройки';
	$MESS['DATA_EXP_TAB_BASIC_DESC'] = 'Общие настройки сделок';
$MESS['DATA_EXP_TAB_CONTACTS_NAME'] = 'Контакты';
	$MESS['DATA_EXP_TAB_CONTACTS_DESC'] = 'Данные для контакта сделки';
$MESS['DATA_EXP_TAB_STAGES_NAME'] = 'Стадии';
	$MESS['DATA_EXP_TAB_STAGES_DESC'] = 'Сопоставление со стадиями сделок';
$MESS['DATA_EXP_TAB_FIELDS_NAME'] = 'Поля';
	$MESS['DATA_EXP_TAB_FIELDS_DESC'] = 'Сопоставление с полями сделок';
$MESS['DATA_EXP_TAB_PRODUCTS_NAME'] = 'Товары';
	$MESS['DATA_EXP_TAB_PRODUCTS_DESC'] = 'Сопоставление с товарами';
$MESS['DATA_EXP_TAB_SYNC_NAME'] = 'Синхронизация';
	$MESS['DATA_EXP_TAB_SYNC_DESC'] = 'Запуск синхронизации';
$MESS['DATA_EXP_TAB_CRON_NAME'] = 'Автозапуск';
	$MESS['DATA_EXP_TAB_CRON_DESC'] = 'Добавление выгрузки профиля в планировщик Cron';
$MESS['DATA_EXP_TAB_LOG_NAME'] = 'Лог и история';
	$MESS['DATA_EXP_TAB_LOG_DESC'] = 'Лог профиля и история выгрузки';

// Popup: SelectField
$MESS['DATA_EXP_POPUP_SELECT_FIELD_TITLE'] = 'Выбор поля';

// Popup: ValueSettings
$MESS['DATA_EXP_POPUP_VALUE_SETTINGS_TITLE'] = 'Настройки значения поля ';

// Popup: FieldSettings
$MESS['DATA_EXP_POPUP_FIELD_SETTINGS_TITLE'] = 'Настройки поля';

// Popup: AdditionalFields
$MESS['DATA_EXP_POPUP_ADDITIONAL_FIELDS_TITLE'] = 'Добавление дополнительных полей';

// Popup: CategoriesRedefinition
$MESS['DATA_EXP_POPUP_CATEGORY_REDEFINITION_TITLE'] = 'Переопределение названий разделов';
$MESS['DATA_EXP_POPUP_CATEGORY_REDEFINITION_CLEAR_ALL'] = 'Удалить все';
$MESS['DATA_EXP_POPUP_CATEGORY_REDEFINITION_CLEAR_CONFIRM'] = 'Удалить все сохраненные данные для названий категорий?';

// Popup: execute
$MESS['DATA_EXP_POPUP_EXECUTE_TITLE'] = 'Запуск экспорта';
$MESS['DATA_EXP_POPUP_EXECUTE_BUTTON_START'] = 'Запустить!';
$MESS['DATA_EXP_POPUP_EXECUTE_BUTTON_STOP'] = 'Остановить';
$MESS['DATA_EXP_POPUP_EXECUTE_STOPPED'] = 'Процесс остановлен.';
$MESS['DATA_EXP_POPUP_EXECUTE_ERROR'] = 'Произошла ошибка. Подробности в консоли браузера.';

// Popup: cron
$MESS['DATA_EXP_POPUP_CRON_ERROR'] = 'Ошибка установки задания планировщика.';

// Popup: Iblocks preview
$MESS['DATA_EXP_POPUP_IBLOCKS_PREVIEW_TITLE'] = 'Просмотр инфоблоков';

// IBlock save result
$MESS['DATA_EXP_IBLOCK_SETTINGS_SAVE_PROGRESS'] = '&nbsp; <span style="color:orange">Настройки сохраняются..</span>';
$MESS['DATA_EXP_IBLOCK_SETTINGS_SAVE_SUCCESS'] = '&nbsp; <span style="color:green">Настройки успешно сохранены!</span>';
$MESS['DATA_EXP_IBLOCK_SETTINGS_SAVE_ERROR'] = '&nbsp; <span style="color:red">Ошибка при сохранении настроек</span>';
$MESS['DATA_EXP_IBLOCK_SETTINGS_CLEAR_CONFIRM'] = 'Действительно очистить заполненные поля для данного инфоблока \n(#ID#, #NAME#)?';

// Additional fields
$MESS['DATA_EXP_ADDITIONAL_FIELD_DELETE_CONFIRM'] = 'Поле будет немедленно удалено.\nПродолжить?';
$MESS['DATA_EXP_ADDITIONAL_FIELDS_DELETE_ALL_CONFIRM'] = 'Все созданные дополнительные поля будут немедленно удалены.\nПродолжить?';

//
$MESS['DATA_EXP_UPDATE_CATEGORIES_SUCCESS'] = 'Категории успешно обновлены!';
$MESS['DATA_EXP_UPDATE_CATEGORIES_ERROR'] = 'Ошибка обновления категорий. Подробности смотрите в логе.';

//
$MESS['DATA_EXP_AJAX_AUTH_REQUIRED'] = 'Необходима авторизация. Вы можете выполнить авторизацию в отдельном окне и затем в текущем окне повторить операцию.';
$MESS['DATA_EXP_AJAX_CONFIRM_CLEAR_EXPORT_DATA'] = 'Это действие удалит все ранее сгенерированные данные экспорта для каждого из товаров. Продолжить?';
$MESS['DATA_EXP_AJAX_CONSOLE_TIME'] = 'Время выполнения: #TIME#';

// Run in background
$MESS['DATA_EXP_RUN_BACKGROUND_SUCCESS'] = 'Процесс экспорта запущен!';
$MESS['DATA_EXP_RUN_BACKGROUND_DISABLED'] = 'На данном сайте нет возможности запуска в фоне (возможно, недоступна php-функции proc_open и proc_close).';
$MESS['DATA_EXP_RUN_BACKGROUND_INACTIVE'] = 'Текущий профиль неактивен, поэтому его выгрузка невозможна.';
$MESS['DATA_EXP_RUN_BACKGROUND_BLOCKED'] = 'Текущий профиль заблокирован, т.к. выполняется другой процесс экспорта.';
$MESS['DATA_EXP_RUN_BACKGROUND_ERROR'] = 'Ошибка запуска.';

//
$MESS['DATA_EXP_AJAX_CRON_SETUP_SUCCESS'] = 'Настроена автоматическая загрузка профиля: #COMMAND#';
$MESS['DATA_EXP_AJAX_CRON_SETUP_ERROR'] = 'Ошибка добавления задания в планировщик: #COMMAND#';
$MESS['DATA_EXP_AJAX_CRON_DELETE_SUCCESS'] = 'Автоматическая загрузка профиля отменена.';

//
$MESS['DATA_EXP_ERROR_FORMAT_NOT_FOUND_TITLE'] = 'Ошибка! Формат выгрузки не найден.';
$MESS['DATA_EXP_ERROR_FORMAT_NOT_FOUND_DETAILS'] = 'Формат выгрузки (#FORMAT#) не найден. Возможно, он удален.<br/>
Необходимо выбрать в поле «Плагин» и «Формат» нужный плагин и (если необходимо) нужный формат, затем применить настройки профиля и после этого проверить все настройки.';
$MESS['DATA_EXP_ERROR_CONSOLE_ACCESS_DENIED'] = 'Вы не имеете доступа к выполнению кода в консоли. Только администраторы сайта имеют право выполнения кода.';
$MESS['DATA_EXP_ERROR_FIRST_ELEMENT_IS_NOT_FOUND'] = 'Подходящих элементов нет.';

// CRM
$MESS['DATA_CRM_SETTINGS_LINK'] = 'Настройки подключения к Битрикс24 находятся в <a href="/bitrix/admin/settings.php?lang=ru&mid=data.exportproplus&data_exportproplus_tab_control_active_tab=crm">настройках модуля</a>.';

?>