<?
$MESS['ACRIT_EXP_RUN_MANUAL'] = 'Запуск вручную';
	$MESS['ACRIT_EXP_RUN_MANUAL_HINT'] = 'Ручной запуск возможен двумя способами - обычным (в браузере) или фоновым (на сервере).<br/><br/>
	Фоновый запуск возможен только при доступности на сайте php-функций <b><code>proc_open</code></b> и <b><code>proc_close</code></b>.<br/><br/>Если указанные функции заблокированы (обычно в целях повышения безопасности; см. php-конфиг <code>disable_functions</code>), возможности запуска в фоне нет (также в этом случае пропадает возможность использования многопоточности).
	Скорость экспорта в фоне обычно немного выше чем скорость экспорта при запуске из браузера, т.к. в отличие от обычного ручного запуска в нем нет пауз между шагами выгрузки.';
	$MESS['ACRIT_EXP_RUN_MANUAL_BUTTON'] = 'Запустить вручную (в браузере)';
	$MESS['ACRIT_EXP_RUN_BACKGROUND_BUTTON'] = 'Запустить в фоне (на сервере)';
$MESS['ACRIT_EXP_RUN_AUTO'] = 'Автоматический запуск';
$MESS['ACRIT_EXP_CRON_STATUS'] = 'Статус задания';
	$MESS['ACRIT_EXP_CRON_STATUS_HINT'] = 'Статус показывает текущее состояние профиля: настроен ли уже данный профиль на автоматическое выполнение планировщиком.';
	$MESS['ACRIT_EXP_CRON_STATUS_Y'] = 'установлено';
	$MESS['ACRIT_EXP_CRON_STATUS_N'] = 'не установлено';
$MESS['ACRIT_EXP_CRON_CANNOT_AUTOSET'] = '<b>Внимание!</b> На Вашем сервере автоматическая настройка планировщика недоступна.<br/>Вам необходимо вручную настроить планировщик Cron (см. команду ниже).';
$MESS['ACRIT_EXP_CRON_CANNOT_AUTOSET_TOGGLE'] = 'Дополнительная информация';
$MESS['ACRIT_EXP_CRON_CANNOT_AUTOSET_HEADER'] = 'Почему недоступна автоматическая установка заданий планировщика?';
$MESS['ACRIT_EXP_CRON_CANNOT_AUTOSET_MORE'] = '
<style>
.acrit-core-cron-cannot-autoset-info{margin:8px 0 0;}
.acrit-core-cron-cannot-autoset-info p, .acrit-core-cron-cannot-autoset-info li {margin:0 0 6px!important;}
</style>
<div class="acrit-core-cron-cannot-autoset-info">
	<p>Возможность автоматической настройки заданий планировщика определяется следующим образом:</p>
	<ol style="margin:0;">
		<li>
			модуль устанавливает задание в планировщик:<br/>
			<code><b>(crontab -l 2>/dev/null; echo "* * * * * /usr/bin/php /home/bitrix/www/myscript.php") | crontab -</b></code>
		</li>
		<li>
			модуль получает список текущих настроенных задач:<br/>
			<code><b>crontab -l</b></code>
		</li>
	</ol>
	<p>Если в результате модуль видит настроенную команду в общем списке команд - значит, автоматическая установка заданий работает (в этом случае модуль удаляет тестовое задание), иначе - не работает, выдается предупреждение, настройка заданий может выполняться только вручную.</p>
	<p>Обычно, причиной являются различного рода запреты на соответствующие действия со стороны сервера - например, в целях безопасности.</p>
</div>
';
$MESS['ACRIT_EXP_CRON_COMMAND'] = 'Команда для ручной настройки или ручного запуска';
	$MESS['ACRIT_EXP_CRON_COMMAND_HINT'] = 'В данном поле представлена команда для выполнения планировщиком.<br/><br/>Данная команда сгенерирована по общим правилам, поэтому на некоторых серверах может понадобиться внести в нее небольшие корректировки. Например, может понадобиться указать свой путь к PHP (здесь выводится указанный в настройках модуля путь к PHP) или добавить/убрать из команды настройки mbstring - это можно сделать в <a href="/bitrix/admin/settings.php?lang=ru&mid=acrit.core" target="_blank">настройках модуля ядра Акрит</a>.<br/><br/>Данная команда может быть запущена из SSH, что удобно в некоторых случаях.';
	$MESS['ACRIT_EXP_CRON_COMMAND_WARNING'] = '<span style="color:red"><b>Внимание!</b> Никогда не запускайте скрипты от имени root! Т.к. если в процессе работы создаются какие-либо файлы и папки, они создаются от имени root, и в последующем сайт не сможет корректно работать с этими файлами и папками, будут постоянные ошибки.</span>';
	$MESS['ACRIT_EXP_CRON_COMMAND_COPY'] = 'Копировать';
	$MESS['ACRIT_EXP_CRON_COMMAND_COPY_SUCCESS'] = 'Команда скопирована в буфер обмена!';
	$MESS['ACRIT_EXP_CRON_LINK_ARTICLE_BITRIX_ENV'] = '<a href="https://www.acrit-studio.ru/pantry-programmer/bitrix-bitrix-environment-vm/crond-in-bitrix-vm/" target="_blank">Информация по настройке Cron на виртуальной машине Битрикс</a>';
