<?php 
	namespace App\Models;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class DataItem extends \Illuminate\Database\Eloquent\Model {
		protected $table = '_undefined';
	}

	class Data {
		
		protected $logger;
		protected $values;
		protected $name;
		protected $unique_field;
		protected $instance_id;
		protected $schema;
		protected $table = 'data';

		function __construct($name, $values = [], $unique_field = null){

			if(is_null($name)) return false;
			
			$this->instance_id = null;
			$this->name = $name;

			$this->schema = Capsule::schema();
			if(!empty($values)) {
				$this->values = $values;
			}

			$this->unique_field = $unique_field;
			
			$this->createTable($this->table);

			return $this;
		}

		function getInstanceId() {
			return $this->instance_id;
		}

		function getName() {
			return $this->name;
		}

		function setName($name) {
			$this->name = $name;
		}

		function getValue($field) {
			return $this->values[$field];
		}

		function setValue($field, $value) {
			$this->values[$field] = $value;
		}

		function save() {
			
			if($this->instance_id != null) {
				foreach($this->values as $key=>$value) {
					
					$table = $this->getTableInstance();
					$data = $table->where('field_name', '=', $key)
						->where('instance_id' , '=', $this->instance_id)->first();
					
					if($data) {
						if($data->field_value != $value) {	
							$data->field_value = $value;
							$data->save();
						}
					}else{
						$data = $this->getTableInstance();
						$data->instance_id = $this->instance_id;
						$data->name = $this->name;
						$data->field_name = $key;
						$data->field_value = $value;

						$data->save();
					}
				}
			}else{
				if($this->isValid()) {
					$this->instance_id = $this->createInstanceID();
					foreach ($this->values as $key => $value) {
						$data = $this->getTableInstance();
						$data->instance_id = $this->instance_id;
						$data->name = $this->name;
						$data->field_name = $key;
						$data->field_value = $value;
						$data->save();
					}	
				}	
			}
			
			return $this;
			
		}

		function findOne($field, $logic = "=", $criteria) {
			
			$table = $this->getTableInstance();
			$data = $table->select('instance_id')
					->where('field_name', '=', $field)
				    ->where('field_value' , '=', $criteria)->first();

			$table = $this->getTableInstance();
			$data = $table->select('*')
					->where('instance_id', '=', $data->instance_id)->get();
			
			$this->instance_id = $data[0]->instance_id;
			$this->name = $data[0]->name;
			

			foreach($data as $key=>$value) {
				$this->values[$value->field_name] = $value->field_value;
			}

			return $this;
			
		}

		function setTable($name) {
			$this->table = $name;
		}

		function getTable() {
			return $this->table;
		}

		private function createFields($values = []) {
			if(!self::isAssoc($values)) return false;

			foreach ($values as $key => $value) {
				$this->setValue($key, $value);
			}
		}

		private function isValid() {
			if($this->unique_field == null) return true;
			$table = $this->getTableInstance();
			$data = $table->select("*")
				->where('field_name', '=', $this->unique_field)
				->where('field_value' , '=', $this->values[$this->unique_field])->count();
			
			if($data > 0)  {
				return false;
			}

			return true;
		}

		private function isAssoc($arr)
		{
		    return array_keys($arr) !== range(0, count($arr) - 1);
		}

		private function createInstanceID() {
			return md5(uniqid(rand() . time(), true));
		}

		private function createTable() {

			// Data Table for key-value pair database
			if($this->schema->hasTable($this->table)) return true;

			$this->schema->create($this->table, function($table){
				$table->increments('id');
				$table->char('instance_id', 64);
				$table->char('name', 128);
				$table->char('field_name', 128);
				$table->char('field_value', 128);
				$table->timestamps();
			});
		
			return true;
		}

		private function getTableInstance() {
			$table = new DataItem();
			$table->setTable($this->table);

			return $table;
		}

	}



