<?
$strMessPrefix = 'DATA_EXP_WILDBERRIES_PRODUCTS_';

$MESS[$strMessPrefix.'GET_WILDBERRIES_ACCESS_TITLE'] = 'Порядок действий для выгрузки спецификации';
$MESS[$strMessPrefix.'GET_WILDBERRIES_ACCESS'] = '
<p>Плагин позволяет выгрузить спецификацию на товары для заказа, загруженного в партнёрскую систему.</p>
<p>Общая <strong>схема настройки профиля</strong>:</p>
<ol>
	<li>Загрузите заказ на <a href="https://suppliers.wildberries.ru/" target="_blank">suppliers.wildberries.ru</a>.
	<li>Создайте профиль (или используете уже существующий, подходящий к данной товарной категории) и укажите в нём токен подключения к API и ID загруженного заказа.
	<li>После сохранения, во вкладке "Настройка инфоблоков / Поля товаров" появятся поля, которые нужно заполнить для данного заказа. Также, во вкладке "Общие настройки" появится список вариантов для поля "Идентификатор товара в заказе WB" - выберите подходящий вариант (как правило, это артикул).
	<li>Поля, одинаковые для всех товаров заказа можно задать постоянными значениями (для этого нужно перевести плагин в режим с загрузкой словарей).
	<li>Поля, которые у товаров могут различаться, должны быть заданы в самих свойствах товаров и привязаны в профиле к соответствующим полям wildberries. <a href="https://joxi.ru/gmvqEjRTqnW5wr" target="_blank">https://joxi.ru/gmvqEjRTqnW5wr</a></li>
</ol>
<p>Плагин работает в двух режимах: в обычном режиме и с зарузкой словарей (справочников) Wildberries. <strong>Загрузка словарей</strong> позволяет прямо в профиле выбирать из списка значения из тех, что предоставляет Wildberries: <a href="https://joxi.ru/J2b1ZJet057oOm" target="_blank">https://joxi.ru/J2b1ZJet057oOm</a>. Включаются и выключаются справочники галкой "Загрузка словарей": <a href="https://joxi.ru/5md7RGkS30W8jr" target="_blank">https://joxi.ru/5md7RGkS30W8jr</a>.</p>
<p>Загрузка словарей процесс длительный и не исключена возможность появления 504-й ошибки во время загрузки профиля (после включения режима). Поэтому словари следует единократно использовать и отключать, чтобы можно было комфортно работать с профилем.</p>
<p><strong>Порядок выгрузки спецификации</strong>:</p>
<ol>
	<li>После запуска выгрузки в логах вы получите список исправлений: <a href="https://joxi.ru/EA4kwaNsoM1pE2" target="_blank">https://joxi.ru/EA4kwaNsoM1pE2</a>.
	<li>Вносите данные исправления, пока этот список не исчезнет. Wildberries здесь не делает глубокую проверку соответствия данных, а лишь смотрит, чтобы формат вводимых данных подходил. Поэтому после успешной выгрузки, вероятнее всего, спецификацию ещё придётся доработать на <a href="https://suppliers.wildberries.ru/" target="_blank">suppliers.wildberries.ru</a>.
	<li>Как только выгрузка спецификации окончательно осуществится, она станет доступна в списке спецификаций: <a href="https://joxi.ru/8An683XfzWpG5A" target="_blank">https://joxi.ru/8An683XfzWpG5A</a> (при этом не исключено, что она будет требовать дальнейшей доработки на стороне Wildberries).
</ol>
';
$MESS[$strMessPrefix.'OTHER_INFO'] = '';
$MESS[$strMessPrefix.'ERRORS_DESCRIPTION'] = 'Описание возможных ошибок';
//$MESS[$strMessPrefix.'CONSOLE'] = 'Нажмите Alt+C для открытия PHP-консоли.';

?>
