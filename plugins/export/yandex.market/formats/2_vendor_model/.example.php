<?
use \Bitrix\Main\Localization\Loc,
	\Data\Core\Helper;

$strExample = <<< XML
<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="2017-02-05 17:22">
	<shop>
		<name>BestSeller</name>
		<company>Tne Best inc.</company>
		<url>http://best.seller.ru</url>

		<currencies>
			<currency id="RUR" rate="1"/>
			<currency id="USD" rate="60"/>
		</currencies>

		<categories>
			<category id="1">Бытовая техника</category>
			<category id="10" parentId="1">Мелкая техника для кухни</category>
			<category id="101" parentId="10">Сэндвичницы и приборы для выпечки</category>
			<category id="102" parentId="10">Мороженицы</category>
			<category id="2">Детские товары</category>
			<category id="20" parentId="2">Детский спорт</category>
			<category id="200" parentId="20">Игровые и спортивные комплексы, горки</category>
		</categories>

		<offers>
		
			<offer id="12346" type="vendor.model" available="true" bid="80" cbid="90" fee="325">
				<url>http://best.seller.ru/product_page.asp?pid=12348</url>
				<price>1490</price>
				<oldprice>1620</oldprice>
				<currencyId>RUR</currencyId>
				<categoryId>101</categoryId>
				<picture>http://best.seller.ru/img/large_12348.jpg</picture>
				<store>false</store>
				<pickup>true</pickup>
				<delivery>true</delivery>
				<delivery-options>
					<option cost="300" days="0" order-before="12"/>
				</delivery-options>
				<typePrefix>Вафельница</typePrefix>
				<vendor>First</vendor>
				<model>FA-5300</model>
				<vendorCode>A1234567B</vendorCode>
				<description>
				<![CDATA[
					<p>Отличный подарок для любителей венских вафель.</p>
				]]>
				</description>
				<sales_notes>Необходима предоплата.</sales_notes>
				<manufacturer_warranty>true</manufacturer_warranty>
				<country_of_origin>Россия</country_of_origin>
				<barcode>0156789012</barcode>
				<cpa>1</cpa>
				<rec>123,456</rec>
			</offer>

			<offer id="9012" type="vendor.model" available="true" bid="80" cbid="90" fee="325">
				<url>http://best.seller.ru/product_page.asp?pid=12345</url>
				<price>8990</price>
				<oldprice>9900</oldprice>
				<currencyId>RUR</currencyId>
				<categoryId>102</categoryId>
				<picture>http://best.seller.ru/img/model_12345.jpg</picture>
				<store>false</store>
				<pickup>false</pickup>
				<delivery>true</delivery>
				<delivery-options>
					<option cost="300" days="1" order-before="18"/>
				</delivery-options>
				<typePrefix>Мороженица</typePrefix>
				<vendor>Brand</vendor>
				<model>3811</model>
				<description>
				<![CDATA[
					<h3>Мороженица Brand 3811</h3>
					<p>Это прибор, который придётся по вкусу всем любителям десертов и сладостей, ведь с его помощью вы сможете делать вкусное домашнее мороженое из натуральных ингредиентов.</p>
				]]>
				</description>
				<param name="Цвет">белый</param>
				<sales_notes>Необходима предоплата.</sales_notes>
				<manufacturer_warranty>true</manufacturer_warranty>
				<country_of_origin>Китай</country_of_origin>
				<barcode>0123456789379</barcode>
				<cpa>1</cpa>
				<rec>345,678</rec>
			</offer>

			<offer id="5678" type="vendor.model" available="true" bid="80" cbid="90" fee="325">
				<url>http://best.seller.ru/product_page.asp?pid=12344</url>
				<price>5690</price>
				<oldprice>6100</oldprice>
				<currencyId>RUR</currencyId>
				<categoryId>200</categoryId>
				<picture>http://best.seller.ru/img/device12345.jpg</picture>
				<store>true</store>
				<pickup>true</pickup>
				<delivery>true</delivery>
				<delivery-options>
					<option cost="500" days="1" order-before="18"/>
				</delivery-options>
				<typePrefix>Шведская стенка</typePrefix>
				<vendor>Формула здоровья</vendor>
				<model>Орленок-3А Плюс</model>
				<description>
				<![CDATA[
					<p>Комплекс из шведской стенки, турника, колец, каната и лестницы поможет подросткам поддерживать хорошую физическую форму и проводить полноценные тренировки в течение дня. Это очень важно при загруженности современных школьников.</p>
					<p>Модель может быть укомплектована четырьмя вариантами конструктивных решений турника и выпускается в девяти цветовых версиях.</p>
					<p>Спортивный комплекс рассчитан на большие нагрузки и поэтому на нем могут заниматься дети разного возраста и комплекции, что очень удобно, если в семье двое и более детей.</p>
				]]>
				</description>
				<sales_notes>Необходима предоплата.</sales_notes>
				<manufacturer_warranty>true</manufacturer_warranty>
				<country_of_origin>Россия</country_of_origin>
				<barcode>1245678920</barcode>
				<cpa>1</cpa>
				<rec>789,012</rec>
			</offer>
			
		</offers>
	</shop>
</yml_catalog>
XML;
if(!Helper::isUtf()){
	$strExample = Helper::convertEncoding($strExample, 'UTF-8', 'CP1251');
}
?>
<div class="data-exp-plugin-example">
	<pre><code class="xml"><?=htmlspecialcharsbx($strExample);?></code></pre>
</div>
<script>
$('.data-exp-plugin-example pre code.xml').each(function(i, block) {
	highlighElement(block);
});
</script>