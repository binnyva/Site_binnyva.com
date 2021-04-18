<?php
// :DEBUG */ include('./common.php');header("Content-type:text/plain");

class Menu {
	var $title	= "";
	var $link	= "";
	var $id		= "";
	var $sub	= array();

	function Menu($title,$link="",$id="",$extra="") {
		$this->title = $title;
		$this->link  = $link;
		$this->id	 = $id;
		$this->extra = $extra;
	}

	function addItem($title, $link, $extra="") {
		array_push($this->sub, array(
				'title'=>$title,
				'link'=>$link,
				'extra'=>$extra
			)
		);
	}
	function addMenu($menu) {
		array_push($this->sub, array(
				'title'=>$menu->title,
				'link'=>$menu->link,
				'menu'=>$menu
			)
		);
	}
	
	//Create the HTML code for the Menu
	function createHTML($indent="") {
		if(count($this->sub)) { //Generate the sub menu only if the data is present
			$id = '';
			if($this->id) $id = ' id="'.$this->id.'"';

			$html .= "<ul${id}>\n";
			$html .= $indent . '<li class="menu-head">' . $this->title ."</li>\n";
			foreach($this->sub as $item) {
				//Accomadate the extra options
				$extra = '';
				if($item['extra']) $extra = ' '.$item['extra']; //For Menu items
				elseif($item['menu']->extra) $extra = ' '.$item['menu']->extra; //For items with menu under them.

				$html .= $indent . '<li><a href="'.$item['link'].'"'.$extra.'>'.$item['title']."</a>";
				if(isset($item['menu'])) { //If this item has a sub menu, render it also - this goes down recursively
					//$html .= $indent . "<li>";
					$html .= $item['menu']->createHTML($indent.'	');
					//$html .= $indent . "</li>\n";
				}
				$html .= "</li>\n";
			}
			$html .= "</ul>";
		}

		return $html;
	}
}
?>