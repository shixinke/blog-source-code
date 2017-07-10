<?php
class Cart
{
	private $filename;
	private $data = array();
	private $result = array('code'=>200, 'message'=>'success', 'data'=>array());
	public function __construct($filename = "cart.json") {
		$this->filename = $filename;
		try {
			$content = file_get_contents($filename);
			$this->data = json_decode($content, true);
		} catch (Exception $e) {
			$this->result['code'] = $e->getCode();
			$this->result['message'] = '获取数据失败';
			$this->json($this->result);
		}
		if (count($this->data) > 0) {
			$this->data = array_column($this->data, NULL, 'id');
		}
	}
	
	public function lists() {
		$this->result['data'] = $this->obj2arr();
        $this->json($this->result);
	}
	
	public function add() {
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$count = isset($_POST['count']) ? intval($_POST['count']) : 1;
		if ($id < 1) {
			$this->result['code'] = 5001;
			$this->result['message'] = '请选择要添加的商品';
			$this->json($this->result);
		}
		if (isset($this->data[$id])) {
			$this->data[$id]['count'] += $count;
		} else {
			$tmp = array(
				'id'=>$id,
				'count'=>$count,
				'name'=>'商品'.$id
			);
			$this->data[$id] = $tmp;
		}
		$res = $this->save();
		if ($res) {
		    $this->result['data']['count'] = $count;
			$this->result['data']['total'] = $this->getCount();
		} else {
			$this->result['code'] = 5005;
			$this->result['message'] = "添加失败";
			
		}
		$this->json($this->result);
	}
	
	public function plus() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id < 1) {
            $this->result['code'] = 5001;
            $this->result['message'] = '请选择要添加的商品';
            $this->json($this->result);
        }
        if (!isset($this->data[$id])) {
            $this->result['code'] = 5002;
            $this->result['message'] = '商品不存在';
            $this->json($this->result);
        }
        $this->data[$id]['count'] += 1;
        $res = $this->save();
        if ($res) {
            $this->result['data']['count'] = $this->data[$id]['count'];
            $this->result['data']['total'] = $this->getCount();
        } else {
            $this->result['code'] = 5005;
            $this->result['message'] = "添加失败";

        }
        $this->json($this->result);
	}

	public function minus() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id < 1) {
            $this->result['code'] = 5001;
            $this->result['message'] = '请选择要添加的商品';
            $this->json($this->result);
        }
        if (!isset($this->data[$id])) {
            $this->result['code'] = 5002;
            $this->result['message'] = '商品不存在';
            $this->json($this->result);
        }
        $this->result['data']['remain'] = true;
        if ($this->data[$id]['count'] == 1) {
            unset($this->data[$id]);
            $this->result['data']['remain'] = false;
        } else {
            $this->data[$id]['count'] -= 1;
        }
        $res = $this->save();
        if ($res) {
            $this->result['data']['count'] = $this->result['data']['remain'] ? $this->data[$id]['count'] : 0;
            $this->result['data']['total'] = $this->getCount();
        } else {
            $this->result['code'] = 5005;
            $this->result['message'] = "添加失败";

        }
        $this->json($this->result);
    }


	
	public function del() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id < 1) {
            $this->result['code'] = 5001;
            $this->result['message'] = '请选择要添加的商品';
            $this->json($this->result);
        }
        if (!isset($this->data[$id])) {
            $this->result['code'] = 5002;
            $this->result['message'] = '商品不存在';
            $this->json($this->result);
        }
        unset($this->data[$id]);
        $res = $this->save();
        if ($res) {
            $this->result['data'] = $this->getCount();
        } else {
            $this->result['code'] = 5005;
            $this->result['message'] = "删除失败";

        }
        $this->json($this->result);
	}
	
	public function count() {
		$this->result['data'] = $this->getCount();
		$this->json($this->result);
	}

	private function getCount() {
        $count = 0;
        if (!empty($this->data)) {
            foreach ($this->data as $value) {
                $count += $value['count'];
            }
        }
        return $count;
    }

    private function obj2arr() {
        $data = array();
        foreach($this->data as $value) {
            $data[] = $value;
        }
        return $data;
    }
	
	private function save() {
		$data = $this->obj2arr();
		return file_put_contents($this->filename, json_encode($data));
	}
	
	private function json($data) {
		exit(json_encode($data));
	}
}

$cart = new Cart();
$action = isset($_GET['action']) ? trim($_GET['action']) : 'lists';
if (method_exists($cart, $action)) {
	$cart->$action();
} else {
	exit(json_encode(array('code'=>404, 'message'=>'page not found')));
}

