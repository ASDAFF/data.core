<?
$strMessPrefix = 'DATA_EXP_RETAILCRM_GENERAL_';

// General
$MESS[$strMessPrefix.'NAME'] = 'retailCRM';

// Fields
$MESS[$strMessPrefix.'HEADER_GENERAL'] = 'Общие параметры';
$MESS[$strMessPrefix.'HEADER_ADDITIONAL_FIELDS'] = 'ДОПОЛНИТЕЛЬНЫЕ ПАРАМЕТРЫ (&lt;PARAM&gt;)';

$MESS[$strMessPrefix.'FIELD_ACTIVE'] = 'Показатель активности товара';
$MESS[$strMessPrefix.'FIELD_ACTIVE_DESC'] = 'Элемент не является обязательным, если элемент отсутствует товар считается активным; Для не активного товара необходимо передавать N, в остальных случаях можно передать Y или опустить элемент';
$MESS[$strMessPrefix.'FIELD_ID_NAME'] = 'Идентификатор товара';
$MESS[$strMessPrefix.'FIELD_ID_DESC'] = 'Идентификатор предложения. Может состоять только из цифр и латинских букв. Максимальная длина — 20 символов. Должен быть уникальным для каждого предложения.<br/><br/>Является атрибутом для offer.<br/><br/><a href="https://yandex.ru/support/partnermarket/elements/id-type-available.html" target="_blank">Подробное описание элемента.</a>';
$MESS[$strMessPrefix.'FIELD_CBID_NAME'] = 'Размер ставки на карточке товара';
$MESS[$strMessPrefix.'FIELD_CBID_DESC'] = 'Размер ставки на карточке товара.<br/><br/>Является атрибутом для offer.<br/><br/><a href="https://yandex.ru/support/partnermarket/bid-cbid.html" target="_blank">Подробное описание атрибута.</a>';
$MESS[$strMessPrefix.'CATALOG_QUANTITY_NAME'] = 'Количество на складе';
$MESS[$strMessPrefix.'CATALOG_QUANTITY_DESC'] = 'Доступное к заказу количество товара';
$MESS[$strMessPrefix.'FIELD_BID_NAME'] = 'Размер ставки на остальных местах размещения';
$MESS[$strMessPrefix.'FIELD_BID_DESC'] = 'Размер ставки на остальных местах размещения (все, кроме карточки товара).<br/><br/>Является атрибутом для offer.<br/><br/><a href="https://yandex.ru/support/partnermarket/bid-cbid.html" target="_blank">Подробное описание атрибута.</a>';
$MESS[$strMessPrefix.'FIELD_AVAILABLE_NAME'] = 'Наличие товара';
$MESS[$strMessPrefix.'FIELD_AVAILABLE_DESC'] = 'Статус товара:<br/><b>true — «в наличии» / «готов к отправке»</b><br/>Товар будет доставлен курьером или в пункт выдачи в сроки, которые вы настроили в личном кабинете. На Маркете у товара будет показан конкретный срок доставки.<br/><b>false — «на заказ»</b><br/>Точный срок доставки курьером или в пункт выдачи неизвестен. Срок будет согласован с покупателем персонально (максимальный срок — два месяца). На Маркете у товара будет показана надпись «на заказ» вместо срока.<br/><br/><b>Внимание</b>. Элемент используется в дополнение к данным, настроенным в личном кабинете. Элемент не используется, когда условия локальной курьерской доставки настроены в прайс-листе (любого формата).<br/><br/>Является атрибутом для offer. Если элемент не указан, используется значение по умолчанию — true.<br/><br/><a href="https://yandex.ru/support/partnermarket/elements/id-type-available.html" target="_blank">Подробное описание элемента</a>.';
$MESS[$strMessPrefix.'FIELD_URL_NAME'] = 'URL товара';
$MESS[$strMessPrefix.'FIELD_URL_DESC'] = 'страница торгового предложения (товара) в интернет-магазине. Важно указывать корректный протокол (http:// или https://) и домен (с www или без него). Данный URL используется для определения просмотренных клиентом товаров в рамках интеграции с Google Analytics; Максимальная длина ссылки 2000 символов;';
$MESS[$strMessPrefix.'FIELD_PRICE_NAME'] = 'Цена товара';
$MESS[$strMessPrefix.'FIELD_PRICE_DESC'] = 'цена торгового предложения (товара); Цена может быть целой или дробной с точностью до 2 знаков после запятой в промежутке от 0 до 99 999 999';
$MESS[$strMessPrefix.'FIELD_PURCHASEPRICE_NAME'] = 'Закупочная цена';
$MESS[$strMessPrefix.'FIELD_PURCHASEPRICE_DESC'] = 'закупочная цена торгового предложения (товара), не является обязательной; При отсутствии тега в файле значение не будет сбрасываться; Закупочная цена может быть целой или дробной с точностью до 2 знаков после запятой в промежутке от 0 до 99 999 999;';
$MESS[$strMessPrefix.'FIELD_CATEGORYID_NAME'] = 'Идентификатор категории';
$MESS[$strMessPrefix.'FIELD_CATEGORYID_DESC'] = 'идентификатор категории, к которой принадлежит торговое предложения (товар) значение должно быть одно из идентификаторов категорий, если торговое предложение (товар) находится в нескольких категориях, то таких элементов может быть несколько.';
$MESS[$strMessPrefix.'FIELD_PICTURE_NAME'] = 'Картинка';
$MESS[$strMessPrefix.'FIELD_PICTURE_DESC'] = 'URL картинки торгового предложения (товара), тег не должен повторяться, не является обязательным. Используется для отображения превью изображений. Можно указывать изображения в формате jpg, png размером не более 2Мб. Важно указывать корректный протокол (http:// или https://) и домен (с www или без него), иначе система не сможет отобразить превью товаров. Также важно, чтобы ссылка на товар была прямой и при переходе на нее не производились редиректы. Максимальная длина ссылки 2000 символов;';
$MESS[$strMessPrefix.'FIELD_NAME_NAME'] = 'Название предложения';
$MESS[$strMessPrefix.'FIELD_NAME_DESC'] = 'название торгового предложения; Максимальная длина 255 символов';
$MESS[$strMessPrefix.'FIELD_PRODUCTNAME_NAME'] = 'Название товара';
$MESS[$strMessPrefix.'FIELD_PRODUCTNAME_DESC'] = 'название товара; Максимальная длина 255 символов';
$MESS[$strMessPrefix.'FIELD_XMLID_NAME'] = 'Внешний идентификатор товара';
$MESS[$strMessPrefix.'FIELD_XMLID_DESC'] = 'внешний идентификатор товара, элемент не является обязательным — в случае если интернет-магазин использует выгрузку номенклатуры товаров из складской системы (1С, МойСклад), то значение этого элемента соответствует идентификатору товара в данной системе; Поле представляет собой последовательность символов длиной не более 255';
$MESS[$strMessPrefix.'FIELD_VENDOR_NAME'] = 'Производитель товара';
$MESS[$strMessPrefix.'FIELD_VENDOR_DESC'] = 'производитель товара, элемент не является обязательным; Максимальная длина 255 символов;';
$MESS[$strMessPrefix.'FIELD_WEIGHT_NAME'] = 'Вес товара';
$MESS[$strMessPrefix.'FIELD_WEIGHT_DESC'] = 'Вес товара. Единица измерения - килограмм. Формат: положительное число с точностью 0.001 (или 0.000001, в зависимости от настройки CRM "Точность веса": граммы или миллиграммы соответственно), разделитель целой и дробной части - точка. При указании более высокой точности значение автоматически округляется до третьего знака (включительно) в дробной части. Максимально допустимое значение - 9 999 999 кг. При загрузке каталога вес будет переведен в граммы, так как единицей измерения веса в системе являются граммы.
Примечание. Вес может быть указан как с помощью данного элемента, так и с помощью параметра со специальной обработкой <param name="Вес" code="weight"></param>. Последний был оставлен в целях обратной совместимости. Если для одного и того же товара вес будет указан одновременно и с помощью элемента, и с помощью параметра, то будет взято последнее встретившееся значение. Также обратите внимание на то, что для параметра возможно указание единицы измерения веса, для данного же элемента единица измерения - всегда килограмм, и её указывать не надо.';
$MESS[$strMessPrefix.'FIELD_BARCODE_NAME'] = 'Штрих-код товара';
$MESS[$strMessPrefix.'FIELD_BARCODE_DESC'] = 'Штрих-код товара. Может быть указан как с помощью данного элемента, так и с помощью параметра со специальной обработкой <param name="Штрих-код" code="barcode"></param>. Формат: строка длиной до 255 символов включительно, состоящая только из цифр и латинских букв.';
$MESS[$strMessPrefix.'FIELD_DIMENSIONS_NAME'] = 'Габариты товара';
$MESS[$strMessPrefix.'FIELD_DIMENSIONS_DESC'] = 'Габариты товара (длина, ширина, высота) в упаковке.';


?>