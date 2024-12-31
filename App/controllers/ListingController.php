<?php

namespace App\controllers;

use Framework\Database;

class ListingController
{
    protected $db;
    public function __construct()
    {
        $config = require basePath("config/db.php");
        $this->db = new Database($config);
    }

    /**
     * Show Listing
     * 
     * @return void
     */

    function index()
    {
        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    /**
     * Create Listing
     * 
     * @return void
     */

    function create()
    {
        loadView('listings/create');
    }


    /**
     * Show all Listings
     *
     * @return void
     */


    function show($params)
    {
        $id = $params['id'] ?? "";
        $params = [
            'id' => $id,
        ];
        $listing = $this->db->query("SELECT * FROM listings WHERE id = $id")->fetch();

        if (!$listing) {
            return ErrorController::notFound("Listing not found");
        }

        loadView('listings/show', [
            'listing' => $listing,
        ]);
    }
}
