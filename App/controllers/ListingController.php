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
     * @param array $params
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

        $requiredFeilds = ['title', 'description', 'salary', 'city', 'state', 'email'];

        $errors = [];
        foreach ($requiredFeilds as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . " is required";
            }
        }
        if (!empty($errors)) {
            loadView('listings/create', ['errors' => $errors, "newListingData" => $newListingData]);
        } else {

            $fields = [];
            $value = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }

            $fields = implode(", ", $fields);
            $values = implode(", ", $values);

            $this->db->query("INSERT INTO listings ($fields) VALUES ($values)", $newListingData);
            redirect('/listings');
        }
    }

    /**
     * Delete Listing
     * 
     * @param mixed $param
     * @return void
     */
    function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];

        $fetchedID = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
        if (!$fetchedID) {
            return ErrorController::notFound("Listing not found");
        } else {
            $this->db->query("DELETE FROM listings WHERE id = :id", $params);
            $_SESSION['message_error'] = "Listing deleted successfully";
            redirect('/listings');
        }
    }

    /**
     * show edit
     * @param array $params
     * @return void
     */


    function edit($params)
    {
        $id = $params['id'] ?? "";
        $params = [
            'id' => $id,
        ];
        $listing = $this->db->query("SELECT * FROM listings WHERE id = $id")->fetch();

        if (!$listing) {
            return ErrorController::notFound("Listing not found");
        }

        loadView('listings/edit', [
            'listingData' => $listing,
        ]);
    }

    /**
     * Update Listing
     * 
     * @param array $params
     * @return void
     */

    function update($params)
    {
        $id = $params['id'] ?? "";
        $params = [
            'id' => $id,
        ];
        $listing = $this->db->query("SELECT * FROM listings WHERE id = $id")->fetch();

        if (!$listing) {
            return ErrorController::notFound("Listing not found");
        } else {
            $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

            $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));

            $updatedValues = array_map('sanitize', $updatedValues);

            $requiredFeilds = ['title', 'description', 'salary', 'city', 'state', 'email'];

            $error = [];

            foreach ($requiredFeilds as $field) {
                if (empty($updatedValues[$field]) || !Validation::string($updatedValues[$field])) {
                    $error[$field] = ucfirst($field) . " is required";
                }
            }
            if (!empty($errors)) {
                loadView('listings/edit', ['errors' => $errors, "listingData" => $listing]);
            }
            else {
                $updatedFields=[];
                foreach(array_keys($updatedValues) as $field){
                    $updatedFields[] = "$field = :$field";
                }
                $updatedFields = implode(", ", $updatedFields);
                $sql = "UPDATE listings SET $updatedFields WHERE id = :id";
                $params = array_merge($params, $updatedValues);

                $this->db->query($sql, $params);
                $_SESSION['message_success'] = "Listing updated successfully";
                redirect('/listings/'. $id);               
            }
        }
    }
}
