<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("forum") || !CModule::IncludeModule("iblock"))
	return;

$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"FORUM_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("F_FORUM_ID"),
			"TYPE" => "LIST",
			"DEFAULT" => $iForumDefault,
			"VALUES" => $arForum),
		"MESSAGES_PER_PAGE" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("F_MESSAGES_PER_PAGE"),
			"TYPE" => "STRING",
			"DEFAULT" => intVal(COption::GetOptionString("forum", "MESSAGES_PER_PAGE", "10"))),
		"SHOW_RATING" => Array(
			"NAME" => GetMessage("SHOW_RATING"),
			"TYPE" => "LIST",
			"VALUES" => Array(
				"" => GetMessage("SHOW_RATING_CONFIG"),
				"Y" => GetMessage("MAIN_YES"),
				"N" => GetMessage("MAIN_NO"),
			),
			"MULTIPLE" => "N",
			"DEFAULT" => "",
			"PARENT" => "ADDITIONAL_SETTINGS",),
		"SHOW_MINIMIZED" => Array(
			"NAME" => GetMessage("F_SHOW_MINIMIZED"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "ADDITIONAL_SETTINGS",),
		"USE_CAPTCHA" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("F_USE_CAPTCHA"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"),
		"AJAX_POST" => array(
			"NAME" => GetMessage("F_AJAX_POST"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"),
		"USE_REVIEW" => Array(
			"PARENT" => "REVIEW_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_REVIEW"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
	)
);

/**
 * Grouppen properties chooser
 */
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

/**
 * Generate properties list
 */
if ($iblockExists)
{
	$arProperties = array();
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		$arProperties[$arProp['CODE']] = $strPropName;
	}
}

$titleCount = 1;

for($i=0; $i < $titleCount; $i++)
{
	$arComponentParameters['GROUPPEN_TITLE_' . $titleCount] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage("TRIONIX_GROUPPEN_TITLE"),
		'TYPE' => 'STRING',
		'REFRESH' => 'Y'
	);

	if(!empty($arCurrentValues["GROUPPEN_TITLE_" . $titleCount])){
		$arComponentParameters["GROUPPEN_PROPERTIES_" . $titleCount] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage("TRIONIX_GROUPPEN_PROPERTIES"),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '20',
			'VALUES' => $arProperties
		);
		$titleCount++;
	}
}
?>
