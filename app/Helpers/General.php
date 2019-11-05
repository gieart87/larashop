<?php 
namespace App\Helpers;

class General
{
    public static function selectMultiLevel($name, $array = [], $options = []) {
        $class_form = "";
    	if (!empty($options['class'])) {
    		$class_form = $options['class'];
        }

    	$selected = '';
    	if (!empty($options['selected'])) {
    		$selected = $options['selected'];
    	}

    	if (!empty($options['placeholder'])) {
    		$placeholder = [
    			'id' => '',
    			'name' => $options['placeholder'],
    			'parent_id' => 0
    		];
    		$array[] = $placeholder;
    	}

        $select = '<select class="'.$class_form.'" name="'.$name.'">';
    	$select .= General::getMultiLevelOptions($array, 0 , [], $selected);
    	$select .= '</select>';

    	return $select;
	}

	public static function getMultiLevelOptions($array, $parent_id = 0, $parents = [], $selected = null, $placeholder = null) {
    	if ($placeholder != null) {
    		$placeholder_item = [
    			'id' => 0,
    			'name' => $placeholder
    		];
    		$array[] = $placeholder;
    	}

        static $i=0;
        if ($parent_id==0) {
            foreach ($array as $element) {
                if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                    $parents[] = $element['parent_id'];
                }
            }
		}

        $menu_html = '';
        foreach ($array as $element) {
            $selected_item = '';
            if ($element['parent_id']==$parent_id) {
                if ($element['id'] == $selected) {
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
}