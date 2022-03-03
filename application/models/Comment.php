<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Model
{
    /* Docu: This method is triggered when an item was viewed. Gets all the review associated with the item baed on its id.
    Owner: Phil*/
    public function get_reviews_by_product_id($id)
    {
        $query = 'SELECT reviews.id AS review_id, CONCAT(first_name, " ", last_name) AS name, reviews.created_at AS created_at, review FROM reviews 
                    LEFT JOIN users ON reviews.user_id = users.id WHERE product_id = ?
                    ORDER BY created_at DESC';
        return $this->db->query($query, array($id))->result_array();
    }
    /* Docu: This method is called once a user submitted a review. Validates if the review input field is not empty.
    Owner: Phil*/
    public function validate_review()
    {
        $this->form_validation->set_rules('review','Review','trim|required');

        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return 'success';
        }
    }
    /* Docu: This method is called once a user submitted a review it passed the validation. Inserts the review to the database.
    Owner: Phil*/
    public function add_review($data, $product_id)
    {
        $query = "INSERT INTO reviews (user_id, product_id, review, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?)";
        $values = array(
            $this->security->xss_clean($this->session->userdata('user_id')),
            $this->security->xss_clean($product_id),
            $this->security->xss_clean($data['review']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
        );
        $this->db->query($query, $values);
    }

}
