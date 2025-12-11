<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetItem;
use App\Models\Book;
use App\Models\Bookcopy;
use App\Models\DepartmentUnit;
use App\Models\FloorLocation;
use App\Models\SalaryGrade;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller {
	public function __construct() {
		$this->middleware('auth:web');
	}

	//Return salary grade
	// public function getSalaryRange(Request $request) {
	// 	$salaryGrade = SalaryGrade::find($request->salary_grade_id);
	// 	if ($salaryGrade) {
	// 		return $salaryGrade->title_salary;
	// 	}
	// 	return '';
	// }

	// public function getAssetCategories(Request $request) {
	// 	if ($request->allStatus) {
	// 		$categories = AssetCategory::where('asset_class_id', $request->asset_class_id)->orderBy('name')->get()->pluck('name_code', 'id')->all();
	// 	} else {
	// 		$categories = AssetCategory::where('asset_class_id', $request->asset_class_id)->where('status', 1)->orderBy('name')->get()->pluck('name_code', 'id')->all();
	// 	}

	// 	$data = '<option value=""></option>';
	// 	foreach ($categories as $key => $value) {
	// 		$data .= '<option value="' . $key . '">' . $value . '</option>';
	// 	}
	// 	return $data;
	// }

	//Sorting Matrices
	// public function sortMatrices(Request $request) {
	// 	foreach ($request->page_id_array as $key => $value) {
	// 		Matrix::where('appraisal_id', $request->appraisal_id)->where('id', $value)->update(['priority' => $key]);
	// 	}
	// 	return response()->json('The Items sorted Successfully.');
	// }

}
