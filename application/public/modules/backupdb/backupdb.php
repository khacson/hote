<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 
 * @copyright 2015
 */
class Backupdb extends CI_Controller {

    private $route;
    private $login;

    function __construct() {
        parent::__construct();
        $this->load->model(array('model', 'base_model'));
        $this->login = $this->site->getSession('login');
        $this->route = $this->router->class;
        $menus = $this->site->getSession('menus');
        $this->title = $menus[$this->route];
        $this->load->library('upload');
    }

    function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }

    function _view() {
        $data = new stdClass();
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        $data->permission = $permission;
        $data->csrfName = $this->security->get_csrf_token_name();
        $data->csrfHash = $this->security->get_csrf_hash();
        $data->routes = $this->route;
        $data->login = $this->login;
        $data->controller = base_url() . ($this->uri->segment(1));
        $data->groups = $this->base_model->getGroup('');

        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->write('title', $this->title, true);
        $this->site->render();
    }

    function getList() {
        $param = array();
        $numrows = 20;
        $data = new stdClass();
        $index = $this->input->post('index');
        $order = $this->input->post('order');
		if(!empty($order)) {
            $order = str_replace('ord_', '', $order);
        }
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        $search = json_decode($search, true);
        $search['index'] = $index;
        $search['order'] = $order;
        $query = $this->model->getList($search, $page, $numrows);
        $data->start = empty($page) ? 1 : $page + 1;

        $count = $this->model->getTotal($search);
        $data->datas = $query;
        $page_view = $this->site->pagination($count, $numrows, 5, 'manufacture/', $page);
        $data->permission = $this->base_model->getPermission($this->login, $this->route);
        $result = new stdClass();
        $result->paging = $page_view;
        $result->cPage = $page;
        $result->viewtotal = $count;
        $result->csrfHash = $this->security->get_csrf_hash();
        $result->content = $this->load->view('list', $data, true);
        echo json_encode($result);
    }
	function backup(){
		$time = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		//Tao folder luu tru
		$folder = 'backup/'.gmdate("YmdHis", time() + 7 * 3600);
		$filName = gmdate("YmdHis", time() + 7 * 3600);
		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}
		$db = array();
		$db['host']= $this->db->hostname;
		$db['user']= $this->db->username;
		$db['pass']= $this->db->password;
		$db['name']= $this->db->database;
		$sqlTb = "
			SELECT table_name, table_type, engine
			FROM information_schema.tables
			WHERE table_schema = '".$db['name']."'
			/*AND table_name = 'phone_terms_of_use'*/
			ORDER BY table_name DESC;
		";
		$query = $this->model->query($sqlTb)->execute();
		foreach($query as $item){
			$table = $item->table_name;	
			$data = $this->backup_tables($db,$table,$folder);
			$filename = $table.'.sql'; 
			$handle = fopen($folder.'/'.$filename,'w+');
			fwrite($handle,$data);
			fclose($handle);
		}
		$array = array();
		$array['dbname'] = $filName;
		$array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
		$array['usercreate'] = $this->login->username;
		$this->model->insert($array);
		//Zip file
		$zipFile = 'backup/'.$filName;
		$result = $this->addzip($zipFile,'backup/'.$filName.'.zip');
		echo $result;
	}
	function create_zip($files = array(), $dest = '', $overwrite = false) {
		if (file_exists($dest) && !$overwrite) { 
			return false;
		}
		if (($files)) {
			$zip = new ZipArchive();
			if ($zip->open($dest, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			foreach ($files as $file) {
				$zip->addFile($file, $file);
			}
			$zip->close();
			return file_exists($dest);
		} else {
			return false;
		}
	}
	function addzip($source, $destination) {
		$files_to_zip = glob($source . '/*');
		$ch = $this->create_zip($files_to_zip, $destination);
		return $ch;
	}
	function backup_tables($db, $tables = '*',$folder) {
        $link = mysql_connect($db['host'], $db['user'], $db['pass']);
        mysql_set_charset('utf8', $link);
        mysql_select_db($db['name'], $link);
        //get all of the tables
        $tables = is_array($tables) ? $tables : explode(',', $tables);
        $return = "";
        //cycle through
        foreach ($tables as $table) {
            $result = mysql_query("SELECT * FROM " . $table);
            $num_fields = mysql_num_fields($result);
            $return.= 'DROP TABLE IF EXISTS ' . $table . ';' . PHP_EOL;
            $row2 = str_replace("\n", "\n" . PHP_EOL, mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table)));
            $return.= "\n\n" . $row2[1] . ";\n\n" . PHP_EOL;
			$countRow = $this->model->table($table)->select('count(1) as total')->find()->total;
            for ($i = 0; $i < $num_fields; $i++) {
                $id = 0;
                while ($row = mysql_fetch_row($result)) {
                    $id++;
					if($id == 1){
						$return.= 'INSERT INTO ' . $table . ' VALUES';
					}
					$return.= '(';
                    for ($j = 0; $j < $num_fields; $j++) { //Num Field -1 vi bo id
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if ($j == 0 && isset($row[$j])) {
                            $return.= '"' . $id . '"';
                        } elseif (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
					if($id == $countRow){
						$return.= ");\n" . PHP_EOL;
					}
					else{
						$return.= "),\n" . PHP_EOL;	
					}
                }
            }
            $return.="\n\n\n" . PHP_EOL;
        }
        return $return;
    }
}