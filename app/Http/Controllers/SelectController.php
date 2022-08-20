<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mapper;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

include 'Plugins/simple_html_dom.php';

class SelectController extends Controller
{

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

    public function index(Request $request, $country)
    {
        $params = array(
            'title' => config('app.title')['main'],
            'topic' => 'Home',
        );

        //        $name = Input::get('country');

        return view("main.select")->with($params);
    }

    public function map()
    {
        Mapper::map(53.381128999999990000, -1.470085000000040000);

        $params = array(
            'title' => config('app.title')['main'],
            'topic' => 'Home',
        );

        return view('map.index')->with($params);
    }

    public function photo(Request $request, $city)
    {

        $page = "https://www.skyscrapercity.com/showthread.php?t=256102&page=";

        $start = microtime(true);

        $i = 0;
        while ($i++ < 100000000) {

        }

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

        //         $images = DB::select('SELECT * FROM `images`', [1]);

        //         foreach ($images as $src) {
        //             echo $src->src . "<br>";
        // //            echo "<img src=\"$src\">";
        //         }

        for ($index = 1; $index <= 1; $index++) {
            $url = $page . $index;
            $content = file_get_contents($url);
            $html = file_get_html($content);

            // foreach ($html->find("img") as $imageKey => $element) {
            //     if (!$this->checkIgnoringImages($element->src)) {
            //        $headers = @get_headers($element->src);
            //         if (is_array($headers)) {
            // if (in_array($headers[0], $this->_headersError)) {
            //     continue;
            // }

            // if (isset($headers[9]) && strpos($headers[9], "photo_unavailable") !== false) {
            //     continue;
            // }
            // }

            // echo $element;

            // if ($imageKey > 7) {
            //     exit;
            // }

            //            }
            //        }
        }

        $end = microtime(true);
        $seconds = $end - $start;
        echo "<br><br>This script took " . $seconds . " s";

        $params = array(
            'title' => config('app.title')['main'],
            'topic' => 'Home',
        );

        return view('main.select')->with($params);
    }

    public function checkIgnoringImages($imageSrc)
    {
        $ignored = false;
        foreach ($this->_ignorePictures as $src) {
            if (strpos($imageSrc, $src) !== false) {
                $ignored = true;
            }
        }
        return $ignored;
    }
}
