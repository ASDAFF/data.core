<?

$strMessPrefix = 'ACRIT_EXP_INDIVIDION_COM_MARKET_';

//
$MESS[$strMessPrefix . 'EXPORT_GIFTS'] = 'Выгружать подарки';
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