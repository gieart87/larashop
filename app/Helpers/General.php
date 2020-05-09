<?php

namespace App\Helpers;

/**
 * General
 *
 * PHP version 7
 *
 * @category General
 * @package  General
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class General
{
	/**
	 * Generate multilevel select input
	 *
	 * @param string $name    name
	 * @param array  $array   array data
	 * @param array  $options additional option
	 *
	 * @return string
	 */
	public static function selectMultiLevel($name, $array = [], $options = [])
	{
		$class_form = "";
		if (isset($options['class'])) {
			$class_form = $options['class'];
		}

		$selected = [];
		if (isset($options['selected'])) {
			$selected = is_array($options['selected']) ? $options['selected'] : [$options['selected']];
		}

		if (isset($options['placeholder'])) {
			$placeholder = [
				'id' => '',
				'name' => $options['placeholder'],
				'parent_id' => 0
			];
			$array[] = $placeholder;
		}
		
		$multiple = '';
		if (isset($options['multiple'])) {
			$multiple = 'multiple';
		}

		$select = '<select class="'.$class_form.'" name="'.$name.'" '.$multiple.'>';
		$select .= General::getMultiLevelOptions($array, 0, [], $selected);
		$select .= '</select>';

		return $select;
	}

	/**
	 * Generate multilevel options for select input
	 *
	 * @param array $array     options
	 * @param int   $parent_id parent id
	 * @param array $parents   parents option
	 * @param array $selected  selected options
	 *
	 * @return string
	 */
	public static function getMultiLevelOptions($array, $parent_id = 0, $parents = [], $selected = [])
	{
		static $i = 0;
		if ($parent_id == 0) {
			foreach ($array as $element) {
				if (($element['parent_id'] != 0) && !in_array($element['parent_id'], $parents)) {
					$parents[] = $element['parent_id'];
				}
			}
		}

		$menu_html = '';
		foreach ($array as $element) {
			$selected_item = '';
			if ($element['parent_id']==$parent_id) {
				if (in_array($element['id'], $selected)) {
					$selected_item = 'selected';
				}
				$menu_html .= '<option value="'.$element['id'].'" '.$selected_item.'>';
				for ($j=0; $j<$i; $j++) {
					$menu_html .= '&mdash; ';
				}
				$menu_html .= $element['name'].'</option>';
				if (in_array($element['id'], $parents)) {
					$i++;
					$menu_html .= General::getMultilevelOptions($array, $element['id'], $parents, $selected);
				}
			}
		}

		$i--;
		return $menu_html;
	}

	/**
	 * Convert number to roman
	 *
	 * @param int $integer name
	 *
	 * @return string
	 */
	public static function integerToRoman($integer)
	{
		$integer = intval($integer);
		$result = '';
		
		// Create a lookup array that contains all of the Roman numerals.
		$lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
 
		foreach ($lookup as $roman => $value) {
			$matches = intval($integer/$value);
			$result .= str_repeat($roman, $matches);
			$integer = $integer % $value;
		}

		return $result;
	}

	/**
	 * Apply price format to number
	 *
	 * @param double $number   number
	 * @param string $currency format
	 *
	 * @return string
	 */
	public static function priceFormat($number, $currency = '')
	{
		$currency = !empty($currency) ? $currency.' ' : '';
		return $currency . number_format($number, 0, ",", ".");
	}

	/**
	 * Apply date format to datetime
	 *
	 * @param string $datetime datetime
	 * @param string $format   format
	 *
	 * @return string
	 */
	public static function datetimeFormat($datetime, $format = 'd M Y H:i:s')
	{
		if (!empty($datetime)) {
			return date($format, strtotime($datetime));
		} else {
			return '';
		}
	}
	
	/**
	 * Show attributes json as ul tag
	 *
	 * @param string $jsonAttributes json attributes
	 *
	 * @return string
	 */
	public static function showAttributes($jsonAttributes)
	{
		$attributes = json_decode($jsonAttributes, true);
		$showAttributes = '';
		if ($attributes) {
			$showAttributes .= '<ul class="item-attributes">';
			foreach ($attributes as $key => $attribute) {
				$showAttributes .= '<li>'. ucwords($key) . ': <span>' . $attribute . '</span><li>';
			}
			$showAttributes .= '</ul>';
		}

		return $showAttributes;
	}
}
