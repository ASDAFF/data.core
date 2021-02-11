<?
// Fields: general
$MESS['DATA_EXP_FIELD_ACTIVE'] = 'Активность:';
$MESS['DATA_EXP_FIELD_NAME'] = 'Название профиля:';
	$MESS['DATA_EXP_FIELD_NAME_DEFAULT'] = 'Новый профиль';
$MESS['DATA_EXP_FIELD_DESCRIPTION'] = 'Описание (комментарии):';
$MESS['DATA_EXP_FIELD_SORT'] = 'Сортировка:';

// Fields: general [system]
$MESS['DATA_EXP_HEADING_SYSTEM'] = 'Технические настройки';
$MESS['DATA_EXP_FIELD_SITE_ID'] = 'Сайт:';
	$MESS['DATA_EXP_FIELD_SITE_ID_HINT'] = 'Укажите здесь привязку профиля к сайту.';
$MESS['DATA_EXP_FIELD_DOMAIN'] = 'Домен сайта:';
	$MESS['DATA_EXP_FIELD_DOMAIN_HINT'] = 'Укажите домен. Этот домен будет указан в ссылках.';
$MESS['DATA_EXP_FIELD_IS_HTTPS'] = 'Используется SSL (https://)';
	$MESS['DATA_EXP_FIELD_IS_HTTPS_HINT'] = 'Отметьте данную опцию, если сайт работает через https://';
$MESS['DATA_EXP_FIELD_AUTO_GENERATE'] = 'Автогенерация данных для элементов при их сохранении';
	$MESS['DATA_EXP_FIELD_AUTO_GENERATE_HINT'] = 'Включите данную опцию, если необходима генерация данных для товара сразу при его сохранении.<br/><br/>
	Задействуются события сохранения (добавления и обновления) элемента инфоблока, продукта каталога, цены каталога, свойства инфоблока, остатка на складе.<br/><br/>
	Это полезно на сайтах, где номенклатура выгрузки обновляется не часто и в относительно небольшом объеме - например, при ручном обновлении данных товаров. В таком случае все данные хранятся в базе в сгенерированном виде, и выгрузка даже большого каталога занимает, в среднем, 1-2 секунды.<br/><br/>
	При больших обновлениях номенклатуры данная галочка увеличивает общее время процесса импорта, поэтому в таком случае рекомендуется отключать автогенерацию. При этом генерация будет выполняться непосредственно в момент экспорта.<br/><br/>
	<ul>
		<li>Если данная опция <b>включена</b>, экспорт не будет генерировать данные для тех товары, для которых данные уже сгенерированы. Таким образом, выгрузка будет проходить гораздо быстрее, вплоть до 1 секунды,</li>
		<li>если данная опция <b>отключена</b>, экспорт всегда будет генерировать все товары и предложения.</li>
	</ul>
	<b>Внимание!</b> В ряде случаев эта опция должна быть отключена, т.к. может послужить причиной неактуальности информации в выгрузках, примеры таких случаев:
	<ul>
		<li>используются правила обработки корзины (скидки, наценки),</li>
		<li>активно используется импорт товаров любыми способами,</li>
		<li>много профилей выгрузки,</li>
		<li>используются валюты при выгрузке, курс которых берется из модуля «Валюты»,</li>
		<li>и некоторые другие случаи.</li>
	</ul>
	';

// Export type
$MESS['DATA_EXP_HEADING_PLUGIN'] = 'Выбор формата выгрузки';
	$MESS['DATA_EXP_FIELD_PLUGIN'] = 'Плагин:';
	$MESS['DATA_EXP_FIELD_PLUGIN_HINT'] = 'Плагин - это интеграция с одним конкретным сервисом (торговой площадкой). При этом, для некоторых сервисов возможны вариации - <b>форматы выгрузки</b>.<br/><br/>Например, для Яндекс.Маркета доступны такие форматы как упрощенный, произвольный, книги, аудиокниги и т.п.<br/><br/>Если для плагина доступны форматы выгрузки, необходимо выбрать один из них.<br/><br/>При смене плагина/формата (если ранее было выбрано другое) сделанные ранее настройки полей будут сброшены.';
	$MESS['DATA_EXP_FIELD_PLUGIN_EMPTY'] = '--- выберите плагин ---';
	$MESS['DATA_EXP_FIELD_PLUGIN_NATIVE'] = 'Встроенные';
	$MESS['DATA_EXP_FIELD_PLUGIN_CUSTOM'] = 'Пользовательские';
	$MESS['DATA_EXP_FIELD_PLUGIN_DESCRIPTION'] = 'Описание выгрузки';
	$MESS['DATA_EXP_FIELD_PLUGIN_EXAMPLE'] = 'Пример генерируемого файла';
	$MESS['DATA_EXP_FIELD_PLUGIN_NEED_SAVE'] = 'Для дальнейшей настройки профиля необходимо <b>применить изменения</b>.';
$MESS['DATA_EXP_FIELD_FORMAT'] = 'Формат:';
	$MESS['DATA_EXP_FIELD_FORMAT_HINT'] = 'Формат выгрузки определяет разновидность интеграции с выбранным сервисом. Выберите требуемый формат.<br/><br/>Каждый формат имеет собственный набор полей (при этом, в рамках одного плагина набор полей схож), при смене формата происходит сброс ранее сделанных настроек.';
$MESS['DATA_EXP_FIELD_PLUGIN_ACTIVATE'] = 'Изменить формат выгрузки';
	$MESS['DATA_EXP_FIELD_PLUGIN_ACTIVATE_CONFIRM'] = 'Вы действительно хотите сменить формат выгрузки?';



?>