<?php

namespace App\Http\Controllers;

use Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DoctorController extends Controller
{

	private function getFieldsAndValuesString(){
		// $fields = Input::except('_token');
		$fields = json_decode(file_get_contents('php://input'), true);
		if (isset($fields['_token'])) {
			unset($fields['_token']);
		}
		$fieldsString = '';
		$valuesString = '';
		foreach ($fields as $key => $value) {
			$valuesString .= ':' . $key . ', ';
			$fieldsString .= $key . ', ';
		}
		$fieldsString = substr($fieldsString, 0, strlen($fieldsString)-2);
		$valuesString = substr($valuesString, 0, strlen($valuesString)-2);
		return [
			'fields' => $fields,
			'fieldsString' => $fieldsString,
			'valuesString' => $valuesString
		];
	}

	public function index() {
		$doctors = DB::select('SELECT * FROM doctors');
        return $doctors;
        // return view('user.index', ['doctors' => $doctors]);
	}

	public function add() {
		if (Request::isMethod('post')) {
			$r = $this->getFieldsAndValuesString();
			DB::insert('INSERT INTO doctors ('.$r['fieldsString'].') VALUES ('. $r['valuesString'] .')', $r['fields']);
			return $this->index();
		}
	}

	public function edit($id = null) {
		if (!$id)
			return "ID richiesto";

		if (Request::isMethod('post')) {
			// $fields = Input::except('_token');
			$fields = json_decode(file_get_contents('php://input'), true);
			if (isset($fields['_token'])) {
				unset($fields['_token']);
			}
			$fields['id'] = $id;
			$values = '';
			foreach ($fields as $key => $value) {
				if ($key != 'id') {
					$values .= $key . ' = ' . ':' . $key . ', ';
				}
			}
			$values = substr($values, 0, strlen($values)-2);
			/*$affected = */DB::update('UPDATE doctors SET ' . $values . ' WHERE id = :id', $fields);
			return $this->index();
		}
	}

	public function delete($id = null) {
		if ($id) {
			/*$deleted = */DB::delete('DELETE FROM doctors WHERE id = :id', ['id' => $id]);
			return $this->index();
		} else {
			return "ID richiesto";
		}
	}

}
