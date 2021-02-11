<?
$strMessPrefix = 'DATA_EXP_SETTINGS_LEADING_ZERO_';

$MESS[$strMessPrefix.'NAME'] = 'Добавить ведущие нули';
$MESS[$strMessPrefix.'DESC'] = 'Данная опция позволяет выгружать ведущие нули. Актуально только для чисел (в случае, если не число - значение останется как есть, без обработки).<br/></br>
Например, число 10 (если опция «Общее число знаков» равна 6) в выгрузке модуль заменит на 000010.<br/><br/>
Полезно, в т.ч. для установке сортировки выгрузки товаров по ID.';
$MESS[$strMessPrefix.'LEADING_ZERO_COUNT'] = 'Общее число знаков: ';
$MESS[$strMessPrefix.'LEADING_ZERO_COUNT_HINT'] = 'Укажите общее число знаков.<br/><br/>
Например, при числе знаков 5 число 10 будет преобразовано в 00010.';
?>