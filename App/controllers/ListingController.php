<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;

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

    public function store()
    {
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData['user_id'] = 1;
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFeilds = ['title', 'description', 'city', 'state', 'email'];

        $errors = [];
        foreach ($requiredFeilds as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . " is required";
            }
        }
        if (!empty($errors)) {
            loadView('listings/create', ['errors' => $errors, "newListingData" => $newListingData]);
        } else {
            echo "DATA SUBBMITTED";
        }
    }
}
