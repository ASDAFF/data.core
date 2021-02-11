<?
use \Data\Core\Export\Plugins\Vk;

$accessTokenUrl = Vk::getAccessUrl();

$strMessPrefix = 'DATA_EXP_VK_GOODS_';

$MESS[$strMessPrefix.'HEADER_FIRST'] = 'Первые действия';
$MESS[$strMessPrefix.'INTRO'] = 'Прежде всего необходимо авторизовать в <a href="https://vk.com" target="_blank">vk.com</a> и создать новую группу, если она еще не создана. При создании группы сразу указывайте полную информацию о группе и о компании.';
$MESS[$strMessPrefix.'GET_VK_ACCESS_TITLE'] = 'Получение доступа к данным группы';
$MESS[$strMessPrefix.'GET_VK_ACCESS'] = 'Для обмена данными необходимо указать Access Token (ключ доступа) и ID группы Вконтакте.<br/><br/>
Для получения Access Token:
<ul>
	<li>перейдите по <a href="'.$accessTokenUrl.'" target="_blank">ссылке</a>,</li>
	<li>в открывшемся окне, если появится запрос, авторизуйтесь и подтвердите права (<i>если таких запросов не появляется - значит, это уже было сделано раньше)</i>,</li>
	<li>после того как на экране будет сообщение "Пожалуйста, не копируйте данные ...", <b>скопируйте адрес из адресной строки и вставьте его в поле "Access Token"</b>,</li>
	<li>токен будет автоматически определен и подставлен. Готово.</li>
</ul>
<p>Чтобы узнать ID группы, можно перейти в эту группу, а затем перейти в раздел "<b>Статистика</b>" (в правой колонке, под логотипом группы). Далее смотрите адресную строку Вашего браузера: https://vk.com/stats?gid=<b>ID_группы</b> - в конце ссылки будет ID вашей группы.</p>';
$MESS[$strMessPrefix.'RECOMMEND_TITLE'] = 'Рекомендации';
$MESS[$strMessPrefix.'HEADER_WARNING_INFO'] = 'Важные моменты!';
$MESS[$strMessPrefix.'WARNING_INFO'] = '<p>API VK имеет ограничение по количеству запросов: не более 5-ти запросов в секунду. Это значит, что экспорт будет проходить достаточно медленно, т.к. экспорт одного товара требует нескольких запросов к API</p>
<p>Так же замечено, что API VK кеширует данные на несколько минут. Поэтому, чтобы избежать коллизий, при необходимости нескольких последовательных выгрузок, между запусками выгрузок следует выдерживать интервал, по крайней мере, в 10 минут.</p>';
$MESS[$strMessPrefix.'CATEGORY_REDEFINITION'] = 'Не забудьте для каждого инфоблока настроить сопоставления разделов (каждому разделу сайта сопоставить раздел vk.com), иначе выгрузка не будет успешной. Это касается только случаев, когда в categoryId выгружается ID раздела сайта.';
$MESS[$strMessPrefix.'MAX_COUNT'] = 'Такйже имейте ввиду, что vk.com позволяет загружать не более 15 тысяч товаров в одну группу. И за один час <strong>не рекомендуется</strong> выгружать более 1000 товаров, а в сутки &ndash; более 7000.';
$MESS[$strMessPrefix.'RUN_BY_PARTS'] = 'Порядок настройки <strong>поэтапной выгрузки</strong>:
<ol>
	<li>Выставляем значение "Выгружаемых за раз товаров" (вкладка "Общие настройки") равным 100 товаров.</li>
    <li>Делаем пробный запуск, чтобы сгенерировались все позиции для выгрузки и отработали первые 100 товаров.</li>
    <li>Настраиваем расписание на запуск каждые 10 минут (вкладка "Автозапуск").</li>
</ol>';
$MESS[$strMessPrefix.'OTHER_INFO'] = '<p>Для того, чтобы у товаров появилась кнопка "Купить", необходимо для группы установить приложение <a href="https://vk.com/app5792770" target="_blank">"Магазин товаров"</a>. Подробнее читайте здесь: <a href="https://vk.com/page-19542789_53327576" target="_blank">https://vk.com/page-19542789_53327576</a>.</p>';
$MESS[$strMessPrefix.'ERRORS_DESCRIPTION'] = 'Описание возможных ошибок';
$MESS[$strMessPrefix.'CONSOLE'] = 'Нажмите Alt+C для открытия PHP-консоли.';

?>
