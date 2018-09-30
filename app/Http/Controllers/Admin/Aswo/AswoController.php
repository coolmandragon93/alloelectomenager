<?php

namespace App\Http\Controllers\Admin\Aswo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Aswo;

class AswoController extends Controller
{
	/**
	 * Home page
	 * @return Response
	 */
    public function index()
    {
    	return view("admin.aswo.index");
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function article_pictures_200()
    {
    	return view("admin.aswo.article_pictures_200");
    }
    /**
     * Post Appliance Search
     * @return Response
     */
    public function post_article_pictures_200(Aswo $aswo, Request $request)
    {
        return $aswo->article_pictures_200($request->input());
    }
	/**
	 * Home page
	 * @return Response
	 */
    public function article_pictures_800()
    {
    	return view("admin.aswo.article_pictures_800");
    }
    /**
     * Post Appliance Search
     * @return Response
     */
    public function post_article_pictures_800(Aswo $aswo, Request $request)
    {
        return $aswo->article_pictures_800($request->input());
    }

	/**
	 * Article Search
	 * @return Response
	 */
    public function article_search()
    {
    	return view("admin.aswo.article_search");
    }
    /**
     * Post Appliance Search
     * @return Response
     */
    public function post_article_search(Aswo $aswo, Request $request)
    {
        return $aswo->article_search($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function extended_article_search()
    {
    	return view("admin.aswo.extended_article_search");
    }

    /**
     * Post Appliance Search
     * @return Response
     */
    public function post_extended_article_search(Aswo $aswo, Request $request)
    {
        return $aswo->extended_article_search($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function article_detail_information()
    {    	
    	return view("admin.aswo.article_detail_information");
    }

    /**
	 * Post Appliance Search
	 * @return Response
	 */
    public function post_article_detail_information(Aswo $aswo, Request $request)
    {
    	return $aswo->article_detail_information($request->input());
    }
    

	/**
	 * Home page
	 * @return Response
	 */
    public function suggestlist()
    {
    	return view("admin.aswo.suggestlist");
    }

    /**
     * Home page
     * @return Response
     */
    public function post_suggestlist(Aswo $aswo, Request $request)
    {
        return $aswo->suggestlist($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function article_families()
    {
    	return view("admin.aswo.article_families");
    }

    /**
     * Home page
     * @return Response
     */
    public function post_article_families(Aswo $aswo, Request $request)
    {
        return $aswo->article_families($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function article_for_appliance_search()
    {
    	return view("admin.aswo.article_for_appliance_search");
    }

	/**
	 * Appliance Search
	 * @return Response
	 */
    public function appliance_search()
    {
    	return view("admin.aswo.appliance_search");
    }

	/**
	 * Post Appliance Search
	 * @return Response
	 */
    public function post_appliance_search(Aswo $aswo, Request $request)
    {
    	return $aswo->appliance_search($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function appliance()
    {
    	return view("admin.aswo.appliance");
    }

	/**
	 * Article Families For An Appliance
	 * @return Response
	 */
    public function article_families_for_an_appliance()
    {
    	return view("admin.aswo.article_families_for_an_appliance");
    }

	/**
	 * Post Article Families For An Appliance
	 * @return Response
	 */
    public function post_article_families_for_an_appliance(Aswo $aswo, Request $request)
    {
    	return $aswo->article_families_for_an_appliance($request->input());
    	
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function articles_for_an_appliance()
    {
    	return view("admin.aswo.articles_for_an_appliance");
    }

    /**
     * Home page
     * @return Response
     */
    public function post_articles_for_an_appliance(Aswo $aswo, Request $request)
    {
        return $aswo->articles_for_an_appliance($request->input());
    }
    
	/**
	 * Home page
	 * @return Response
	 */
    public function search_result_quick_check()
    {
    	return view("admin.aswo.search_result_quick_check");
    }
    /**
     * Home page
     * @return Response
     */
    public function post_search_result_quick_check(Aswo $aswo, Request $request)
    {
        return $aswo->search_result_quick_check($request->input());
    }

	/**
	 * Home page
	 * @return Response
	 */
    public function check_list_of_appliances_for_available_articles()
    {
    	return view("admin.aswo.check_list_of_appliances_for_available_articles");
    }

    /**
     * Home page
     * @return Response
     */
    public function post_check_list_of_appliances_for_available_articles(Aswo $aswo, Request $request)
    {
        return $aswo->check_list_of_appliances_for_available_articles($request->input());
    }

}
