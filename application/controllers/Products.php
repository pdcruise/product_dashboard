<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    /* Docu: This method is called upon login attempt. Gets all products.
        Owner: Phil */
    public function dashboard()
    {    
        $data['products'] = $this->populate_products();
        $this->load->view('partials/header');
        $this->load->view('users/dashboard', $data);
        $this->load->view('partials/footer');
    }
    /* Docu: This method is called when a user wants to put a new item/product  
        Owner: Phil*/
    public function new($message = null)
    {
        $data['message'] = $message;
        $this->load->view('partials/header');
        $this->load->view('products/new', $data);
        $this->load->view('partials/footer');
    }
    /* Docu: This method is called when a user wants to edit an existing item/product  
        Owner: Phil*/
    public function edit($id, $message = null)
    {
        $data['item'] = $this->get_product($id);
        $data['message'] = $message;
        $this->load->view('partials/header');
        $this->load->view('products/edit', $data);
        $this->load->view('partials/footer');
    }
    /* Docu: This method is called when a user wants to view an existing item/product  
        Owner: Phil*/
    public function show($id)
    {
        $item = $this->get_product($id);
        $this->load->model('comment');
        $user_reviews= $this->comment->get_reviews_by_product_id($id);
        $this->load->model('message');

        $content = array();
        foreach($user_reviews as $review) 
        {
            $messages = $this->message->get_messages_by_review_id($review['review_id']);
            $review['messages'] = $messages;
            $content[] = $review;
        }
        $data = array("item" => $item,"contents" => $content);

        $this->load->view('partials/header');
        $this->load->view('products/show', $data);
        $this->load->view('partials/footer');
    }
    /* Docu: This method is triggered when the form for adding a new item/product is submitted 
        Owner: Phil*/
    public function process_new_product()
    {
        $result = $this->product->validate_product();

        if ($result != 'success')
        {
            $this->new();
        }
        else
        {
            $form_input = $this->input->post();
            $this->product->add_product($form_input);
            $message = 'Product "'.$form_input['name'].'" Successfully Added!';
            $this->new($message);
        }
    }
    /* Docu: This method is called when a user goes to the dashboard. Gets all products.  
        Owner: Phil*/
    public function populate_products()
    {
        return $this->product->get_products();
    }
    /* Docu: This method is called when a user wanted to edit/update an item/product. Fetches and returns the data of the submitted item id.  
        Owner: Phil*/
    public function get_product($id)
    {
        return $this->product->get_product_by_id($id);
    }
    /* Docu: This method is triggered upon visiting the page that shows the product details. Gets all messages based on review id.  
        Owner: Phil*/
    public function get_messages($id)
    {
        return $this->product->get_messages_by_review_id($id);
    }
    /* Docu: This method is called when a user submitted a form from product edit. Validates the field submitted and if valid, updates item info.  
        Owner: Phil*/
    public function process_edit($id)
    {
        $result = $this->product->validate_product();

        if ($result != 'success')
        {
            $this->edit($id);
        }
        else
        {
            $form_input = $this->input->post();
            $this->product->update_item($id, $form_input);
            $message = 'Item '.$form_input['name'].' successfully updated';
            $this->edit($id, $message);
        }
    }
    /* Docu: This method is called when remove link is clicked and the action was confirmed. This will delete the selected item.  
        Owner: Phil*/
    public function delete($id)
    {
        $this->product->delete_product($id);
        redirect('dashboard');
    }
    /* Docu: This method is called when user entered a review for a product.  
        Owner: Phil*/
    public function review($id)
    {
        $this->load->model('comment');
        $result = $this->comment->validate_review();

        if ($result != 'success')
        {
            $this->show($id);
        }
        else
        {
            $data = $this->input->post();
            $this->comment->add_review($data, $id);
            redirect('products/show/'.$id.'');
        }
    }
    /* Docu: This method is called when user entered a reply/message for a product. Validates the data and if valid insert data into the system. 
        Owner: Phil*/
    public function message($review_id, $item_id)
    {
        $this->load->model('message');
        $result = $this->message->validate_message();

        if ($result != 'success')
        {
            $this->show($item_id);
        }
        else
        {
            $data = $this->input->post();
            $this->message->add_message($data, $review_id);
            redirect('products/show/'.$item_id.'');
        }
    }
}
