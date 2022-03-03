<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message extends CI_Model
{ 
    /* Docu:    Method is automatically called when the user accesses the products view. Gets all messages based on passed review id
    Owner: Phil*/
    public function get_messages_by_review_id($id)
    {
        $query = 'SELECT reviews.id AS review_id, messages.id AS message_id, message, users.id AS user_id,
		            CONCAT(first_name, " ", last_name) AS name, messages.created_at AS created_at
                    FROM messages
                    LEFT JOIN reviews ON reviews.id = messages.review_id
                    LEFT JOIN users ON messages.user_id = users.id
                    WHERE reviews.id = ?
                    ORDER BY created_at DESC';
        return $this->db->query($query, array($id))->result_array();
    }
    /* Docu: Method is called after user submitted a reply/message. Validates the reply/message.
    Owner: Phil*/
    public function validate_message()
    {
        $this->form_validation->set_rules('message','Message','trim|required');

        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return 'success';
        }
    }
    /* Docu: This method is called once a user submitted a reply/message and passed the validation. Inserts the reply/message to the database.
    Owner: Phil*/
    public function add_message($data, $review_id)
    {
        $query = "INSERT INTO messages (user_id, review_id, message, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?)";
        $values = array(
            $this->security->xss_clean($this->session->userdata('user_id')),
            $this->security->xss_clean($review_id),
            $this->security->xss_clean($data['message']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
        );
        $this->db->query($query, $values);
    }

}
