<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

include 'Plugins/simple_html_dom.php';

class PhotosController extends Controller {

    protected $_ignorePictures = array(
        "skyscrapercity_logo",
        "skyscrapercity_name",
        "images/buttons",
        "images/statusicon/",
        "images/smilies",
        "customavatars",
        "google_search",
        "navbits"
    );
    protected $_headersError = array(
        "HTTP/1.0 404 Not Found",
        "HTTP/1.1 404 Not Found",
        "HTTP/1.0 500 Internal Server Error",
        "HTTP/1.1 500 Internal Server Error"
    );

    public function index() {

        $params = array(
            'title' => config('app.title')['main'],
            'topic' => 'Add photos',
            'countries' => $this->getCountryList()
        );

        return view("main.add-photos")->with($params);
    }

    public function add(Request $request) {

        $canAdd = false;
        $country = Input::get('country');

        if ($country == 'Choose...') {
            $validated = $request->validate([
                'country' => 'required',
            ]);
        } else {
            $canAdd = true;
            $city = Input::get('city');
            $url = Input::get('url');
            $pages = Input::get('pages');
        }

        if ($canAdd) {
            if (isset($city)) {
                $this->addCity($country, $city);
            }
            
            if (isset($url)) {
                for ($index = 1; $index <= $pages; $index++) {
                    $page = $url . $index;
                    $content = file_get_contents($page);
                    $html = file_get_html($content);
                    foreach ($html->find("img") as $key => $element) {
                        if (!$this->checkIgnoringImages($element->src)) {
                            $headers = @get_headers($element->src);
                            if (is_array($headers)) {
                                if (in_array($headers[0], $this->_headersError)) {
                                    continue;
                                }

                                if (isset($headers[9]) && strpos($headers[9], "photo_unavailable") !== false) {
                                    continue;
                                }
                            }
                            echo $element;
                        }
                    }
                }
            }
        }
//        $page = "https://www.skyscrapercity.com/showthread.php?t=256102&page=";
//        $start = microtime(true);
//        $images = array(
//            "http://www.teslasociety.com/pec2.jpg",
//            "http://www.bbc.co.uk/guernsey/content/images/2005/11/03/mines_awareness11_470x352.jpg",
//            "http://farm3.static.flickr.com/2276/2093604076_e8352e236c.jpg?v=0",
//            "http://i258.photobucket.com/albums/hh276/Pejon07/560902614_f4174139c5_b.jpg",
//            "http://i258.photobucket.com/albums/hh276/Pejon07/516053890_b4662335e2_o.jpg"
//        );
//        foreach ($images as $src) {
//            $results = DB::select('select * from images where src = :src', ['src' => $src]);
//            
//            if (empty($results)) {
//                DB::insert('insert into images (src) values (?)', [$src]);
//            }
//        }
//        $images = DB::select('SELECT * FROM `images`', [1]);
//        foreach ($images as $src) {
//            echo $src->src . "<br>";
//            echo "<img src=\"$src\">";
//        }
//        for ($index = 1; $index <= 1; $index++) {
//            $url = $page . $index;
//            $content = file_get_contents($url);
//            $html = file_get_html($content);
//            foreach ($html->find("img") as $imageKey => $element) {
//                if (!$this->checkIgnoringImages($element->src)) {
//                    $headers = @get_headers($element->src);
//                    if (is_array($headers)) {
//                        if (in_array($headers[0], $this->_headersError)) {
//                            continue;
//                        }
//                        
//                        if (isset($headers[9]) && strpos($headers[9], "photo_unavailable") !== false) {
//                            continue;
//                        }
//                        
////                        foreach ($headers as $key => $value) {
////                            echo "[$key] => $value<br>";
////                        }
//                    }
//                    
//                    echo $element;
//                    
////                    if ($imageKey > 7) {
////                        exit;
////                    }
//                }
//            }
//        }
//        $end = microtime(true);
//        $seconds = $end - $start;
//        echo "<br><br>This script took " . $seconds . " s";
    }

    public function checkIgnoringImages($imageSrc) {
        $ignored = false;
        foreach ($this->_ignorePictures as $src) {
            if (strpos($imageSrc, $src) !== false) {
                $ignored = true;
            }
        }
        return $ignored;
    }

    public function getCountryList() {
        $countries = DB::select('SELECT * FROM `countries`', [1]);
        return $countries;
    }

    public function addCity($country, $city) {
        $results = DB::select('SELECT * FROM cities WHERE country_id = :country_id AND city = :city', ['country_id' => $country, 'city' => $city]);

        if (empty($results)) {
            DB::insert('INSERT INTO cities (country_id, city) VALUES (?, ?)', [$country, $city]);
        }
    }

}