$MESS['ACRIT_EXP_CRON_SERVER_TIME'] = 'Время сервера';
	$MESS['ACRIT_EXP_CRON_SERVER_TIME_HINT'] = 'Здесь показывается текущее время сервера, учитывайте его при настройке заданий.';
	$MESS['ACRIT_EXP_CRON_SERVER_TIME_DAYS'] = 'Воскресенье,Понедельник,Вторник,Среда,Четверг,Пятница,Суббота';
	$MESS['ACRIT_EXP_CRON_SERVER_TIME_MONTHS'] = 'января,февраля,марта,апреля,мая,июня,июля,августа,сентября,октября,ноября,декабря';
$MESS['ACRIT_EXP_CRON_SCHEDULE'] = 'Расписание запуска';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_HINT'] = 'С помощью этого параметра можно указать конкретное расписание запуска профиля. Эти поля (минута, час, день, месяц, день недели) управляют стандартными настройками планировщика Cron, поэтому подробную информация Вы можете найти в соответствующей документации.<br/><br/><b>Внимание!</b> При нажатии кнопки «Установить задание» все дополнительные задания по загрузке данного профиля, будут удалены, в результате останется только одно правило. Нажатие кнопки «Отменить задание» отменяет все задания текущего профиля.';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_MINUTE'] = 'минута';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_HOUR'] = 'час';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_DAY'] = 'день';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_MONTH'] = 'месяц';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_WEEKDAY'] = 'день недели';
$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST'] = 'Быстрые варианты';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_MINUTE'] = 'каждую минуту';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_5_MINUTES'] = 'каждые 5 минут';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_HOURLY_HALF'] = 'каждые полчаса';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_HOURLY'] = 'каждый час';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_HOURLY_4'] = 'каждые 4 часа';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_DAILY'] = 'каждый день в 8:00';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_9_12_16'] = 'три раза в день: в 9, 12 и 16 часов';
	$MESS['ACRIT_EXP_CRON_SCHEDULE_FAST_SUNDAY'] = 'утром в воскресенье';
$MESS['ACRIT_EXP_CRON_BUTTON_SETUP'] = 'Установить задание';
$MESS['ACRIT_EXP_CRON_BUTTON_CLEAR'] = 'Отменить задание';
$MESS['ACRIT_EXP_CRON_TASKS'] = 'Настроенные задания';
	$MESS['ACRIT_EXP_CRON_TASKS_HINT'] = 'Здесь Вы можете посмотреть, какие конкретно задачи сейчас настроены на автоматический запуск с помощью планировщика Cron.<br/><br/>Задания выводятся в том порядке, котором они указаны на сервере.<br/><br/>В большинстве случаев здесь будет показано одно задание, т.к. модуль может установить для профиля не более одного задания. Однако вручную в планировщике можно установить произвольное количество заданий (при установке задания из модуля все они будут удалены).<br/><br/><b>Внимание!</b> При нажатии кнопки «Установить задание» все дополнительные задания по загрузке данного профиля, будут удалены, в результате останется только одно правило. Нажатие кнопки «Отменить задание» отменяет все задания текущего профиля.';
	#$MESS['ACRIT_EXP_CRON_TASKS_TOGGLE'] = 'Посмотреть';
	#$MESS['ACRIT_EXP_CRON_TASKS_NO'] = 'Нет заданий';
$MESS['ACRIT_EXP_CRON_ONE_TIME'] = 'Одноразовая выгрузка';
	$MESS['ACRIT_EXP_CRON_ONE_TIME_HINT'] = 'Опция позволяет автоматически удалить задачу планировщика после успешного выполнения выгрузки.<br/><br/>
	Таким образом можно реализовать одноразовую выгрузку: «выгрузил и выключил».<br/><br/>
	Галочка автоматически снимается (а также отменяется настроенное задание) только после автоматической выгрузки; при ручной выгрузке состояние галочки не изменяется и задание не удаляется.<br/><br/>
	Если задача планировщика не настроено, но запуск был из командной строки, то задание также удалено не будет.';
?>