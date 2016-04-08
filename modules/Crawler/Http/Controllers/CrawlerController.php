<?php namespace Modules\Crawler\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class CrawlerController extends Controller {
	
	public function index()
	{
		return view('Crawler::index');
	}
	
}