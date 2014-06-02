<?php
/**
 * A controller/view class that abstracts the common functionalites of plugin and widged
 *
 * @package   Somc_Subpages
 * @author    Iztok Svetik <iztok@isd.si>
 * @license   GPL-2.0+
 * @link      http://www.isd.si
 * @copyright 2014 Iztok Svetik
 */

class SomcSubpagesIztokSvetikController
{
	/**
	 * Temporary variable of all children of a page so the recursiun 
	 * makes a few less lookups
	 *
	 * @var array of objects
	 **/
	private $childen;

	/**
	 * All the pages stored in instance varable so theres only one
	 * database lookup
	 *
	 * @var array of objects
	 **/
	private $pages;

	/**
	 * Plugin name
	 *
	 * @var string
	 **/
	private $plugin_slug = 'somc-subpages-iztoksvetik';
	
	/**
	 * Constructor, could be refactored to static class but uses
	 * instance varibales for optimiztaion
	 *
	 * @return instance
	 **/
	public function __construct($post_id) {
		$this->id = $post_id;
	}

	/**
	 * Displays the children of a page if the post is a page and has children
	 *
	 * @return html string
	 **/
	public function display() {
		// Get the post type
		$type = get_post_type($id);

		if ($type == 'page') {
			$tree =	$this->getChildren($this->id);
			if (!empty($tree)) {
				$wrapper = '<div class="%s">%s</div>';

				// Once we make sure the post type is page and it has children we return the tree
				return sprintf($wrapper, $this->plugin_slug, $this->render($tree));
			}
		}
	}
	
	/**
	 * Renders the branches of the tree by calling itself recursevly
	 *
	 * @return html string
	 **/
	private function render($elements) {
		$html = '';
		$ul = '<a class="ssis-order ssis-order-asc" href="#" data-order="asc"><i class="icon-sort-name-up"></i></a>
			   <a class="ssis-order ssis-order-desc" href="#" data-order="desc"><i class="icon-sort-name-down"></i></a>
			   <a class="ssis-more" href="#"><i class="icon-down-open"></i></a>
			   <ul class="ssis-list">%s</ul>';
		$li = '<li>%s</li>';
		$title = '<span class="title">%s</span>';
		$link = '<div class="content"><a href="%s">%s</a></div>';
		$list = '';
		foreach ($elements as $element) {
			$image = get_the_post_thumbnail($element['object']->ID, 'thumbnail');

			$original_title = $element['object']->post_title;
			if (strlen($original_title) > 20) {
				$element_title = substr($original_title, 0, 20) . '...';
			}
			else {
				$element_title = $original_title;
			}
			$element_title = sprintf($title, $element_title);

			$content = sprintf($link, get_permalink($element['object']->ID), $image . $element_title);
			
			if (!empty($element['children'])) {
				$children = $this->render($element['children']);
				$sublist = $content . ' ' . $children;
				$list .= sprintf($li, $sublist);
			}
			else {
				$list .= sprintf($li, $content);
			}
		}
		$html = sprintf($ul, $list);
		return $html;
	}

	/**
	 * Finds all the children of the page by leveraging wp native public functions
	 * and returns the construced tree
	 *
	 * @return array
	 **/
	private function getChildren($id) {
		// Query for all pages, saving them to a instance varibale so we only make the db call once
		$wp_query = new WP_Query();
		$this->pages = $wp_query->query(array('post_type' => 'page', 'posts_per_page' => -1));

		// Using the native get_children function to find all the pages that are decendants of 
		// current page
		$children = get_page_children($id, $this->pages);

		foreach ($children as $child) {
			$this->children[$child->ID] = $child;
		}

		return $this->constructTree($id);
	}

	/**
	 * Constructs the tree by calling itself recusively on all children till no descendants are found
	 *
	 * @return array
	 **/
	private function constructTree($parent_id) {
		$children = get_page_children($parent_id, $this->pages);
		$branch = array();
		if (!empty($children) && !empty($this->children)) {
			foreach ($children as $child) {
				if ($child->post_parent == $parent_id) {
					$branch[$child->ID] = array(
						'object' 	=> $child,
						'children'	=> $this->constructTree($child->ID)
					);
					unset($this->children[$child->ID]);
				}
			}
		}
		return $branch;
	}


} // END class SomcSubpagesIztokSvetik 