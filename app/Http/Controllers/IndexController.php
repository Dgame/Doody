<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;

class IndexController extends Controller
{

    /* Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /*
     * Inserts a Page into the MongoDB
     *
     */
    public function insert()
    {
        $page          = new Page();
        $page->url     = 'http://www.heise.de';
        $page->content = 'tesstestestestestests';
        echo $page->save();
    }

    /**
     * The Search action is called when a search term was tyed in and the search was
     * fired
     * @param string $term the search term
     */
    public function search($term)
    {
        var_dump($term);
    }
}
