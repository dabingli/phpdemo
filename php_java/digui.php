<?php
	$arr = [
		[
			'id'=>'d1111',
			'name'=>'等级',
			'tradeList'=>[
				[
					'id'=>'111',
					'name'=>'金卡',
					'sort'=>'1',
					'create'=>'1231'	
				],
				[
					'id'=>'222',
					'name'=>'金卡',
					'sort'=>'1',
					'create'=>'1231'	
				],
				[
					'id'=>'333',
					'name'=>'金卡',
					'sort'=>'1',
					'create'=>'1231'	
				],
			]
		],
		[
			'id'=>'d222',
			'name'=>'币种',
			'tradeList'=>[
				[
					'id'=>'d1',
					'name'=>'单币种',
					'sort'=>'1',
					'create'=>'1231'	
				],
				[
					'id'=>'d2',
					'name'=>'双币种',
					'sort'=>'1',
					'create'=>'1231'	
				],
				[
					'id'=>'d3',
					'name'=>'混合币种',
					'sort'=>'1',
					'create'=>'1231'	
				],
			]
		],
		
	];

	$field = ['id','name','tradeList'=>['id','name','sort']];
	// $field = ['id','name'];

	function getData($arr, $field){
		$data = [];
		echo '<pre>';
		foreach ($arr as $key => $value) {
			foreach($field as $k=>$f){
				if(is_array($f)){
					$data[$key][$k] = getData($value[$k], $f);
				}else{
					$data[$key][$f] = $value[$f];
				}
				
			}
			
		}

		return $data;
	}

	var_dump(getData($arr, $field));