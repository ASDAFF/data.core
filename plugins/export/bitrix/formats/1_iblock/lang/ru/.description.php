<?
$strMessPrefix = 'DATA_EXP_BITRIX_IBLOCK_';

$MESS[$strMessPrefix.'GET_BITRIX_ACCESS_TITLE'] = 'Получение доступа к данным принимающего сайта';
$MESS[$strMessPrefix.'GET_BITRIX_ACCESS'] = '
<div>Передавать данные возможно только с действующим SSL-сертификатом.</div>
<ol>
	<li>Для работы плагина на принимающем сайте необходимо установить модуль <a href="https://marketplace.1c-bitrix.ru/solutions/data.restext/" target="_blank">"Дополнительные REST-методы"</a> (его установку и настройку вы можете запросить у нашей техподдержки).</li>
	<li>После установки модуля перейдите в его настройки, нажмите "Сохранить" и вам будет выдан доступ к данному порталу: код веб-хука и ID пользователя.</li>
	<li>Скопируйте эти данные в соответствующее поле данного профиля модуля экспорта.</li>
	<li>Заполните поле "Адрес принимающего сайта" профиля.</li>
	<li>Укажите ID инфоблока принимающего сайта.</li>
	<li>После сохранения вы сможете настраивать связку полей текущего сайта и принимающего.</li>
</ol>
';
$MESS[$strMessPrefix.'OTHER_INFO'] = '';
$MESS[$strMessPrefix.'ERRORS_DESCRIPTION'] = 'Описание возможных ошибок';
//$MESS[$strMessPrefix.'CONSOLE'] = 'Нажмите Alt+C для открытия PHP-консоли.';

?>
