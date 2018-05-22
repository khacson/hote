<?php
/**
 * @author Sonnk
 * @copyright 2011
 */
 
class incModelMenu extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getMenu($groupid){	
		#region Phan quyen
		$login = $this->site->getSession('login');
		$params = $login->params;
		$right_page = "";
		foreach($params as $p=>$right){
			$right_page.= ",'".$p."'";
		}
		#end 
		$uri = $this->uri->segment(1);
		$right_page = substr($right_page,1).",'#'";  
		$lang = $this->site->GetSession("language"); //print_r($lang['menu']); exit;
		$right = '';
		$sql = "
				select gm.`name` as menuName, gm.keylang, gm.ordering, gm.route as controller, gm.classicon, gm.id as pageid
				from hotel_menus gm
				where gm.parent = 0
				and gm.isdelete = 0
				and gm.route in ($right_page)
				order by gm.ordering asc
		";
		$parent_menu = $this->model->query($sql)->execute();
		$menu = '';
		$i=1;
		$Active = $this->getActive();
		$arrActive1 = $Active['array'];
		$arrActive = $Active['array2']; 
		foreach($parent_menu as $item){
			$active = '';
			if(empty($uri) || $uri == 'home'){
				if($i==1){
					$active = 'active';		
				}
			}
			else{
				if(isset($arrActive1[$uri]) && $arrActive1[$uri] == $item->pageid){
					$active = 'active';		
				}
			}
			$asub = $this->getChildren($item->pageid,$groupid,$right,$lang,$right_page,$arrActive);
			$menuName = $item->menuName;
            if($asub){
				if(isset($lang['menu'][trim($item->keylang)])){
					$menuName = $lang['menu'][trim($item->keylang)];
				}
				$menu.= '<li class="parent-munu '.$active.'">
				<a href="javascript:;">
				<i class="fa '.($item->classicon).'"></i>
				<span class="title">
				'.$menuName.'
				</span>
				<span class="arrow"></span>
				</a>';
				$menu.= '<ul class="sub-menu">';
				$menu.= $asub;
				$menu.= '</ul>';
				$menu.= '</li>';
			}
			else{
				if($item->controller != '#'){
					if($uri == $item->controller){
						$active = 'active';		
					}
					else{
						$active = '';	
					}
					$html = '.html';
					if($item->controller == 'guide'){
						$html = '';
					}
					$menu.='<li class="'.$active.'">
					<a href="'.base_url().($item->controller).$html.'">
					<i class="fa '.($item->classicon).'"></i>
					<span class="title">'.$menuName.'</span>
					</a>
					</li>';  
				}
			}
			$i++;
		}
		return $menu;	
    }
    private function getChildren($id,$groupid,$right,$lang,$right_page,$arrActive){
		//$controller = 'route';
		$sql = "
				select gm.id, gm.`name` as menuName, gm.keylang, gm.ordering, gm.route as controller, gm.classicon, gm.id as pageid
				from hotel_menus gm
				where gm.parent = $id
				and gm.isdelete = 0
				and gm.route in ($right_page)
				order by gm.ordering asc;
		";
		/*and gm.id in ($right)*/
		$children = $this->model->query($sql)->execute();
		$uri = $this->uri->segment(1);					
        $menu = '';
		foreach($children as $item){
			 if(isset($arrActive[$uri]) && $arrActive[$uri] == $item->pageid){
				$open = 'open';	
				$display = 'style="display: block !important;"';
			 }
			 else{
				$open = '';	
				$display = '';
			 }
			 $plus = '';	
			 $asub = $this->getChildren($item->pageid,$groupid,$right,$lang,$right_page,$arrActive); 
			 if(isset($lang['menu'][trim($item->keylang)])){
				$menuName = $lang['menu'][trim($item->keylang)];
			 }
			 else{
				$menuName = $item->menuName;
			 }	
			 $linone = '';
			 if(empty($item->controller)){
				$linone = 'menu-li-none';
			 }
			 if($asub){
				 $menu.= '<li class="childrens li-children '.$open.'">
				 <a href="javascript:;">
				 <i class="fa '.$item->classicon .'"></i>
				 <span class="title">
				 '.$menuName.'
				 </span>
				 '.$plus.'<span class="arrow ">
				 </span>
				 </a>';
				$menu.= '<ul class="sub-menu sub-menu2" '.$display.' >';
				$menu.=$asub;
				$menu.='</ul></li>';
			 }
			 else{
				if($uri == $item->controller){
					 $active = 'active';		
				}
				else{
					 $active = '';	
				}
				
				$menu.='<li class=" '.$active.' '.$linone.'"><a href="'.base_url().($item->controller).'.html">'.$menuName.$plus.'</a></li>';
			 }
		}
		return $menu;
    } 
	function getActive(){
		$sql = "
			SELECT m.route, m.id, m.parent as parents,
			(select parent
			from hotel_menus where id =  m.parent
			) as parent_node
			FROM hotel_menus m 
			where m.isdelete = 0
			and m.parent <> 0
		";
		$query = $this->model->query($sql)->execute();
		$array = array();
		$array2 = array();
		foreach($query as $item){
			if(empty($item->parent_node)){
				$array[$item->route] = $item->parents;	
			}
			else{
				$array[$item->route] = $item->parent_node;	
			}
			$array2[$item->route] = $item->parents;	
		}
		$data['array'] = $array;
		$data['array2'] = $array2;
		return $data;
	}
}