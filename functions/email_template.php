<?php
/**
 * Read email template file and replace variables in it.
 * @param string $path -- Path to the template directory.
 * @param string $lang -- ISO code of desired language.
 * @param array  $vars -- Replacement values.
 * @return string
**/
function email_template ($path, $lang, $vars = [])
{
	$full_path = "$path/$lang.html";
	if(is_file($full_path) && is_readable($full_path)){
		$template = file_get_contents($full_path);
		$vars['lang'] = $lang;
		$vars['dir'] = (preg_match('/^(fa|ar|he)-/', $lang) ? 'rtl' : 'ltr');
		foreach($vars as $k => $v) $template = preg_replace("/\{$k\}/", $v, $template);
		return $template;
	}
	return '';
}

?>
