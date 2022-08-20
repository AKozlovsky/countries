<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MainController extends Controller {

    public function index() {
        $params = array(
            'title' => config('app.title')['main'],
            'topic' => 'Home',
            'countries' => $this->getCountries(),
            'cities' => $this->getCities()
        );
        return view('main.index')->with($params);
    }

    private function getCountries() {
        $selectList = array();        
        $cities = DB::select('SELECT * FROM `cities`', [1]);
        foreach ($cities as $value) {
            $countries = DB::select('SELECT * FROM `countries` WHERE id = :country_id', ['country_id' => $value->country_id]);
            $selectList[] = $countries[0]->country_name;
        }
        $selectList = array_unique($selectList);
        return $selectList;
    }
    
    public function getCities() {
        $list = array();
        $cities = DB::select('SELECT * FROM `cities`', [1]);
        foreach ($cities as $value) {
            $countries = DB::select('SELECT * FROM `countries` WHERE id = :country_id', ['country_id' => $value->country_id]);
            $list['country'][] = $countries[0]->country_name;
            $list['city'][] = $value->city;
        }
        return $list;
    }

    public function selectCountry(Request $request) {
        $name = Input::get('country');
        if ($name == 'Choose...') {
            $validated = $request->validate([
                'select country' => 'required',
            ]);
        } else {
            return redirect('select/' . $name);
        }
    }
}
