<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Model
{
    /* Docu: This method is called after submitting a form for adding new products. This checks if all input data are properly filled.
        Owner: Phil*/
    public function validate_product()
    {
        $this->form_validation->set_rules('name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('description', 'Product Description', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'numeric|trim|required');
        $this->form_validation->set_rules('count', 'Inventory Count', 'numeric|trim|required');
        if(!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return "success";
        }
    }
    /* Docu: This method is called after successful product validation. Inserts the data into the database.
        Owner: Phil*/
    public function add_product($form_input)
    {
        $query = "INSERT INTO products (name, description, price, inventory_count, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $values = array(
            $this->security->xss_clean($form_input['name']),
            $this->security->xss_clean($form_input['description']),
            $this->security->xss_clean($form_input['price']),
            $this->security->xss_clean($form_input['count']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean(date('Y-m-d H:i:s'))
        );
        return $this->db->query($query, $values);
    }
    /* Docu: This method is called to get all products and their sold quantity
        Owner: Phil*/
    public function get_products()
    {
        $query = "SELECT products.id AS id, name, price, inventory_count, COALESCE(SUM(sold_products.quantity),0) AS sold 
                    FROM products LEFT JOIN sold_products ON products.id = sold_products.product_id
                    GROUP BY products.id";
        return $this->db->query($query)->result_array();
    }
    /* Docu: This method is called to get product details based on the supplied item id. Used on editing items.
        Owner: Phil*/
    public function get_product_by_id($id)
    {
        $query = "SELECT products.id, name, description, price, inventory_count, products.created_at AS added_since, COALESCE(SUM(quantity), 0) AS sold
                    FROM products LEFT JOIN sold_products ON products.id = sold_products.product_id WHERE products.id = ?;";
        return $this->db->query($query, array($id))->row_array();
    }
    /* Docu: This method is triggered when an item edit has passed validation. Cleans post data and updates the item depending on supplied item id.
        Owner: Phil*/
    public function update_item($id, $form_input)
    {
        $query = "UPDATE products SET name = ?, description = ?, price = ?, inventory_count = ?, updated_at = ? WHERE id = ?";
        $values = array(
            $this->security->xss_clean($form_input['name']),
            $this->security->xss_clean($form_input['description']),
            $this->security->xss_clean($form_input['price']),
            $this->security->xss_clean($form_input['count']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean($id)
        );
        return $this->db->query($query, $values);
    }
    /* Docu: This method is triggered when an item is confirmed to be deleted. Completely removes the item.
        Owner: Phil*/
    public function delete_product($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        return $this->db->query($query, array($id));
    }

}
