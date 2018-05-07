<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?
if (CModule::IncludeModule("iblock")):
// ID инфоблока из которого выводим элементы
$iblock_id = 19;
$my_slider = CIBlockElement::GetList (
// Сортировка элементов
Array("ID" => "DESC"),
Array("IBLOCK_ID" => $iblock_id, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"),
false,
false,
// Перечисляесм все свойства элементов, которые планируем выводить
Array(
'ID', 
'NAME', 
'PREVIEW_PICTURE', 
'PREVIEW_TEXT', 
'DETAIL_PAGE_URL',
'ACTIVE',
'PROPERTY_NA_GLAVNOI'
)
);

$i = 0;

while($ob = $my_slider->GetNextElement())
{
//Выводим элемент со всеми свойствами + верстка

$arFields = $ob->GetFields();

$arProps = $ob->GetProperties();

	if($arProps['NA_GLAVNOI']['VALUE'] == 'Y')
	{

		$arr_news[$i] = array(
				'name' => $arFields['NAME'],
				'text' => $arFields['PREVIEW_TEXT'],
				'link' => $arFields['DETAIL_PAGE_URL'],
				'NA_GLAVNOI' => $arProps['NA_GLAVNOI']['VALUE'],
			);
		$i++;
	}
}
endif;
?> 


<!-- BS carousel slider -->
<div id="st-slider" class="carousel slide">
	<!-- Preloader -->
	<div class="carousel-preloader">
		<span class="spinner"></span>
	</div>
	<!-- Progress bar -->
	<div class="carousel-progress">
		<span class="bar"></span>
	</div>
				
<ol class="carousel-indicators">
<?$count = 0;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li data-slide-to="<?=$count;?>" data-target="#st-slider" <?if($count == 0):?>class="active"<?endif?>></li>
	<?$count++;?>
<?endforeach;?>
</ol>	
	
<div class="carousel-inner">	
<?$count2 = 0;?>	
<?$i2 = 0;?>		
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<!-- Slide -->
	<div class="item<?if($count2 == 0):?> active<?endif?>">
		<div class="slide-image" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>');"></div>
		<div class="carousel-caption">
			<div class="title-block animate short-delay">
				<h2><a href="<?echo $arr_news[$i2][link]?>"><?echo $arr_news[$i2][name]?></a></h2>
				<div class="carousel-nav">
					<a class="left carousel-control" href="#st-slider" data-slide="prev">&lt;</a>
					<a class="right carousel-control" href="#st-slider" data-slide="next">&gt;</a>
				</div><br /><br />
				
				<p style="color: #000000;"><?echo $arr_news[$i2][text]?></p>
				<a href="<?echo $arr_news[$i2][link]?>" class="carousel-link"></a>
				
			</div>

		</div>
		<div class="mask"></div>
	</div>	
<?$i2++;?>	
<?if($i2 == $i){$i2 = 0;}?>
<?$count2++;?>
<?endforeach;?>
</div>

</div>
