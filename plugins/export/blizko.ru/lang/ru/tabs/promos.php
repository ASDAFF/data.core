<?

$strMessPrefix = 'DATA_EXP_BLIZKO_RU_';

//
$MESS[$strMessPrefix . 'EXPORT'] = 'Выгружать';
$MESS[$strMessPrefix . 'EXPORT_DESCRIPTION'] = 'Краткое описание';
$MESS[$strMessPrefix . 'EXPORT_URL'] = 'акция на сайте магазина(ссылка на страницу акции)';
$MESS[$strMessPrefix . 'EXPORT_PROMOCODES'] = 'Промокод';
$MESS[$strMessPrefix . 'EXPORT_PROMOCODES_DESC'] = 'Укажите в прайс-листе текст промокода и размер скидки.<br/>
<br/>
Примечание. Маркет проверяет, что товар продавался до акции по старой цене (или дороже) как минимум 5 дней подряд:<br/>
за последние 60 дней — для категории «Одежда, обувь и аксессуары»;<br/>
за последние 30 дней — для остальных категорий;<br/>
за все время — если товар размещается меньше 30 (60) дней.<br/>
Если это не выполняется, предложение показывается без акции.';
$MESS[$strMessPrefix . 'EXPORT_PROMOCODES_RULES'] = 'Выберите правило для работы с корзиной. <a href="/bitrix/admin/sale_discount.php?lang=ru" target="_blank">Открыть правила</a>';
$MESS[$strMessPrefix . 'EXPORT_PROMOCODES_RULES_DESC'] = 'Выберите правило для работы с корзиной в которых созданы акционные купоны.В правилах <b>обязательно</b> выбрать разделы или товары на которые действуют скидки.';
$MESS[$strMessPrefix . 'EXPORT_SPECIAL_PRICE'] = 'Специальная цена';
$MESS[$strMessPrefix . 'EXPORT_SPECIAL_PRICE_DESC'] = 'Указывайте в прайс-листе цену со скидкой и период действия акции.<br/>Старая цена выше текущей.<br/>
Скидка в процентах не меньше 5% и не больше 95%. Процент округляется до целого числа.<br/>
Скидка в валюте, в которой указана цена предложения, не меньше 1 единицы.<br/>
Товар продавался по старой цене (или дороже) как минимум 5 дней подряд:<br/>
за последние 60 дней — для категории «Одежда, обувь и аксессуары»;<br/>
за последние 30 дней — для остальных категорий;<br/>
за все время — если товар размещается меньше 30 (60) дней.';
$MESS[$strMessPrefix . 'EXPORT_DATE_START'] = 'Дата начала акции';
$MESS[$strMessPrefix . 'EXPORT_DATE_END'] = 'Дата окончания акции';
$MESS[$strMessPrefix . 'EXPORT_ACTION_ID'] = 'Идентификатор акции';
$MESS[$strMessPrefix . 'EXPORT_ACTION_ID_DESC'] = 'Идентификатор акции. Должен быть уникальным для всего прайс-листа. Может содержать только цифры и латинские буквы. Максимальная длина id — 20 символов. <br/>Внимание! Одно предложение может участвовать только в одной акции.';
$MESS[$strMessPrefix . 'EXPORT_N_PLUS_M'] = 'N + M';
$MESS[$strMessPrefix . 'EXPORT_N_PLUS_M_DESC'] = 'Отметьте данную опцию, чтобы включить выгрузку N + M товаров. При покупке N товаров M таких же товаров бесплатно Указывайте в прайс-листе, сколько товаров нужно купить и сколько покупатель получит в подарок.';
$MESS[$strMessPrefix . 'EXPORT_GIFTS'] = 'Подарки';
$MESS[$strMessPrefix . 'EXPORT_GIFTS_DESC'] = 'Отметьте данную опцию, чтобы включить выгрузку подарков в XML-файл.<br/><br/>
Если данная опция включена, в числе полей необходимо заполнить дополнительные поля:<br/>
<ul>
	<li><b>Подарки</b> - поле, содержащее подарки, рекомендуется использовать свойство типа «Привязка к элементам» (или «Привязка к элементам в виде списка»), возможно множественное: в результате обработки поля должны быть ID элементов инфоблока, являющихся подарками,</li>
	<li><b>Подарки (описание)</b> - поле для указания описания акции,</li>
	<li><b>Подарки (URL)</b> - поле для указания подробной страницы с описанием акции.</li>
</ul>
Для каждого подарка должна быть указана либо детальная картинка, либо картинка для анонса.<br/><br.>
<b>Внимание!</b> Поле с подарками должно получать ID подарка или массив ID подарков. Поэтому, если используется привязка к элемента, необходимо в <b>настройках значения</b> отмечать опцию «Использовать значение без обработки». Если подарки могут быть множественными, и в настройках множественного значения, и в настройках всего поля нужно указать «Режим множественных значений» как «Оставить множественным».
';
?>