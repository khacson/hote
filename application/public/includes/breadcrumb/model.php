<?php
/**
 * @author Sonnk
 * @copyright 2015
 */
 
class incModelBreadcrumb extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getMap($control){
		$url = base_url().$control.'.html';
		$query = $this->model->table('hotel_menus')
					  ->select('id,route,name,parent as parents')
					  ->where('route',$control)
					  ->find();
		$li = '';
		if(empty($query->id)){
			return $li;
		}
		if(empty($query->parents)){
			$li = '
				<li>
					<a href="'.$url.'">
						'.$query->name .'
					</a>
				</li>
			';
			return $li;
		}
		else{
			$parents = $query->parents;
			$query2 = $this->model->table('hotel_menus')
					  ->select('id,route,name,parent as parents')
					  ->where('id',$parents)
					  ->find();
			if(empty($query2->parents)){
				$li = '
					<li>
						<a href="#">
							'.$query2->name .'
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="'.$url.'">
							'.$query->name .'
						</a>
					</li>
				';
				return $li;
			}
			else{
				$parents = $query2->parents;
				$query3 = $this->model->table('hotel_menus')
					  ->select('id,route,name,parent as parents')
					  ->where('id',$parents)
					  ->find();
				$li = '
					<li>
						<a href="#">
							'.$query3->name .'
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">
							'.$query2->name .'
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="'.$url.'">
							'.$query->name .'
						</a>
					</li>
				';
				return $li;
			}
		}
	}
}