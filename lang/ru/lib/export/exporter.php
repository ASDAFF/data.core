<?
$MESS['DATA_EXP_EXPORTER_STEP_PREPARE'] = 'Подготовка';
$MESS['DATA_EXP_EXPORTER_STEP_CHECK'] = 'Проверка данных';
$MESS['DATA_EXP_EXPORTER_STEP_DISCOUNTS'] = 'Пересчет скидок';
$MESS['DATA_EXP_EXPORTER_STEP_AUTO_DELETE'] = 'Очистка прежних данных';
$MESS['DATA_EXP_EXPORTER_STEP_GENERATE'] = 'Обработка товаров';
$MESS['DATA_EXP_EXPORTER_STEP_EXPORT'] = 'Экспорт товаров';
$MESS['DATA_EXP_EXPORTER_STEP_REPORT'] = 'Подготовка отчета';
$MESS['DATA_EXP_EXPORTER_STEP_DONE'] = 'Завершение';

# Main log
$MESS['DATA_EXP_LOG_REQUIRED_ELEMENT_FIELDS_ARE_EMPTY'] = 'Не заполнены обязательные поля для элемента [ID = #ELEMENT_ID#]: #FIELDS#.';
$MESS['DATA_EXP_LOG_REQUIRED_OFFER_FIELDS_ARE_EMPTY'] = 'Не заполнены обязательные поля для предложения [ID = #ELEMENT_ID#]: #FIELDS#.';
$MESS['DATA_EXP_LOG_AUTOGENERATE_ELEMENT_TO_EXPORT_DATA'] = 'Элемент [ID = #ELEMENT_ID#] автоматически обработан.';
$MESS['DATA_EXP_LOG_DELETING_ELEMENT_FROM_EXPORT_DATA'] = 'Элемент [ID = #ELEMENT_ID#] удален из выгрузки.';
$MESS['DATA_EXP_LOG_SAVE_ELEMENT_ERROR'] = 'Ошибка сохранения данных экспорта для элемента (ID = #ELEMENT_ID#): #ERROR#.';
$MESS['DATA_EXP_LOG_PROFILE_NOT_FOUND'] = 'Профиль не найден или не активен.';

# Debug log
$MESS['DATA_EXP_LOG_USE_MULTITHREADING_Y'] = 'Используется многопоточность (потоков: #THREAD_COUNT#, товаров за шаг: #PER_THREAD#).';
$MESS['DATA_EXP_LOG_USE_MULTITHREADING_N'] = 'Многопоточность не используется.';
$MESS['DATA_EXP_LOG_THREAD_START'] = 'Поток ##INDEX# запущен (PID: #PID#, инфоблок: #IBLOCK_ID#, шаг: #PAGE# [#FROM# - #TO#])';
$MESS['DATA_EXP_LOG_THREAD_TIMEOUT'] = 'Поток завершается по таймауту (время: #TIME#, обработано: #PROCESSED_COUNT#, последний элемент: #LAST_ELEMENT#, инфоблок: #IBLOCK_ID#).';
$MESS['DATA_EXP_LOG_THREAD_FINISH'] = 'Поток ##INDEX# завершен (PID: #PID#, инфоблок: #IBLOCK_ID#).';
$MESS['DATA_EXP_LOG_OVERFLOW_100_PERCENT'] = 'Обработка свыше 100% [Инфоблок #BLOCK_ID#]: #SESSION#.';
$MESS['DATA_EXP_LOG_THREAD_ERROR'] = 'Ошибка выполнения потока ##INDEX#: #ERROR#.';
$MESS['DATA_EXP_LOG_CUSTOM_RUN'] = 'API-запуск выгрузки. Команда: #COMMAND#';

# Process log
$MESS['DATA_EXP_LOG_PROCESS_FORMAT_NOT_FOUND'] = 'Формат выгрузки не найден (#FORMAT#). Продолжение невозможно.';
$MESS['DATA_EXP_LOG_PROCESS_PERMISSION_DENIED'] = 'Ошибка доступа к файлу #FILE#. Проверьте права доступа.';
$MESS['DATA_EXP_LOG_PROCESS_STARTED_MANUAL'] = 'Запущен процесс экспорта.';
$MESS['DATA_EXP_LOG_PROCESS_STARTED_CRON'] = 'Запущен автоматический экспорт.';
$MESS['DATA_EXP_LOG_PROCESS_STARTED_CRON_PID'] = 'PID процесса: #PID#.';
$MESS['DATA_EXP_LOG_PROCESS_TYPE'] = 'Тип выгрузки: #TYPE_NAME# (#TYPE_CODE#).';
$MESS['DATA_EXP_LOG_PROCESS_FINISHED'] = 'Процесс завершен! Затрачено времени: #TIME#.';

# Display preview result
$MESS['DATA_EXP_EXPORT_PREVIEW_ELEMENT_SKIPPED'] = '<span style="color:red;">#TYPE# <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=#IBLOCK_ID#&type=#IBLOCK_TYPE_ID#&ID=#ELEMENT_ID#&lang=#LANG#&find_section_section=0" target="_blank" style="color:red;">#ELEMENT_ID#</a> не попадает в выгрузку. Не все обязательные поля заполнены: #ERROR_FIELDS#.</span>';
$MESS['DATA_EXP_EXPORT_PREVIEW_TYPE_ELEMENT'] = 'Элемент';
$MESS['DATA_EXP_EXPORT_PREVIEW_TYPE_PRODUCT'] = 'Товар';
$MESS['DATA_EXP_EXPORT_PREVIEW_TYPE_OFFER'] = 'Предложение';
$MESS['DATA_EXP_EXPORT_PREVIEW_ELEMENT_ERRORS'] = '<span style="color:red;">#ERRORS#.</span>';
$MESS['DATA_EXP_EXPORT_PREVIEW_DATA_MORE'] = 'Дополнительные данные товара';
$MESS['DATA_EXP_EXPORT_PREVIEW_JSON_ORIGINAL'] = 'Данные в формате JSON';

?>